@php
    $isEdit = isset($item) && $item->exists;
    $targetLocales = config('translation.target_locales', ['en']);
    $translatedField = session('translated_field');
    $translationMessage = session('translation_message');
    $translationError = session('translation_error');
@endphp

{{-- ═══════════════════════════════════════════════════════ --}}
{{-- رسائل الترجمة --}}
{{-- ═══════════════════════════════════════════════════════ --}}
@if ($translationMessage)
    <div class="p-3 rounded-lg bg-emerald-950/30 border-2 border-emerald-800/40 flex items-center gap-2">
        <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
        </svg>
        <p class="text-sm text-emerald-100">{{ $translationMessage }}</p>
    </div>
@endif

@if ($translationError)
    <div class="p-3 rounded-lg bg-red-950/30 border-2 border-red-800/40 flex items-center gap-2">
        <svg class="w-4 h-4 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <p class="text-sm text-red-200">{{ $translationError }}</p>
    </div>
@endif


{{-- ═══════════════════════════════════════════════════════ --}}
{{-- Name with Translation --}}
{{-- ═══════════════════════════════════════════════════════ --}}
<div>
    <label class="block text-sm font-bold text-amber-200/80 mb-2">
        Item Name <span class="text-red-500">*</span>
    </label>

    <input type="text" name="name" value="{{ old('name', $item->name ?? '') }}" required
        class="w-full px-4 py-2.5 rounded-lg bg-black/40 
                  border-2 border-red-800/40
                  text-amber-100 placeholder-amber-200/30
                  focus:outline-none focus:border-red-600/60 transition-colors" />

    @error('name')
        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
    @enderror

    {{-- ✅ الكمبوننت --}}
    <x-translation-field
        group="menu_items"
        field="name"
        inputName="name_translations"
        :translations="$translations['name'] ?? []"
    />
</div>


{{-- ═══════════════════════════════════════════════════════ --}}
{{-- Price --}}
{{-- ═══════════════════════════════════════════════════════ --}}
<div>
    <label class="block text-sm font-bold text-amber-200/80 mb-2">
        Price (SYP) <span class="text-red-500">*</span>
    </label>
    <input type="number" name="price" step="0.01" min="0" value="{{ old('price', $item->price ?? '') }}"
        required
        class="w-full px-4 py-2.5 rounded-lg bg-black/40 
                  border-2 border-red-800/40
                  text-amber-100 placeholder-amber-200/30
                  focus:outline-none focus:border-red-600/60 transition-colors" />
    @error('price')
        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
    @enderror
</div>


{{-- ═══════════════════════════════════════════════════════ --}}
{{-- Category --}}
{{-- ═══════════════════════════════════════════════════════ --}}
<div>
    <label class="block text-sm font-bold text-amber-200/80 mb-2">
        Category <span class="text-red-500">*</span>
    </label>
    <select name="category" required
        class="w-full px-4 py-2.5 rounded-lg bg-black/40 
                   border-2 border-red-800/40
                   text-amber-100 focus:outline-none focus:border-red-600/60">
        @foreach (\App\Models\MenuItem::categories() as $cat)
            <option value="{{ $cat }}" @selected(old('category', $item->category ?? '') === $cat)>
                {{ ucfirst(str_replace('_', ' ', $cat)) }}
            </option>
        @endforeach
    </select>
    @error('category')
        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
    @enderror
</div>


{{-- ═══════════════════════════════════════════════════════ --}}
{{-- Image --}}
{{-- ═══════════════════════════════════════════════════════ --}}
<div>
    <label class="block text-sm font-bold text-amber-200/80 mb-2">
        Image
    </label>

    @if ($isEdit && $item->image)
        <div class="mb-3 flex items-center gap-3" id="imageBox">
            <img src="{{ $item->image_url }}" alt="" id="imagePreview"
                class="w-20 h-20 rounded-lg object-cover border-2 border-red-800/40" />
            <p class="text-xs text-amber-200/50" id="imageLabel">Current image</p>
        </div>
    @else
        <div class="mb-3 flex items-center gap-3 hidden" id="imageBox">
            <img id="imagePreview" class="w-20 h-20 rounded-lg object-cover border-2 border-amber-500/60" />
            <p class="text-xs text-amber-200/50" id="imageLabel">New image preview</p>
        </div>
    @endif

    <input type="file" name="image" accept="image/*" id="imageInput"
        class="w-full px-4 py-2.5 rounded-lg bg-black/40 
                  border-2 border-red-800/40
                  text-amber-100 text-sm
                  file:mr-3 file:py-1 file:px-3 file:rounded-md
                  file:border-0 file:bg-red-700 file:text-amber-50
                  file:font-bold hover:file:bg-red-600
                  focus:outline-none focus:border-red-600/60" />
    @error('image')
        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
    @enderror
</div>

{{-- ✅ سكربت استبدال الصورة --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const input = document.getElementById('imageInput');
        const preview = document.getElementById('imagePreview');
        const box = document.getElementById('imageBox');
        const label = document.getElementById('imageLabel');

        if (!input || !preview || !box) return;

        input.addEventListener('change', function(e) {
            const file = e.target.files[0];

            if (!file || !file.type.startsWith('image/')) {
                @if ($isEdit && $item->image)
                    preview.src = "{{ $item->image_url }}";
                    label.textContent = "Current image";
                @else
                    box.classList.add('hidden');
                @endif
                return;
            }

            const url = URL.createObjectURL(file);
            preview.src = url;
            label.textContent = "New image preview";
            box.classList.remove('hidden');
            preview.classList.remove('border-red-800/40');
            preview.classList.add('border-amber-500/60');

            preview.onload = () => URL.revokeObjectURL(url);
        });
    });
</script>
