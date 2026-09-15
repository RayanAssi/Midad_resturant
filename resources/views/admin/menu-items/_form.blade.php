@php
    $isEdit = isset($item) && $item->exists;
@endphp

{{-- Name --}}
<div>
    <label class="block text-sm font-bold text-amber-200/80 mb-2">
        Item Name <span class="text-red-500">*</span>
    </label>
    <input type="text" name="name"
           value="{{ old('name', $item->name ?? '') }}"
           required
           class="w-full px-4 py-2.5 rounded-lg bg-black/40 
                  border-2 border-red-800/40
                  text-amber-100 placeholder-amber-200/30
                  focus:outline-none focus:border-red-600/60 transition-colors" />
    @error('name')
        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
    @enderror
</div>

{{-- Price --}}
<div>
    <label class="block text-sm font-bold text-amber-200/80 mb-2">
        Price (SYP) <span class="text-red-500">*</span>
    </label>
    <input type="number" name="price" step="0.01" min="0"
           value="{{ old('price', $item->price ?? '') }}"
           required
           class="w-full px-4 py-2.5 rounded-lg bg-black/40 
                  border-2 border-red-800/40
                  text-amber-100 placeholder-amber-200/30
                  focus:outline-none focus:border-red-600/60 transition-colors" />
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
            class="w-full px-4 py-2.5 rounded-lg bg-black/40 
                   border-2 border-red-800/40
                   text-amber-100 focus:outline-none focus:border-red-600/60">
        @foreach(\App\Models\MenuItem::categories() as $cat)
            <option value="{{ $cat }}"
                @selected(old('category', $item->category ?? '') === $cat)>
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
    <label class="block text-sm font-bold text-amber-200/80 mb-2">
        Image
    </label>

    @if($isEdit && $item->image)
        <div class="mb-3 flex items-center gap-3">
            <img src="{{ $item->image_url }}" alt=""
                 class="w-20 h-20 rounded-lg object-cover border-2 border-red-800/40" />
            <p class="text-xs text-amber-200/50">Current image</p>
        </div>
    @endif

    <input type="file" name="image" accept="image/*"
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