@props([
    'group',
    'field',
    'label' => null,
    'inputName' => $field . '_translations',
    'translations' => [],
    'multiline' => false,
])

<div class="mt-3" data-translation-field="{{ $field }}">
    @if ($label)
        <p class="text-xs font-bold text-amber-200/70 uppercase tracking-wider mb-2">
            {{ $label }}
        </p>
    @endif

    {{-- أزرار الترجمة --}}
    <div class="flex flex-wrap gap-2">
        @foreach (config('translation.target_locales') as $locale)
            <button
                type="button"
                data-translate-btn
                data-group="{{ $group }}"
                data-field="{{ $field }}"
                data-locale="{{ $locale }}"
                data-url="{{ route('admin.translations.translate', ['group' => $group, 'field' => $field]) }}"
                class="px-3 py-1.5 rounded-md text-xs font-bold
                       bg-blue-900/40 hover:bg-blue-800/60
                       text-blue-100 border border-blue-700/40
                       transition-colors disabled:opacity-50"
            >
                @switch($locale)
                    @case('ar') 🌐 ترجمة للعربية @break
                    @case('en') 🌐 ترجمة للإنجليزية @break
                    @case('tr') 🌐 ترجمة للتركية @break
                    @default 🌐 ترجمة إلى {{ strtoupper($locale) }}
                @endswitch
            </button>
        @endforeach
    </div>

    {{-- رسائل --}}
    <div data-translation-message class="mt-2 text-xs"></div>

    {{-- حقول الترجمة --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mt-3">
        @foreach (config('translation.target_locales') as $locale)
            @php
                $fieldValue = old($inputName . '.' . $locale, $translations[$locale] ?? '');
            @endphp
            <div data-locale-box="{{ $locale }}">
                <label class="block text-[10px] font-bold text-amber-200/60 uppercase mb-1">
                    {{ $locale }}
                </label>

                @if ($multiline)
                    <textarea
                        name="{{ $inputName }}[{{ $locale }}]"
                        rows="2"
                        data-locale="{{ $locale }}"
                        class="translation-input w-full px-3 py-2 rounded-md
                               bg-black/40 border border-amber-800/30
                               text-amber-100 text-sm
                               focus:outline-none focus:border-amber-600/60"
                    >{{ $fieldValue }}</textarea>
                @else
                    <input
                        type="text"
                        name="{{ $inputName }}[{{ $locale }}]"
                        value="{{ $fieldValue }}"
                        data-locale="{{ $locale }}"
                        class="translation-input w-full px-3 py-2 rounded-md
                               bg-black/40 border border-amber-800/30
                               text-amber-100 text-sm
                               focus:outline-none focus:border-amber-600/60"
                    >
                @endif

                <div class="flex flex-wrap gap-2 mt-1.5">
                    <button
                        type="button"
                        data-save-btn
                        data-url="{{ route('admin.translations.update', ['group' => $group, 'field' => $field]) }}"
                        data-group="{{ $group }}"
                        data-field="{{ $field }}"
                        data-locale="{{ $locale }}"
                        class="translation-save-btn {{ $fieldValue ? '' : 'hidden' }}
                               px-2.5 py-1 rounded text-[10px] font-bold
                               bg-emerald-900/40 hover:bg-emerald-800/60
                               text-emerald-100 border border-emerald-700/40
                               disabled:opacity-50"
                    >
                        💾 حفظ {{ strtoupper($locale) }}
                    </button>

                    @if (!empty($translations[$locale]))
                        <button
                            type="button"
                            data-destroy-btn
                            data-url="{{ route('admin.translations.destroy', ['group' => $group, 'field' => $field]) }}"
                            data-group="{{ $group }}"
                            data-field="{{ $field }}"
                            data-locale="{{ $locale }}"
                            data-confirm="هل تريد حذف ترجمة {{ strtoupper($locale) }}؟"
                            class="px-2.5 py-1 rounded text-[10px] font-bold
                                   bg-red-900/40 hover:bg-red-800/60
                                   text-red-100 border border-red-700/40
                                   disabled:opacity-50"
                        >
                            🗑 حذف {{ strtoupper($locale) }}
                        </button>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</div>

<script>
(function () {
    if (window.__translationFieldsBound) return;
    window.__translationFieldsBound = true;

    const csrf = () => document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

    // ✅ helper: يمنع أي سلوك افتراضي
    const block = (e) => {
        e.preventDefault();
        e.stopPropagation();
        e.stopImmediatePropagation();
    };

    // ============ إظهار/إخفاء زر الحفظ ============
    document.addEventListener('input', (e) => {
        const input = e.target.closest('.translation-input');
        if (!input) return;
        const box = input.closest('[data-locale-box]');
        const saveBtn = box?.querySelector('.translation-save-btn');
        if (!saveBtn) return;
        saveBtn.classList.toggle('hidden', input.value.trim() === '');
    });

    // ============ زر الترجمة ============
    document.addEventListener('click', async (e) => {
        const btn = e.target.closest('[data-translate-btn]');
        if (!btn) return;
        block(e); // ✅

        const url = btn.dataset.url;
        const locale = btn.dataset.locale;
        const field = btn.dataset.field;
        const sourceInputName = btn.dataset.sourceInput || field;

        const wrapper = btn.closest(`[data-translation-field="${field}"]`);
        const msgBox = wrapper?.querySelector('[data-translation-message]');
        const localeBox = wrapper?.querySelector(`[data-locale-box="${locale}"]`);
        const targetInput = localeBox?.querySelector('.translation-input');
        const saveBtn = localeBox?.querySelector('.translation-save-btn');

        const form = btn.closest('form');
        const sourceInput = form?.querySelector(`[name="${sourceInputName}"]`);
        const sourceValue = sourceInput?.value?.trim() || '';

        if (!sourceValue) {
            if (msgBox) msgBox.innerHTML = `<span class="text-red-400">✗ اكتب النص الأصلي أولاً</span>`;
            return;
        }

        const originalText = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = '⏳ جاري الترجمة...';
        if (msgBox) msgBox.innerHTML = '';

        try {
            const formData = new FormData();
            formData.set('locale', locale);
            formData.set('group', btn.dataset.group);
            formData.set('field', field);
            formData.set(field, sourceValue);

            const res = await fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrf(),
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                },
                body: formData,
            });

            const data = await res.json().catch(() => ({}));
            if (!res.ok) throw new Error(data.message || 'فشلت الترجمة');

            if (targetInput && data.translation) {
                targetInput.value = data.translation;
                saveBtn?.classList.remove('hidden');
            }

            if (msgBox) {
                msgBox.innerHTML = `<span class="text-emerald-400">✓ ${data.message || 'تمت الترجمة'}</span>`;
            }
        } catch (err) {
            if (msgBox) {
                msgBox.innerHTML = `<span class="text-red-400">✗ ${err.message}</span>`;
            }
        } finally {
            btn.disabled = false;
            btn.innerHTML = originalText;
        }
    }, true); // ✅ capture

    // ============ زر الحفظ ============
    document.addEventListener('click', async (e) => {
        const btn = e.target.closest('[data-save-btn]');
        if (!btn) return;
        block(e); // ✅

        const url = btn.dataset.url;
        const locale = btn.dataset.locale;
        const field = btn.dataset.field;
        const sourceInputName = btn.dataset.sourceInput || field;

        const wrapper = btn.closest(`[data-translation-field="${field}"]`);
        const msgBox = wrapper?.querySelector('[data-translation-message]');
        const localeBox = wrapper?.querySelector(`[data-locale-box="${locale}"]`);
        const targetInput = localeBox?.querySelector('.translation-input');

        const form = btn.closest('form');
        const sourceInput = form?.querySelector(`[name="${sourceInputName}"]`);
        const sourceValue = sourceInput?.value?.trim() || '';

        const originalText = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = '⏳ جاري الحفظ...';
        if (msgBox) msgBox.innerHTML = '';

        try {
            const formData = new FormData();
            formData.set('locale', locale);
            formData.set('group', btn.dataset.group);
            formData.set('field', field);
            formData.set(field, sourceValue);
            if (targetInput) {
                formData.set(`${field}_translations[${locale}]`, targetInput.value);
            }

            const res = await fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrf(),
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                },
                body: formData,
            });

            const data = await res.json().catch(() => ({}));
            if (!res.ok) throw new Error(data.message || 'فشل الحفظ');

            if (msgBox) {
                msgBox.innerHTML = `<span class="text-emerald-400">✓ ${data.message || 'تم الحفظ'}</span>`;
            }
        } catch (err) {
            if (msgBox) {
                msgBox.innerHTML = `<span class="text-red-400">✗ ${err.message}</span>`;
            }
        } finally {
            btn.disabled = false;
            btn.innerHTML = originalText;
        }
    }, true); // ✅ capture

    // ============ زر الحذف ============
    document.addEventListener('click', async (e) => {
        const btn = e.target.closest('[data-destroy-btn]');
        if (!btn) return;
        block(e); // ✅

        if (!confirm(btn.dataset.confirm || 'هل أنت متأكد؟')) return;

        const url = btn.dataset.url;
        const locale = btn.dataset.locale;
        const field = btn.dataset.field;

        const wrapper = btn.closest(`[data-translation-field="${field}"]`);
        const msgBox = wrapper?.querySelector('[data-translation-message]');
        const localeBox = wrapper?.querySelector(`[data-locale-box="${locale}"]`);
        const targetInput = localeBox?.querySelector('.translation-input');
        const saveBtn = localeBox?.querySelector('.translation-save-btn');

        const originalText = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = '⏳ جاري الحذف...';
        if (msgBox) msgBox.innerHTML = '';

        try {
            const formData = new FormData();
            formData.set('locale', locale);
            formData.set('group', btn.dataset.group);
            formData.set('field', field);

            const res = await fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrf(),
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                },
                body: formData,
            });

            const data = await res.json().catch(() => ({}));
            if (!res.ok) throw new Error(data.message || 'فشل الحذف');

            if (targetInput) targetInput.value = '';
            saveBtn?.classList.add('hidden');
            btn.remove();

            if (msgBox) {
                msgBox.innerHTML = `<span class="text-emerald-400">✓ ${data.message || 'تم الحذف'}</span>`;
            }
        } catch (err) {
            if (msgBox) {
                msgBox.innerHTML = `<span class="text-red-400">✗ ${err.message}</span>`;
            }
        } finally {
            if (btn.parentNode) {
                btn.disabled = false;
                btn.innerHTML = originalText;
            }
        }
    }, true); // ✅ capture
})();
</script>