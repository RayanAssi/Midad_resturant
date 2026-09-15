@props(['paginator'])

@if ($paginator->hasPages())
    <nav class="flex items-center justify-center gap-1 mt-8">
        {{-- Previous --}}
        @if ($paginator->onFirstPage())
            <span
                class="px-4 py-2 rounded-lg bg-black/40 border-2 border-red-900/30
                         text-amber-200/30 cursor-not-allowed">
                ‹ Prev
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}"
                class="px-4 py-2 rounded-lg bg-black/40 border-2 border-red-800/40
                      text-amber-100 hover:border-red-600/60 hover:bg-red-900/30
                      transition-all">
                ‹ Prev
            </a>
        @endif

        {{-- Pages --}}
        @foreach ($paginator->links()->elements[0] ?? [] as $page => $url)
            @if ($page == $paginator->currentPage())
                <span
                    class="px-4 py-2 rounded-lg 
                             bg-gradient-to-r from-red-600 to-red-800
                             text-amber-50 font-bold
                             shadow-lg shadow-red-900/50">
                    {{ $page }}
                </span>
            @else
                <a href="{{ $url }}"
                    class="px-4 py-2 rounded-lg bg-black/40 border-2 border-red-800/40
                          text-amber-100 hover:border-red-600/60 hover:bg-red-900/30
                          transition-all">
                    {{ $page }}
                </a>
            @endif
        @endforeach

        {{-- Next --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}"
                class="px-4 py-2 rounded-lg bg-black/40 border-2 border-red-800/40
                      text-amber-100 hover:border-red-600/60 hover:bg-red-900/30
                      transition-all">
                Next ›
            </a>
        @else
            <span
                class="px-4 py-2 rounded-lg bg-black/40 border-2 border-red-900/30
                         text-amber-200/30 cursor-not-allowed">
                Next ›
            </span>
        @endif
    </nav>
@endif
