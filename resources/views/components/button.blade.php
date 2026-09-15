@props([
    'type' => 'submit',
    'variant' => 'primary',
    'icon' => null,
    'href' => null,
])

@php
    $variants = [
        'primary' => 'bg-gradient-to-r from-red-600 via-red-700 to-red-900 
                      hover:from-red-500 hover:via-red-600 hover:to-red-800
                      text-amber-50 shadow-lg shadow-red-900/50
                      hover:shadow-red-700/60',
        'secondary' => 'bg-gradient-to-r from-gray-700 to-gray-900 
                        hover:from-gray-600 hover:to-gray-800
                        text-amber-50 shadow-lg shadow-gray-900/50',
        'gold' => 'bg-gradient-to-r from-amber-500 via-amber-600 to-amber-700
                   hover:from-amber-400 hover:via-amber-500 hover:to-amber-600
                   text-gray-900 shadow-lg shadow-amber-900/50
                   hover:shadow-amber-700/60',
        'danger' => 'bg-gradient-to-r from-red-700 to-red-900
                     hover:from-red-600 hover:to-red-800
                     text-white shadow-lg shadow-red-900/50',
    ];

    $classes = $variants[$variant] ?? $variants['primary'];
    $tag = $href ? 'a' : 'button';
@endphp

<{{ $tag }}
    @if($href) href="{{ $href }}" @else type="{{ $type }}" @endif
    {{ $attributes->merge([
        'class' => "inline-flex items-center justify-center gap-2 
                    px-6 py-3 rounded-xl font-bold tracking-wide
                    transition-all duration-300 ease-in-out
                    transform hover:scale-105 active:scale-95
                    focus:outline-none focus:ring-2 focus:ring-amber-400/50
                    border border-amber-500/20
                    {$classes}"
    ]) }}
>
    @if($icon)
        <span class="w-5 h-5">{!! $icon !!}</span>
    @endif
    {{ $slot }}
</{{ $tag }}>