<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\TranslationService;
use App\Traits\Translatable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

/**
 * Controller عام للترجمة التلقائية لكل الأقسام (بدون JavaScript).
 *
 * المسار: POST /admin/dashboard/translate/{group}/{field}
 * مثال: POST /admin/dashboard/translate/categories/name
 * مثال: POST /admin/dashboard/translate/categories/description
 */
class TranslationController extends Controller
{
    public function __construct(
        protected TranslationService $translationService
    ) {}

    /**
     * ترجمة حقل عربي (name أو description) وحفظه في lang/{locale}.json
     *
     * @example
     * // formaction من زر الترجمة يرسل كل حقول النموذج:
     * // name=ملابس, description=وصف عربي, locale=en
     * // عند field=description يُترجم حقل الوصف فقط
     */
    public function translate(Request $request, string $group, string $field): RedirectResponse
    {
        $validated = $request->validate([
            'locale' => ['required', Rule::in(config('translation.target_locales'))],
        ]);

        $model = $this->makeModelInstance($group);

        if (! $model) {
            return redirect()->back()
                ->withInput()
                ->with('translation_error', 'نوع القسم غير مدعوم.')
                ->with('translated_field', $field);
        }

        if (! in_array($field, $model->getTranslatableAttributes(), true)) {
            return redirect()->back()
                ->withInput()
                ->with('translation_error', 'هذا الحقل غير مدعوم للترجمة.')
                ->with('translated_field', $field);
        }

        $text = trim((string) $request->input($field, ''));

        if ($text === '') {
            return redirect()->back()
                ->withInput()
                ->with('translation_error', 'أدخل النص بالعربية أولاً.')
                ->with('translated_field', $field);
        }

        try {
            $translation = $this->translationService->translate(
                $text,
                $validated['locale']
            );

            if (! $translation) {
                throw new \RuntimeException('فشلت الترجمة.');
            }

            $model->addTranslationToJson($text, $validated['locale'], $translation);
        } catch (\Throwable $exception) {
            return redirect()->back()
                ->withInput()
                ->with('translation_error', $exception->getMessage())
                ->with('translated_field', $field);
        }

        return $this->redirectWithTranslations(
            $request,
            $model,
            $field,
            'تمت الترجمة وحفظها في ملف JSON.'
        );
    }

    /**
     * حفظ تعديل يدوي على ترجمة موجودة في lang/{locale}.json
     */
    public function update(Request $request, string $group, string $field): RedirectResponse
    {
        $validated = $request->validate([
            'locale' => ['required', Rule::in(config('translation.target_locales'))],
        ]);

        $locale = $validated['locale'];

        $request->validate([
            "{$field}_translations.{$locale}" => ['required', 'string', 'max:1000'],
        ], [
            "{$field}_translations.{$locale}.required" => 'أدخل نص الترجمة أولاً.',
        ]);
        $model = $this->makeModelInstance($group);

        if (! $model) {
            return redirect()->back()
                ->withInput()
                ->with('translation_error', 'نوع القسم غير مدعوم.')
                ->with('translated_field', $field);
        }

        if (! in_array($field, $model->getTranslatableAttributes(), true)) {
            return redirect()->back()
                ->withInput()
                ->with('translation_error', 'هذا الحقل غير مدعوم للترجمة.')
                ->with('translated_field', $field);
        }

        $text = trim((string) $request->input($field, ''));

        if ($text === '') {
            return redirect()->back()
                ->withInput()
                ->with('translation_error', 'أدخل النص بالعربية أولاً.')
                ->with('translated_field', $field);
        }

        $translation = trim((string) $request->input("{$field}_translations.{$locale}", ''));

        $model->addTranslationToJson($text, $locale, $translation);

        return $this->redirectWithTranslations(
            $request,
            $model,
            $field,
            'تم حفظ التعديل على الترجمة.'
        );
    }

    /**
     * حذف ترجمة محفوظة من lang/{locale}.json
     */
    public function destroy(Request $request, string $group, string $field): RedirectResponse
    {
        $validated = $request->validate([
            'locale' => ['required', Rule::in(config('translation.target_locales'))],
        ]);

        $locale = $validated['locale'];
        $model = $this->makeModelInstance($group);

        if (! $model) {
            return redirect()->back()
                ->withInput()
                ->with('translation_error', 'نوع القسم غير مدعوم.')
                ->with('translated_field', $field);
        }

        if (! in_array($field, $model->getTranslatableAttributes(), true)) {
            return redirect()->back()
                ->withInput()
                ->with('translation_error', 'هذا الحقل غير مدعوم للترجمة.')
                ->with('translated_field', $field);
        }

        $text = trim((string) $request->input($field, ''));

        if ($text === '') {
            return redirect()->back()
                ->withInput()
                ->with('translation_error', 'أدخل النص بالعربية أولاً.')
                ->with('translated_field', $field);
        }

        $model->removeTranslationFromJson($text, $locale);

        $input = $request->except('_method');
        $translationsInput = $request->input("{$field}_translations", []);

        if (is_array($translationsInput)) {
            unset($translationsInput[$locale]);
            $input["{$field}_translations"] = $translationsInput;
        }

        $redirect = redirect()->back()->withInput($input);

        foreach ($this->resolveAllFieldTranslations($request, $model, $field, $locale) as $key => $value) {
            $redirect->with($key, $value);
        }

        return $redirect
            ->with('translation_message', 'تم حذف الترجمة.')
            ->with('translated_field', $field);
    }

    protected function redirectWithTranslations(
        Request $request,
        object $model,
        string $field,
        string $message
    ): RedirectResponse {
        $redirect = redirect()->back()->withInput();

        foreach ($this->resolveAllFieldTranslations($request, $model) as $key => $value) {
            $redirect->with($key, $value);
        }

        return $redirect
            ->with('translation_message', $message)
            ->with('translated_field', $field);
    }

    /**
     * @return array<string, array<string, string|null>>
     */
    protected function resolveAllFieldTranslations(
        Request $request,
        object $model,
        ?string $excludeField = null,
        ?string $excludeLocale = null,
    ): array {
        $flash = [];

        foreach ($model->getTranslatableAttributes() as $attr) {
            $text = trim((string) $request->input($attr, ''));

            if ($text === '') {
                continue;
            }

            $resolved = $model->translationsForText($text);
            $submitted = $request->input("{$attr}_translations", []);

            if (is_array($submitted)) {
                foreach ($submitted as $locale => $value) {
                    if ($attr === $excludeField && $locale === $excludeLocale) {
                        continue;
                    }

                    $trimmed = trim((string) $value);

                    if ($trimmed !== '') {
                        $resolved[$locale] = $trimmed;
                    }
                }
            }

            $flash["{$attr}_translations"] = $resolved;
        }

        return $flash;
    }

    protected function makeModelInstance(string $group): ?object
    {
        $class = $this->getModelClass($group);

        if (! $class || ! in_array(Translatable::class, class_uses_recursive($class), true)) {
            return null;
        }

        return new $class;
    }

    protected function getModelClass(string $group): ?string
    {
        $class = config("translation.groups.{$group}");

        return is_string($class) ? $class : null;
    }
}
