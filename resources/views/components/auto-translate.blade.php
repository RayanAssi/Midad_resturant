<div class="mt-3" data-auto-translate="{{ $field }}">
    @if ($label)
        <p class="text-xs font-bold text-amber-200/70 uppercase tracking-wider mb-2">{{ $label }}</p>
    @endif

    {{-- أزرار الترجمة --}}
    <div class="flex flex-wrap gap-2">
        @foreach (config('translation.target_locales') as $locale)
            <button
                type="submit"
                formmethod="post"
                formaction="{{ route('admin.translations.translate', ['group' => $group, 'field' => $field]) }}"
                name="locale"
                value="{{ $locale }}"
                formnovalidate
                class="px-3 py-1.5 rounded-md text-xs font-bold
                       bg-red-900/40 hover:bg-red-800/60
                       text-amber-100 border-2 border-red-800/40
                       transition-colors disabled:opacity-50"
            >
                @switch($locale)
                    @case('en') 🌐 ترجمة بشكل آلي للإنجليزية @break
                    @case('tr') 🌐 ترجمة بشكل آلي للتركية @break
                    @default 🌐 ترجمة بشكل آلي إلى {{ strtoupper($locale) }}
                @endswitch
            </button>
        @endforeach
    </div>

    {{-- رسائل الترجمة --}}
    @if (session('translation_message') && session('translated_field') === $field)
        <div class="mt-2 p-2 rounded-md bg-emerald-950/30 border-2 border-emerald-800/40">
            <p class="text-xs text-emerald-100">✓ {{ session('translation_message') }}</p>
        </div>
    @endif

    @if (session('translation_error') && session('translated_field') === $field)
        <div class="mt-2 p-2 rounded-md bg-red-950/30 border-2 border-red-800/40">
            <p class="text-xs text-red-200">✗ {{ session('translation_error') }}</p>
        </div>
    @endif

    {{-- حقول الترجمة --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mt-3">
        @foreach (config('translation.target_locales') as $locale)
            @php
                $inputName = "{$field}_translations[{$locale}]";
                $inputId = "translation-{$field}-{$locale}";
                $storedValue = $translations[$locale] ?? '';
                $value = old($inputName, $storedValue);
                $hasStoredTranslation = trim((string) $storedValue) !== '';
                $hasValue = trim((string) $value) !== '';
            @endphp

            <div>
                <label for="{{ $inputId }}"
                    class="block text-[10px] font-bold text-amber-200/60 uppercase mb-1">
                    {{ strtoupper($locale) }}
                </label>

                @if ($multiline)
                    <textarea
                        id="{{ $inputId }}"
                        name="{{ $inputName }}"
                        rows="3"
                        data-locale="{{ $locale }}"
                        class="translation-input w-full px-3 py-2 rounded-md
                               bg-black/40 border-2 border-red-800/40
                               text-amber-100 text-sm
                               placeholder-amber-200/30
                               focus:outline-none focus:border-red-600/60 transition-colors"
                    >{{ $value }}</textarea>
                @else
                    <input
                        type="text"
                        id="{{ $inputId }}"
                        name="{{ $inputName }}"
                        value="{{ $value }}"
                        data-locale="{{ $locale }}"
                        class="translation-input w-full px-3 py-2 rounded-md
                               bg-black/40 border-2 border-red-800/40
                               text-amber-100 text-sm
                               placeholder-amber-200/30
                               focus:outline-none focus:border-red-600/60 transition-colors"
                    >
                @endif

                <div class="flex flex-wrap gap-2 mt-1.5">
                    <button
                        type="submit"
                        formmethod="post"
                        formaction="{{ route('admin.translations.update', ['group' => $group, 'field' => $field]) }}"
                        name="locale"
                        value="{{ $locale }}"
                        formnovalidate
                        class="translation-save-btn {{ $hasValue ? '' : 'hidden' }}
                               px-2.5 py-1 rounded text-[10px] font-bold
                               bg-emerald-900/40 hover:bg-emerald-800/60
                               text-emerald-100 border-2 border-emerald-700/40
                               transition-colors disabled:opacity-50"
                        data-locale="{{ $locale }}"
                    >
                        💾 حفظ {{ strtoupper($locale) }}
                    </button>

                    @if ($hasStoredTranslation)
                        <button
                            type="submit"
                            formmethod="post"
                            formaction="{{ route('admin.translations.destroy', ['group' => $group, 'field' => $field]) }}"
                            name="locale"
                            value="{{ $locale }}"
                            formnovalidate
                            class="px-2.5 py-1 rounded text-[10px] font-bold
                                   bg-red-900/40 hover:bg-red-800/60
                                   text-red-100 border-2 border-red-700/40
                                   transition-colors disabled:opacity-50"
                            onclick="return confirm('هل تريد حذف ترجمة {{ strtoupper($locale) }}؟')"
                        >
                            🗑 حذف {{ strtoupper($locale) }}
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
            document.addEventListener('DOMContentLoaded', function () {
                document.querySelectorAll('.translation-input').forEach(function (input) {
                    const locale = input.dataset.locale;
                    const wrapper = input.parentElement;
                    const saveBtn = wrapper?.querySelector('.translation-save-btn[data-locale="' + locale + '"]');

                    if (!saveBtn) return;

                    const toggle = () => saveBtn.classList.toggle('hidden', input.value.trim() === '');
                    input.addEventListener('input', toggle);
                    toggle();
                });
            });
        </script>
    @endpush
@endonce