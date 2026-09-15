@props([
    'label' => '',
    'name' => '',
    'option' => [],
    'selected' => '',
    'placeholder' => 'اختر...',
    'icon' => null,
])

<div class="form-group mb-5">
    @if($label)
        <label for="{{ $name }}" 
               class="block text-sm font-bold mb-2 text-amber-100 tracking-wide">
            {{ $label }}
            @error($name)
                <span class="text-red-400 text-xs mr-2">*</span>
            @enderror
        </label>
    @endif

    <div class="relative group">
        @if($icon)
            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none z-10">
                <span class="text-red-400 group-focus-within:text-amber-400 transition-colors duration-300">
                    {!! $icon !!}
                </span>
            </div>
        @endif

        <select 
            id="{{ $name }}"
            name="{{ $name }}"
            {{ $attributes->merge([
                'class' => 'w-full px-4 py-3 bg-gradient-to-br from-gray-900 to-gray-800 
                            border-2 rounded-xl text-amber-50 appearance-none
                            transition-all duration-300 ease-in-out cursor-pointer
                            focus:outline-none focus:ring-2 focus:ring-amber-400/50
                            hover:border-red-500/70
                            ' . ($errors->has($name) 
                                ? 'border-red-500 shadow-lg shadow-red-500/30' 
                                : 'border-red-800/50 focus:border-amber-400')
            ]) }}
        >
            <option value="" disabled {{ old($name, $selected) == '' ? 'selected' : '' }}>
                {{ $placeholder }}
            </option>
            @foreach ($option as $value => $text)
                <option value="{{ $value }}" 
                    @if($value == old($name, $selected)) selected @endif
                    class="bg-gray-900 text-amber-50">
                    {{ $text }}
                </option>
            @endforeach
        </select>

        {{-- سهم مخصص --}}
        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
            <svg class="w-5 h-5 text-red-400 group-focus-within:text-amber-400 transition-colors" 
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </div>
    </div>

    @error($name)
        <p class="mt-2 text-sm text-red-400 flex items-center gap-1 animate-pulse">
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
            </svg>
            {{ $message }}
        </p>
    @enderror
</div>