<?php

namespace App\Traits;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;

/**
 * Trait للتعامل مع الترجمات المخزنة في ملفات JSON.
 *
 * القاعدة:
 * - الإنجليزية تُخزَّن في قاعدة البيانات (اللغة الأساسية)
 * - الترجمات تُخزَّن في lang/ar.json و lang/tr.json
 * - المفتاح في JSON = النص الإنجليزي نفسه
 *
 * @example
 * // lang/ar.json:
 * // {
 * //   "Clothes": "ملابس",
 * //   "Electronics": "إلكترونيات"
 * // }
 */
trait Translatable
{
    /**
     * اللغة الأساسية (المصدر) — الإنجليزية.
     */
    protected static function baseLocale(): string
    {
        return config('translation.base_locale', 'en');
    }

    /**
     * عند حذف السجل من قاعدة البيانات، احذف ترجماته من JSON تلقائياً.
     */
    protected static function bootTranslatable(): void
    {
        static::deleted(function ($model) {
            $model->deleteTranslationsFromJson();
        });
    }

    /**
     * الحقول القابلة للترجمة — يجب تعريفها في كل Model.
     */
    abstract public function getTranslatableAttributes(): array;

    /**
     * جلب ترجمة حقل معيّن حسب اللغة.
     *
     * إذا اللغة إنجليزية => يرجع القيمة من قاعدة البيانات مباشرة.
     * إذا لغة أخرى => يبحث في JSON، وإن لم يجد يرجع الإنجليزي.
     */
    public function getTranslation(string $field, ?string $locale = null): ?string
    {
        $locale = $locale ?? app()->getLocale();
        $value = $this->{$field};

        if ($locale === self::baseLocale() || $value === null || trim((string) $value) === '') {
            return $value;
        }

        return $this->getTranslationFromJson((string) $value, $locale) ?? $value;
    }

    /**
     * هل يوجد ترجمة فعلية لحقل معيّن بلغة معيّنة (بدون fallback للإنجليزي).
     */
    public function hasTranslationFor(string $field, ?string $locale = null): bool
    {
        $locale = $locale ?? app()->getLocale();
        $value = trim((string) ($this->{$field} ?? ''));

        if ($value === '') {
            return false;
        }

        if ($locale === self::baseLocale()) {
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
     */
    public function getTranslationStatus(): array
    {
        $status = [];

        foreach ($this->getTranslatableAttributes() as $field) {
            foreach (config('translation.target_locales', ['ar', 'tr']) as $locale) {
                $status[$field][$locale] = $this->hasTranslationFor($field, $locale);
            }
        }

        return $status;
    }

    /**
     * جلب ترجمة حقل بدون fallback للإنجليزي (للعرض في الواجهة الأمامية).
     */
    public function getLocalizedValue(string $field, ?string $locale = null): ?string
    {
        $locale = $locale ?? app()->getLocale();
        $value = trim((string) ($this->{$field} ?? ''));

        if ($value === '') {
            return null;
        }

        if ($locale === self::baseLocale()) {
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
     * قراءة ترجمة نص إنجليزي من ملف JSON للغة معيّنة.
     */
    public function getTranslationFromJson(string $sourceText, string $locale): ?string
    {
        $key = $this->cleanTextForJsonKey($sourceText);
        $translations = $this->loadJsonTranslationsForLocale($locale);

        return $translations[$key] ?? null;
    }

    /**
     * إضافة أو تحديث ترجمة في ملف JSON.
     */
    public function addTranslationToJson(string $sourceText, string $locale, string $translation): void
    {
        $key = $this->cleanTextForJsonKey($sourceText);

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
     * حذف ترجمة نص إنجليزي من ملف JSON للغة معيّنة.
     */
    public function removeTranslationFromJson(string $sourceText, string $locale): void
    {
        $key = $this->cleanTextForJsonKey($sourceText);
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
     * عند تعديل النص الإنجليزي، انقل الترجمة من المفتاح القديم إلى الجديد.
     */
    public function renameTranslationKey(string $oldText, string $newText): void
    {
        if ($oldText === $newText || trim($oldText) === '') {
            return;
        }

        foreach (config('translation.target_locales', ['ar', 'tr']) as $locale) {
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
     */
    public function deleteTranslationsFromJson(): void
    {
        foreach ($this->getTranslatableAttributes() as $field) {
            $value = $this->{$field};

            if ($value === null || trim((string) $value) === '') {
                continue;
            }

            foreach (config('translation.target_locales', ['ar', 'tr']) as $locale) {
                $this->removeTranslationFromJson((string) $value, $locale);
            }
        }
    }

    /**
     * جلب كل الترجمات المتوفرة لنص إنجليزي واحد (لعرضها في النموذج).
     */
    public function translationsForText(string $sourceText): array
    {
        $translations = [];

        foreach (config('translation.target_locales', ['ar', 'tr']) as $locale) {
            $translations[$locale] = $this->getTranslationFromJson($sourceText, $locale);
        }

        return $translations;
    }

    /**
     * جلب ترجمات حقل واحد (من الجلسة بعد الترجمة أو من JSON).
     */
    public function resolveTranslationsForField(string $field, ?string $sourceText = null): array
    {
        $sourceText = trim((string) ($sourceText ?? $this->{$field} ?? ''));

        if (session()->has("{$field}_translations")) {
            return session("{$field}_translations");
        }

        return $sourceText !== '' ? $this->translationsForText($sourceText) : [];
    }

    /**
     * جلب ترجمات كل الحقول القابلة للترجمة دفعة واحدة.
     */
    public function resolveAllTranslations(?array $sourceTexts = null): array
    {
        $translations = [];

        foreach ($this->getTranslatableAttributes() as $field) {
            $sourceText = isset($sourceTexts[$field]) ? trim((string) $sourceTexts[$field]) : null;
            $translations[$field] = $this->resolveTranslationsForField($field, $sourceText);
        }

        return $translations;
    }

    /**
     * تحميل ملف JSON للغة معيّنة مع Cache لمدة 10 دقائق.
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
     * تنظيف النص الإنجليزي ليصبح مفتاحاً صالحاً في JSON.
     */
    protected function cleanTextForJsonKey(string $text): string
    {
        $text = strip_tags($text);
        $text = html_entity_decode($text, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $text = preg_replace('/\s+/u', ' ', $text) ?? $text;

        return trim($text);
    }
}