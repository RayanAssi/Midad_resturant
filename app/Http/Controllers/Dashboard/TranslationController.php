<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\TranslationService;
use App\Traits\Translatable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TranslationController extends Controller
{
    public function __construct(
        protected TranslationService $translationService
    ) {}

    /**
     * ترجمة النص فقط.
     *
     * لا تحفظ في JSON.
     * فقط ترجع الترجمة.
     */
    public function translate(
        Request $request,
        string $group,
        string $field
    ) {
        $validated = $request->validate([
            'locale' => [
                'required',
                Rule::in(config('translation.target_locales')),
            ],
            'text' => [
                'nullable',
                'string',
            ],
        ]);

        $model = $this->makeModelInstance($group);

        if (! $model) {
            return $this->errorResponse(
                $request,
                $field,
                'نوع القسم غير مدعوم.'
            );
        }

        if (! in_array(
            $field,
            $model->getTranslatableAttributes(),
            true
        )) {
            return $this->errorResponse(
                $request,
                $field,
                'هذا الحقل غير مدعوم للترجمة.'
            );
        }

        $text = trim(
            (string) (
                $request->input('text')
                ?? $request->input($field, '')
            )
        );

        if ($text === '') {
            return $this->errorResponse(
                $request,
                $field,
                'أدخل النص بالإنجليزية أولاً.'
            );
        }

        try {

            $translation = $this->translationService->translate(
                $text,
                $validated['locale'],
                config('translation.base_locale', 'en')
            );

            if (! $translation) {
                throw new \RuntimeException('فشلت الترجمة.');
            }

            /*
             * تخزين مؤقت في Session فقط.
             *
             * لا نحفظ في JSON هنا.
             */
            session([
                "{$field}_source" => $text,

                "{$field}_translations" => array_merge(
                    session("{$field}_translations", []),
                    [
                        $validated['locale'] => $translation,
                    ]
                ),
            ]);

        } catch (\Throwable $exception) {

            return $this->errorResponse(
                $request,
                $field,
                $exception->getMessage()
            );
        }

        /*
         * AJAX
         */
        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'translated_text' => $translation,
                'field' => $field,
                'locale' => $validated['locale'],
                'message' => 'تمت الترجمة بنجاح.',
            ]);
        }

        return $this->redirectWithTranslations(
            $request,
            $model,
            $field,
            'تمت الترجمة بنجاح.'
        );
    }

    /**
     * إرجاع أخطاء الترجمة.
     */
    private function errorResponse(
        Request $request,
        string $field,
        string $message
    ) {
        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => false,
                'message' => $message,
                'field' => $field,
            ], 422);
        }

        return redirect()
            ->back()
            ->withInput()
            ->with('translation_error', $message)
            ->with('translated_field', $field);
    }

    /**
     * حفظ تعديل يدوي على ترجمة موجودة.
     */
    public function update(
        Request $request,
        string $group,
        string $field
    ): RedirectResponse {

        $validated = $request->validate([
            'locale' => [
                'required',
                Rule::in(config('translation.target_locales')),
            ],
        ]);

        $locale = $validated['locale'];

        $request->validate([
            "{$field}_translations.{$locale}" => [
                'required',
                'string',
                'max:1000',
            ],
        ], [
            "{$field}_translations.{$locale}.required"
                => 'أدخل نص الترجمة أولاً.',
        ]);

        $model = $this->makeModelInstance($group);

        if (! $model) {
            return redirect()
                ->back()
                ->withInput()
                ->with('translation_error', 'نوع القسم غير مدعوم.')
                ->with('translated_field', $field);
        }

        if (! in_array(
            $field,
            $model->getTranslatableAttributes(),
            true
        )) {
            return redirect()
                ->back()
                ->withInput()
                ->with('translation_error', 'هذا الحقل غير مدعوم للترجمة.')
                ->with('translated_field', $field);
        }

        $text = trim(
            (string) $request->input($field, '')
        );

        if ($text === '') {
            return redirect()
                ->back()
                ->withInput()
                ->with('translation_error', 'أدخل النص بالإنجليزية أولاً.')
                ->with('translated_field', $field);
        }

        $translation = trim(
            (string) $request->input(
                "{$field}_translations.{$locale}",
                ''
            )
        );

        $model->addTranslationToJson(
            $text,
            $locale,
            $translation
        );

        return $this->redirectWithTranslations(
            $request,
            $model,
            $field,
            'تم حفظ التعديل على الترجمة.'
        );
    }

    /**
     * حذف ترجمة.
     */
    public function destroy(
        Request $request,
        string $group,
        string $field
    ): RedirectResponse {

        $validated = $request->validate([
            'locale' => [
                'required',
                Rule::in(config('translation.target_locales')),
            ],
        ]);

        $locale = $validated['locale'];

        $model = $this->makeModelInstance($group);

        if (! $model) {
            return redirect()
                ->back()
                ->withInput()
                ->with('translation_error', 'نوع القسم غير مدعوم.')
                ->with('translated_field', $field);
        }

        if (! in_array(
            $field,
            $model->getTranslatableAttributes(),
            true
        )) {
            return redirect()
                ->back()
                ->withInput()
                ->with('translation_error', 'هذا الحقل غير مدعوم للترجمة.')
                ->with('translated_field', $field);
        }

        $text = trim(
            (string) $request->input($field, '')
        );

        if ($text === '') {
            return redirect()
                ->back()
                ->withInput()
                ->with('translation_error', 'أدخل النص بالإنجليزية أولاً.')
                ->with('translated_field', $field);
        }

        $model->removeTranslationFromJson(
            $text,
            $locale
        );

        $input = $request->except('_method');

        $translationsInput = $request->input(
            "{$field}_translations",
            []
        );

        if (is_array($translationsInput)) {
            unset($translationsInput[$locale]);

            $input["{$field}_translations"] =
                $translationsInput;
        }

        $redirect = redirect()
            ->back()
            ->withInput($input);

        foreach (
            $this->resolveAllFieldTranslations(
                $request,
                $model,
                $field,
                $locale
            ) as $key => $value
        ) {
            $redirect->with($key, $value);
        }

        return $redirect
            ->with('translation_message', 'تم حذف الترجمة.')
            ->with('translated_field', $field);
    }

    /**
     * Redirect مع الترجمات.
     */
    protected function redirectWithTranslations(
        Request $request,
        object $model,
        string $field,
        string $message
    ): RedirectResponse {

        $redirect = redirect()
            ->back()
            ->withInput();

        foreach (
            $this->resolveAllFieldTranslations(
                $request,
                $model
            ) as $key => $value
        ) {
            $redirect->with($key, $value);
        }

        return $redirect
            ->with('translation_message', $message)
            ->with('translated_field', $field);
    }

    /**
     * جلب كل الترجمات.
     */
    protected function resolveAllFieldTranslations(
        Request $request,
        object $model,
        ?string $excludeField = null,
        ?string $excludeLocale = null,
    ): array {

        $flash = [];

        foreach (
            $model->getTranslatableAttributes()
            as $attr
        ) {

            $text = trim(
                (string) $request->input($attr, '')
            );

            if ($text === '') {
                continue;
            }

            /*
             * هذه الدالة موجودة داخل Translatable Trait.
             */
            $resolved = $model->translationsForText($text);

            $submitted = $request->input(
                "{$attr}_translations",
                []
            );

            if (is_array($submitted)) {

                foreach ($submitted as $locale => $value) {

                    if (
                        $attr === $excludeField &&
                        $locale === $excludeLocale
                    ) {
                        continue;
                    }

                    $trimmed = trim((string) $value);

                    if ($trimmed !== '') {
                        $resolved[$locale] = $trimmed;
                    }
                }
            }

            $flash["{$attr}_translations"] =
                $resolved;
        }

        return $flash;
    }

    /**
     * إنشاء Model حسب group.
     */
    protected function makeModelInstance(
        string $group
    ): ?object {

        $class = $this->getModelClass($group);

        if (
            ! $class ||
            ! in_array(
                Translatable::class,
                class_uses_recursive($class),
                true
            )
        ) {
            return null;
        }

        return new $class;
    }

    /**
     * جلب Model class من config.
     */
    protected function getModelClass(
        string $group
    ): ?string {

        $class = config(
            "translation.groups.{$group}"
        );

        return is_string($class)
            ? $class
            : null;
    }
}
