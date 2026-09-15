@props([
    'title' => null,
    'subtitle' => null,
    'icon' => null,
    'variant' => 'default',
    'padding' => 'p-6',
])

@php
    $variants = [
        'default' => 'from-gray-900 via-gray-800 to-black border-red-800/30',
        'danger' => 'from-red-950 via-red-900 to-black border-red-700/50',
        'gold' => 'from-amber-950 via-amber-900 to-black border-amber-700/50',
        'success' => 'from-green-950 via-green-900 to-black border-green-700/50',
    ];
    
    $variantClass = $variants[$variant] ?? $variants['default'];
@endphp

<div {{ $attributes->merge([
    'class' => "bg-gradient-to-br {$variantClass} 
                rounded-2xl shadow-2xl shadow-red-900/20
                border-2 backdrop-blur-sm
                transition-all duration-300
                hover:shadow-red-700/30 hover:border-red-600/50
                overflow-hidden"
]) }}>
    
    {{-- رأس الكارد --}}
    @if($title || $icon || isset($header))
        <div class="flex items-center justify-between 
                    px-6 py-4 
                    bg-gradient-to-r from-red-900/40 to-transparent
                    border-b-2 border-red-800/40">
            
            <div class="flex items-center gap-3">
                @if($icon)
                    <div class="w-10 h-10 rounded-xl 
                                bg-gradient-to-br from-red-600 to-red-800
                                flex items-center justify-center
                                shadow-lg shadow-red-900/50">
                        <span class="text-amber-100 w-5 h-5">
                            {!! $icon !!}
                        </span>
                    </div>
                @endif
                
                <div>
                    @if($title)
                        <h3 class="text-lg font-bold text-amber-100 tracking-wide">
                            {{ $title }}
                        </h3>
                    @endif
                    
                    @if($subtitle)
                        <p class="text-sm text-amber-200/60 mt-0.5">
                            {{ $subtitle }}
                        </p>
                    @endif
                </div>
            </div>
            
            {{-- أزرار أو إجراءات اختيارية --}}
            @if(isset($actions))
                <div class="flex items-center gap-2">
                    {{ $actions }}
                </div>
            @endif
        </div>
    @endif
    
    {{-- محتوى الكارد --}}
    <div class="{{ $padding }}">
        {{ $slot }}
    </div>
    
    {{-- تذييل الكارد (اختياري) --}}
    @if(isset($footer))
        <div class="px-6 py-4 
                    bg-gradient-to-r from-transparent to-red-900/20
                    border-t-2 border-red-800/40">
            {{ $footer }}
        </div>
    @endif
</div>