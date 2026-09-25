<?php

namespace App\Traits;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;

/**
 * Trait للتعامل مع الترجمات المخزنة في ملفات JSON.
 *
 * القاعدة:
 * - العربية تُخزَّن في قاعدة البيانات
 * - الترجمات تُخزَّن في lang/en.json و lang/tr.json
 * - المفتاح في JSON = النص العربي نفسه
 *
 * @example
 * // lang/en.json:
 * // {
 * //   "ملابس": "Clothes",
 * //   "إلكترونيات": "Electronics"
 * // }
 */
trait Translatable
{
    /**
     * عند حذف السجل من قاعدة البيانات، احذف ترجماته من JSON تلقائياً.
     *
     * @example
     * // Category::destroy(1);
     * // => يحذف "ملابس" من lang/en.json و lang/tr.json
     */
    protected static function bootTranslatable(): void
    {
        static::deleted(function ($model) {
            $model->deleteTranslationsFromJson();
        });
    }

    /**
     * الحقول القابلة للترجمة — يجب تعريفها في كل Model.
     *
     * @example
     * // في Category:
     * // return ['name', 'description'];
     */
    abstract public function getTranslatableAttributes(): array;

    /**
     * جلب ترجمة حقل معيّن حسب اللغة.
     *
     * إذا اللغة عربية => يرجع القيمة من قاعدة البيانات مباشرة.
     * إذا لغة أخرى => يبحث في JSON، وإن لم يجد يرجع العربي.
     *
     * @example
     * // $category->name = 'ملابس';
     * // $category->getTranslation('name', 'en') => "Clothes"
     * // $category->getTranslation('name', 'ar') => "ملابس"
     */
    public function getTranslation(string $field, ?string $locale = null): ?string
    {
        $locale = $locale ?? app()->getLocale();
        $value = $this->{$field};

        if ($locale === 'ar' || $value === null || trim((string) $value) === '') {
            return $value;
        }

        return $this->getTranslationFromJson((string) $value, $locale) ?? $value;
    }

    /**
     * هل يوجد ترجمة فعلية لحقل معيّن بلغة معيّنة (بدون fallback للعربي).
     */
    public function hasTranslationFor(string $field, ?string $locale = null): bool
    {
        $locale = $locale ?? app()->getLocale();
        $value = trim((string) ($this->{$field} ?? ''));

        if ($value === '') {
            return false;
        }

        if ($locale === 'ar') {
            return true;
        }

        return $this->getTranslationFromJson($value, $locale) !== null;
    }

    /**
     * هل السجل ظاهر للزائر حسب اللغة الحالية (يعتمد على ترجمة الاسم).
     */
    public function isVisibleForLocale(?string $locale = null): bool
    {
        return $this->hasTranslationFor('name', $locale);
    }

    /**
     * حالة الترجمة لكل حقل وكل لغة مستهدفة.
     *
     * @return array<string, array<string, bool>>
     */
    public function getTranslationStatus(): array
    {
        $status = [];

        foreach ($this->getTranslatableAttributes() as $field) {
            foreach (config('translation.target_locales', ['en', 'tr']) as $locale) {
                $status[$field][$locale] = $this->hasTranslationFor($field, $locale);
            }
        }

        return $status;
    }

