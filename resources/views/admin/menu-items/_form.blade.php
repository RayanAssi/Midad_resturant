@php
    $item = $item ?? new \App\Models\MenuItem();
    $isEdit = $item->exists;
    $translations = $translations ?? [];
    $translationMessage = session('translation_message');
    $translationError = session('translation_error');
@endphp

<form method="POST"
      id="menuItemForm"
      action="{{ $isEdit ? route('admin.menu-items.update', $item) : route('admin.menu-items.store') }}"
      enctype="multipart/form-data"
      class="space-y-5">
    @csrf
    @if ($isEdit)
        @method('PUT')
    @endif

    {{-- رسائل الترجمة العامة --}}
    @if ($translationMessage && !session('translated_field'))
        <div class="p-3 rounded-lg bg-emerald-950/30 border-2 border-emerald-800/40 flex items-center gap-2 mb-3">
            <p class="text-sm text-emerald-100">{{ $translationMessage }}</p>
        </div>
    @endif

    @if ($translationError && !session('translated_field'))
        <div class="p-3 rounded-lg bg-red-950/30 border-2 border-red-800/40 flex items-center gap-2 mb-3">
            <p class="text-sm text-red-200">{{ $translationError }}</p>
        </div>
    @endif

    {{-- Name --}}
    <div>
        <label class="block text-sm font-bold text-amber-200/80 mb-2">
            Item Name (English) <span class="text-red-500">*</span>
        </label>
        <input type="text" name="name" value="{{ old('name', $item->name ?? '') }}" required
            class="w-full px-4 py-2.5 rounded-lg bg-black/40 border-2 border-red-800/40 text-amber-100
                   placeholder-amber-200/30 focus:outline-none focus:border-red-600/60 transition-colors" />
        @error('name')
            <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
        @enderror

        <x-auto-translate group="menu_items" field="name" :model="$item" />
    </div>

    {{-- Price --}}
    <div>
        <label class="block text-sm font-bold text-amber-200/80 mb-2">
            Price (SYP) <span class="text-red-500">*</span>
        </label>
        <input type="number" name="price" step="0.01" min="0" value="{{ old('price', $item->price ?? '') }}"
            required
            class="w-full px-4 py-2.5 rounded-lg bg-black/40 border-2 border-red-800/40 text-amber-100
                   placeholder-amber-200/30 focus:outline-none focus:border-red-600/60 transition-colors" />
        @error('price')
            <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Category --}}
    <div>
        <label class="block text-sm font-bold text-amber-200/80 mb-2">
            Category <span class="text-red-500">*</span>
        </label>
        <select name="category" required
            class="w-full px-4 py-2.5 rounded-lg bg-black/40 border-2 border-red-800/40 text-amber-100
                   focus:outline-none focus:border-red-600/60">
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

    {{-- Image --}}
    <div>
        <label class="block text-sm font-bold text-amber-200/80 mb-2">Image</label>

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
            class="w-full px-4 py-2.5 rounded-lg bg-black/40 border-2 border-red-800/40 text-amber-100 text-sm
                   file:mr-3 file:py-1 file:px-3 file:rounded-md file:border-0 file:bg-red-700
                   file:text-amber-50 file:font-bold hover:file:bg-red-600
                   focus:outline-none focus:border-red-600/60" />
        @error('image')
            <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- ❌ ما في زر حفظ هنا — الزر برّا الفورم في create.blade.php --}}
</form>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const input = document.getElementById('imageInput');
        const preview = document.getElementById('imagePreview');
        const box = document.getElementById('imageBox');
        const label = document.getElementById('imageLabel');

        if (!input || !preview || !box) return;

        input.addEventListener('change', function (e) {
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