
<div class="mt-2" data-auto-translate="{{ $field }}">
    <p class="small text-muted mb-2">{{ $label }}</p>

    <div class="d-flex flex-wrap gap-2">
        @foreach (config('translation.target_locales') as $locale)
            <button
                type="submit"
                formmethod="post"
                formaction="{{ route('dashboard.translations.translate', ['group' => $group, 'field' => $field]) }}"
                name="locale"
                value="{{ $locale }}"
                class="btn btn-outline-primary btn-sm"
            >
                @switch($locale)
                    @case('en') ترجمة بشكل آلي للإنجليزية @break
                    @case('tr') ترجمة بشكل آلي للتركية @break
                    @default ترجمة بشكل آلي إلى {{ strtoupper($locale) }}
                @endswitch
            </button>
        @endforeach
    </div>

    @if (session('translation_message') && session('translated_field') === $field)
        <div class="mt-2 small text-success">{{ session('translation_message') }}</div>
    @endif

    @if (session('translation_error') && session('translated_field') === $field)
        <div class="mt-2 small text-danger">{{ session('translation_error') }}</div>
    @endif

    <div class="row mt-3">
        @foreach (config('translation.target_locales') as $locale)
            @php
                $inputName = "{$field}_translations[{$locale}]";
                $inputId = "translation-{$field}-{$locale}";
                $storedValue = $translations[$locale] ?? '';
                $value = old($inputName, $storedValue);
                $hasStoredTranslation = trim((string) $storedValue) !== '';
                $hasValue = trim((string) $value) !== '';
            @endphp
            <div class="col-md-6">
                <label for="{{ $inputId }}">{{ strtoupper($locale) }}</label>
                @if ($multiline)
                    <textarea
                        id="{{ $inputId }}"
                        name="{{ $inputName }}"
                        class="form-control translation-input"
                        rows="3"
                        data-locale="{{ $locale }}"
                    >{{ $value }}</textarea>
                @else
                    <input
                        type="text"
                        id="{{ $inputId }}"
                        name="{{ $inputName }}"
                        class="form-control translation-input"
                        value="{{ $value }}"
                        data-locale="{{ $locale }}"
                    >
                @endif
                <div class="d-flex flex-wrap gap-2 mt-2">
                    <button
                        type="submit"
                        formmethod="post"
                        formaction="{{ route('dashboard.translations.update', ['group' => $group, 'field' => $field]) }}"
                        name="locale"
                        value="{{ $locale }}"
                        class="btn btn-outline-secondary btn-sm translation-save-btn {{ $hasValue ? '' : 'd-none' }}"
                        data-locale="{{ $locale }}"
                    >
                        حفظ {{ strtoupper($locale) }}
                    </button>
                    @if ($hasStoredTranslation)
                        <button
                            type="submit"
                            formmethod="post"
                            formaction="{{ route('dashboard.translations.destroy', ['group' => $group, 'field' => $field]) }}"
                            name="locale"
                            value="{{ $locale }}"
                            class="btn btn-outline-danger btn-sm"
                            onclick="return confirm('هل تريد حذف ترجمة {{ strtoupper($locale) }}؟')"
                        >
                            حذف {{ strtoupper($locale) }}
                        </button>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</div>

@once
    @push('scripts')
        <script>
            document.querySelectorAll('.translation-input').forEach(function (input) {
                const locale = input.dataset.locale;
                const saveBtn = input.closest('.col-md-6')?.querySelector('.translation-save-btn[data-locale="' + locale + '"]');

                if (!saveBtn) {
                    return;
                }

                const toggleSaveButton = function () {
                    saveBtn.classList.toggle('d-none', input.value.trim() === '');
                };

                input.addEventListener('input', toggleSaveButton);
                toggleSaveButton();
            });
        </script>
    @endpush
@endonce
