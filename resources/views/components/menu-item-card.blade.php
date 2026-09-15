@props([
    'item',
    'editable' => false,
    'deletable' => false,
    'orderable' => false,
])

@php
    $colors = [
        'appetizer'   => [
            'card'  => 'from-amber-950 via-amber-900 to-black border-amber-700/50',
            'badge' => 'bg-amber-500/20 text-amber-300 border-amber-500/40',
        ],
        'main_course' => [
            'card'  => 'from-red-950 via-red-900 to-black border-red-700/50',
            'badge' => 'bg-red-500/20 text-red-300 border-red-500/40',
        ],
        'dessert'     => [
            'card'  => 'from-pink-950 via-pink-900 to-black border-pink-700/50',
            'badge' => 'bg-pink-500/20 text-pink-300 border-pink-500/40',
        ],
        'beverage'    => [
            'card'  => 'from-orange-950 via-orange-900 to-black border-orange-700/50',
            'badge' => 'bg-orange-500/20 text-orange-300 border-orange-500/40',
        ],
    ];

    $theme = $colors[$item->category] ?? [
        'card'  => 'from-gray-900 via-gray-800 to-black border-red-800/30',
        'badge' => 'bg-gray-500/20 text-gray-300 border-gray-500/40',
    ];
@endphp

<div class="group relative bg-gradient-to-br {{ $theme['card'] }}
            rounded-2xl shadow-2xl shadow-red-900/20
            border-2 transition-all duration-300
            hover:shadow-red-700/30 hover:border-red-600/60
            hover:-translate-y-1
            overflow-hidden flex flex-col">

    {{-- Top accent bar --}}
    <div class="absolute top-0 left-0 right-0 h-1 z-10
                bg-gradient-to-r from-red-600 via-orange-500 to-amber-400"></div>

    {{-- Image --}}
    <div class="relative h-44 overflow-hidden bg-black/40">
        <img src="{{ $item->image_url }}"
             alt="{{ $item->name }}"
             class="w-full h-full object-cover
                    group-hover:scale-110 transition-transform duration-500" />

        <div class="absolute inset-0 bg-gradient-to-t 
                    from-black via-black/40 to-transparent"></div>

        {{-- Category badge --}}
        <span class="absolute top-3 right-3 text-xs font-bold 
                     px-3 py-1 rounded-full border backdrop-blur-sm
                     {{ $theme['badge'] }}">
            {{ $item->category_label }}
        </span>
    </div>

    {{-- Content --}}
    <div class="p-5 flex-1 flex flex-col">
        <h3 class="text-lg font-bold text-amber-100 tracking-wide mb-1 line-clamp-1">
            {{ $item->name }}
        </h3>

        <div class="mt-auto pt-3 flex items-baseline gap-1">
            <span class="text-2xl font-black text-transparent bg-clip-text 
                         bg-gradient-to-r from-amber-300 to-orange-400">
                {{ number_format($item->price, 2) }}
            </span>
            <span class="text-xs text-amber-200/60 font-medium">SYP</span>
        </div>
    </div>

    {{-- Actions --}}
    @if($editable || $deletable || $orderable)
        <div class="px-5 py-3 
                    bg-gradient-to-r from-red-900/30 to-transparent
                    border-t-2 border-red-800/40
                    flex items-center gap-2 justify-end">

            @if($orderable)
                <button type="button"
                        onclick="addToCart({{ $item->id }}, '{{ addslashes($item->name) }}', {{ $item->price }})"
                        class="flex-1 inline-flex items-center justify-center gap-2
                               px-3 py-2 rounded-lg
                               bg-gradient-to-r from-red-600 to-red-800
                               hover:from-red-500 hover:to-red-700
                               text-amber-50 text-sm font-bold
                               shadow-lg shadow-red-900/50
                               transition-all hover:scale-105 active:scale-95">
                    + Add
                </button>
            @endif

            @if($editable)
                <a href="{{ route('admin.menu-items.edit', $item) }}"
                   class="inline-flex items-center justify-center w-9 h-9 rounded-lg
                          bg-amber-500/20 hover:bg-amber-500/30
                          border border-amber-500/40 text-amber-300
                          transition-all hover:scale-110">
                    <x-lucide-edit class="w-4 h-4" />
                </a>
            @endif

            @if($deletable)
                <form action="{{ route('admin.menu-items.destroy', $item) }}"
                      method="POST"
                      onsubmit="return confirm('Delete {{ addslashes($item->name) }}?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="inline-flex items-center justify-center w-9 h-9 rounded-lg
                                   bg-red-500/20 hover:bg-red-500/30
                                   border border-red-500/40 text-red-300
                                   transition-all hover:scale-110">
                        <x-lucide-trash class="w-4 h-4" />
 
                    </button>
                </form>
            @endif
        </div>
    @endif
</div>