
@props([
    'id' => null,
    'name',
    'type' => 'text',
    'value' => '',
    'label' => '',
    'placeholder' => '',
    'icon' => null,
])

@php
    $inputId = $id ?? $name;
@endphp

<div class="form-group mb-5">
    @if($label)
        <label for="{{ $inputId }}" 
               class="block text-sm font-bold mb-2 text-amber-100 tracking-wide">
            {{ $label }}
            @error($name)
                <span class="text-red-400 text-xs mr-2">*</span>
            @enderror
        </label>
    @endif

    <div class="relative group">
        @if($icon)
            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                <span class="text-red-400 group-focus-within:text-amber-400 transition-colors duration-300">
                    {!! $icon !!}
                </span>
            </div>
        @endif

        <input 
            type="{{ $type }}"
            id="{{ $inputId }}"
            name="{{ $name }}"
            value="{{ old($name, $value) }}"
            placeholder="{{ $placeholder }}"
            {{ $attributes->merge([
                'class' => 'w-full px-4 py-3 bg-gradient-to-br from-gray-900 to-gray-800 
                            border-2 rounded-xl text-amber-50 placeholder-gray-500
                            transition-all duration-300 ease-in-out
                            focus:outline-none focus:ring-2 focus:ring-amber-400/50
                            hover:border-red-500/70
                            ' . ($errors->has($name) 
                                ? 'border-red-500 shadow-lg shadow-red-500/30' 
                                : 'border-red-800/50 focus:border-amber-400')
            ]) }}
        >
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