    /**
     * جلب ترجمة حقل بدون fallback للعربي (للعرض في الواجهة الأمامية).
     */
    public function getLocalizedValue(string $field, ?string $locale = null): ?string
    {
        $locale = $locale ?? app()->getLocale();
        $value = trim((string) ($this->{$field} ?? ''));

        if ($value === '') {
            return null;
        }

        if ($locale === 'ar') {
            return $value;
        }

        return $this->getTranslationFromJson($value, $locale);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeVisibleForLocale($query, ?string $locale = null)
    {
        return $query->active()->whereNotNull('name')->where('name', '!=', '');
    }

    /**
     * قراءة ترجمة نص عربي من ملف JSON للغة معيّنة.
     *
     * @example
     * // getTranslationFromJson('ملابس', 'en') => "Clothes"
     * // getTranslationFromJson('ملابس', 'tr') => "Giyim"
     * // getTranslationFromJson('غير موجود', 'en') => null
     */
    public function getTranslationFromJson(string $arabicText, string $locale): ?string
    {
        $key = $this->cleanTextForJsonKey($arabicText);
        $translations = $this->loadJsonTranslationsForLocale($locale);

        return $translations[$key] ?? null;
    }

    /**
     * إضافة أو تحديث ترجمة في ملف JSON.
     *
     * @example
     * // addTranslationToJson('ملابس', 'en', 'Clothes');
     * // lang/en.json يصبح: { "ملابس": "Clothes" }
     */
    public function addTranslationToJson(string $arabicText, string $locale, string $translation): void
    {
        $key = $this->cleanTextForJsonKey($arabicText);

        if ($key === '') {
            return;
        }

        $path = lang_path("{$locale}.json");
        $translations = [];

        if (File::exists($path)) {
            $translations = json_decode(File::get($path), true) ?? [];
        }

        $translations[$key] = $translation;
        ksort($translations);

        File::ensureDirectoryExists(dirname($path));
        File::put($path, json_encode($translations, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) . PHP_EOL);

        Cache::forget("json_trans:{$locale}");
    }

    /**
     * حذف ترجمة نص عربي من ملف JSON للغة معيّنة.
     *
     * @example
     * // removeTranslationFromJson('ملابس', 'en');
     * // يحذف المفتاح "ملابس" من lang/en.json
     */
    public function removeTranslationFromJson(string $arabicText, string $locale): void
    {
        $key = $this->cleanTextForJsonKey($arabicText);
        $path = lang_path("{$locale}.json");

        if (! File::exists($path)) {
            return;
        }

        $translations = json_decode(File::get($path), true) ?? [];

        if (! isset($translations[$key])) {
            return;
        }

        unset($translations[$key]);
        File::put($path, json_encode($translations, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) . PHP_EOL);
        Cache::forget("json_trans:{$locale}");
    }

    /**
     * عند تعديل النص العربي، انقل الترجمة من المفتاح القديم إلى الجديد.
     *
     * @example
     * // كان الاسم: "ملابس" => ترجمة en: "Clothes"
     * // أصبح الاسم: "ملابس رجالية"
     * // renameTranslationKey('ملابس', 'ملابس رجالية');
     * // lang/en.json: { "ملابس رجالية": "Clothes" }
     */
    public function renameTranslationKey(string $oldText, string $newText): void
    {
        if ($oldText === $newText || trim($oldText) === '') {
            return;
        }

        foreach (config('translation.target_locales', ['en', 'tr']) as $locale) {
            $oldKey = $this->cleanTextForJsonKey($oldText);
            $newKey = $this->cleanTextForJsonKey($newText);
            $path = lang_path("{$locale}.json");

            if (! File::exists($path)) {
                continue;
            }

            $translations = json_decode(File::get($path), true) ?? [];

            if (! isset($translations[$oldKey])) {
                continue;
            }

            $translations[$newKey] = $translations[$oldKey];
            unset($translations[$oldKey]);

            File::put($path, json_encode($translations, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) . PHP_EOL);
            Cache::forget("json_trans:{$locale}");
        }
    }

    /**
     * حذف كل ترجمات الحقول القابلة للترجمة من جميع ملفات JSON.
     *
     * @example
     * // $category->name = 'ملابس';
     * // $category->description = 'وصف عربي';
     * // $category->deleteTranslationsFromJson();
     * // يحذف ترجمات name و description من en.json و tr.json
     */
    public function deleteTranslationsFromJson(): void
    {
        foreach ($this->getTranslatableAttributes() as $field) {
            $value = $this->{$field};

            if ($value === null || trim((string) $value) === '') {
                continue;
            }

            foreach (config('translation.target_locales', ['en', 'tr']) as $locale) {
                $this->removeTranslationFromJson((string) $value, $locale);
            }
        }
    }

    /**
     * جلب كل الترجمات المتوفرة لنص عربي واحد (لعرضها في النموذج).
     *
     * @return array<string, string|null>  مثل ['en' => 'Clothes', 'tr' => 'Giyim']
     *
     * @example
     * // translationsForText('ملابس')
     * // => ['en' => 'Clothes', 'tr' => 'Giyim']
     */
    public function translationsForText(string $arabicText): array
    {
        $translations = [];

        foreach (config('translation.target_locales', ['en', 'tr']) as $locale) {
            $translations[$locale] = $this->getTranslationFromJson($arabicText, $locale);
        }

        return $translations;
    }

    /**
     * جلب ترجمات حقل واحد (من الجلسة بعد الترجمة أو من JSON).
     *
     * @return array<string, string|null>
     *
     * @example
     * // $category->resolveTranslationsForField('name')
     * // => ['en' => 'Clothes', 'tr' => 'Giyim']
     */
    public function resolveTranslationsForField(string $field, ?string $arabicText = null): array
    {
        $arabicText = trim((string) ($arabicText ?? $this->{$field} ?? ''));

        if (session()->has("{$field}_translations")) {
            return session("{$field}_translations");
        }

        return $arabicText !== '' ? $this->translationsForText($arabicText) : [];
    }

    /**
     * جلب ترجمات كل الحقول القابلة للترجمة دفعة واحدة.
     *
     * @return array<string, array<string, string|null>>
     *
     * @example
     * // $category->resolveAllTranslations()
     * // => ['name' => ['en' => '...', 'tr' => '...'], 'description' => [...]]
     */
    public function resolveAllTranslations(?array $arabicTexts = null): array
    {
        $translations = [];

        foreach ($this->getTranslatableAttributes() as $field) {
            $arabicText = isset($arabicTexts[$field]) ? trim((string) $arabicTexts[$field]) : null;
            $translations[$field] = $this->resolveTranslationsForField($field, $arabicText);
        }

        return $translations;
    }

    /**
     * تحميل ملف JSON للغة معيّنة مع Cache لمدة 10 دقائق.
     *
     * @example
     * // loadJsonTranslationsForLocale('en')
     * // => ['ملابس' => 'Clothes', 'إلكترونيات' => 'Electronics']
     */
    protected function loadJsonTranslationsForLocale(string $locale): array
    {
        return Cache::remember("json_trans:{$locale}", 600, function () use ($locale) {
            $path = lang_path("{$locale}.json");

            if (! File::exists($path)) {
                return [];
            }

            return json_decode(File::get($path), true) ?? [];
        });
    }

    /**
     * تنظيف النص العربي ليصبح مفتاحاً صالحاً في JSON.
     *
     * يزيل HTML والفراغات الزائدة قبل استخدامه كمفتاح.
     *
     * @example
     * // cleanTextForJsonKey('  ملابس  ') => "ملابس"
     * // cleanTextForJsonKey('<b>ملابس</b>') => "ملابس"
     */
    protected function cleanTextForJsonKey(string $text): string
    {
        $text = strip_tags($text);
        $text = html_entity_decode($text, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $text = preg_replace('/\s+/u', ' ', $text) ?? $text;

        return trim($text);
    }
}
