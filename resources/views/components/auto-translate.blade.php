@php
    $multiline = $multiline ?? false;
    $label = $label ?? null;

    if (!isset($model) || !$model) {
        $model = new \App\Models\MenuItem();
    }

    $englishText = trim(
        (string) old(
            $field,
            $model->{$field} ?? session("{$field}_source", '')
        )
    );

    $translations = $translations ?? [];

    if (empty($translations)) {
        $translations = session("{$field}_translations", []);
    }

    if (
        empty($translations) &&
        $englishText !== '' &&
        method_exists($model, 'translationsForText')
    ) {
        $translations = $model->translationsForText($englishText);
    }
@endphp


<div
    class="mt-3 p-4 rounded-lg bg-black/30 border border-red-800/30"
    data-auto-translate="{{ $field }}"
>

    @if($label)
        <p class="text-xs font-semibold text-amber-200/70 mb-3">
            {{ $label }}
        </p>
    @endif


    {{--Translation Buttons--}}
    <div class="flex flex-wrap gap-2 mb-3">

        @foreach (config('translation.target_locales') as $locale)

            <button
                type="button"
                data-translate-btn
                data-url="{{ route('admin.translations.translate', [
                    'group' => $group,
                    'field' => $field
                ]) }}"
                data-locale="{{ $locale }}"
                data-field="{{ $field }}"
                class="px-3 py-1.5 text-xs font-medium
                       text-amber-100
                       bg-red-900/40
                       hover:bg-red-800/60
                       border border-red-700/50
                       rounded-md
                       transition-colors
                       flex items-center gap-1.5"
            >

                <span class="translate-text">

                    @switch($locale)

                        @case('ar')
                            ترجمة تلقائية للعربية
                            @break

                        @case('en')
                            ترجمة تلقائية للإنجليزية
                            @break

                        @default
                            ترجمة آلياً إلى {{ strtoupper($locale) }}

                    @endswitch

                </span>

                <span
                    class="translate-loading hidden"
                    aria-hidden="true"
                >
                    ...
                </span>

            </button>

        @endforeach

    </div>

    <div
        class="translation-alert p-2 mb-3 rounded text-xs hidden"
    ></div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-3">

        @foreach (config('translation.target_locales') as $locale)

            @php

                $inputName = "{$field}_translations[{$locale}]";

                $inputId = "translation-{$field}-{$locale}";

                $storedValue = $translations[$locale] ?? '';

                $value = old(
                    $inputName,
                    $storedValue
                );

            @endphp


            <div class="space-y-2">

                <label
                    for="{{ $inputId }}"
                    class="block text-xs font-bold text-amber-200/80"
                >

                    الترجمة باللغة
                    ({{ strtoupper($locale) == 'AR'
                        ? 'العربية'
                        : strtoupper($locale)
                    }})

                </label>


                @if ($multiline)

                    <textarea
                        id="{{ $inputId }}"
                        name="{{ $inputName }}"
                        rows="3"
                        data-locale="{{ $locale }}"
                        class="translation-input
                               w-full px-3 py-2
                               rounded-lg
                               bg-black/50
                               border border-red-800/40
                               text-amber-100
                               placeholder-amber-200/30
                               text-sm
                               focus:outline-none
                               focus:border-red-600/60
                               transition-colors"
                    >{{ $value }}</textarea>

                @else

                    <input
                        type="text"
                        id="{{ $inputId }}"
                        name="{{ $inputName }}"
                        value="{{ $value }}"
                        data-locale="{{ $locale }}"
                        class="translation-input
                               w-full px-3 py-2
                               rounded-lg
                               bg-black/50
                               border border-red-800/40
                               text-amber-100
                               placeholder-amber-200/30
                               text-sm
                               focus:outline-none
                               focus:border-red-600/60
                               transition-colors"
                    >

                @endif

            </div>

        @endforeach

    </div>

</div>

@push('scripts')
<script>
(function () {
    if (window.autoTranslateInitialized) return;
    window.autoTranslateInitialized = true;

    function initAutoTranslate() {
        document.querySelectorAll('[data-auto-translate]').forEach(function (container) {
            if (container.dataset.bound === '1') return;
            container.dataset.bound = '1';

            container.addEventListener('click', async function (event) {
                const btn = event.target.closest('[data-translate-btn]');
                if (!btn) return;

                event.preventDefault();
                event.stopPropagation();

                const fieldName = btn.dataset.field || container.dataset.autoTranslate;
                const locale = btn.dataset.locale;
                const url = btn.dataset.url;

                // جيب الحقل الرئيسي من نفس الفورم
                const form = btn.closest('form') || document;
                const mainInput = form.querySelector('[name="' + fieldName + '"]');
                const sourceText = mainInput ? mainInput.value.trim() : '';

                if (!sourceText) {
                    showTranslationAlert(container, 'يرجى كتابة النص الإنجليزي أولاً للترجمة', 'error');
                    return;
                }

                if (btn.dataset.loading === '1') return;
                btn.dataset.loading = '1';
                btn.disabled = true;

                const originalText = btn.innerHTML;
                btn.innerHTML = '... جاري الترجمة';

                try {
                    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
                        || form.querySelector('input[name="_token"]')?.value;

                    if (!csrfToken) throw new Error('CSRF token غير موجود');

                    const response = await fetch(url, {
                        method: 'POST',
                        credentials: 'same-origin',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: JSON.stringify({ locale: locale, text: sourceText })
                    });

                    let data = {};
                    try {
                        data = await response.json();
                    } catch (e) {
                        throw new Error('السيرفر لم يرجع JSON صالح. HTTP ' + response.status);
                    }

                    if (!response.ok || !data.translated_text) {
                        throw new Error(data.message || 'حدث خطأ أثناء الترجمة.');
                    }

                    const targetInput = container.querySelector(
                        '.translation-input[data-locale="' + locale + '"]'
                    );

                    if (targetInput) {
                        targetInput.value = data.translated_text;
                        targetInput.dispatchEvent(new Event('input', { bubbles: true }));
                        targetInput.dispatchEvent(new Event('change', { bubbles: true }));
                    }

                    showTranslationAlert(container, '✓ تمت الترجمة بنجاح!', 'success');

                } catch (error) {
                    console.error('Auto translation error:', error);
                    showTranslationAlert(container, '✗ ' + error.message, 'error');
                } finally {
                    btn.dataset.loading = '0';
                    btn.disabled = false;
                    btn.innerHTML = originalText;
                }
            });
        });
    }

    function showTranslationAlert(container, message, type) {
        const alertBox = container.querySelector('.translation-alert');
        if (!alertBox) return;

        alertBox.textContent = message;
        alertBox.classList.remove('hidden',
            'bg-emerald-950/40', 'border-emerald-800/50', 'text-emerald-200',
            'bg-red-950/40', 'border-red-800/50', 'text-red-200');

        if (type === 'success') {
            alertBox.classList.add('bg-emerald-950/40', 'border', 'border-emerald-800/50', 'text-emerald-200');
        } else {
            alertBox.classList.add('bg-red-950/40', 'border', 'border-red-800/50', 'text-red-200');
        }

        clearTimeout(alertBox._translationTimer);
        alertBox._translationTimer = setTimeout(function () {
            alertBox.classList.add('hidden');
        }, 4000);
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initAutoTranslate);
    } else {
        initAutoTranslate();
    }
})();
</script>
@endpush
