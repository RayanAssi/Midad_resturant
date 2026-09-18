@props([])

<header
    class="sticky top-0 z-30 
               bg-black/80 backdrop-blur-md
               border-b-2 border-red-900/40
               shadow-lg shadow-red-950/20">

    <div class="flex items-center justify-between h-17 px-6 gap-4">

        {{-- Breadcrumb --}}
        <x-breadcrumb />

        {{-- Right Side --}}
        {{-- <div class="flex items-center gap-4 flex-shrink-0"> --}}

            {{-- User --}}
            {{-- <div class="flex items-center gap-3">
                <div class="text-right hidden sm:block">
                    <p class="text-sm font-bold text-amber-100">
                        {{ auth()->user()->name ?? 'Guest' }}
                    </p>
                    <p class="text-[10px] text-amber-200/50">
                        {{ auth()->user()->email ?? 'guest@midad.test' }}
                    </p>
                </div>
                <div
                    class="w-10 h-10 rounded-full 
                            bg-gradient-to-br from-amber-500 to-red-700
                            flex items-center justify-center
                            text-white font-black 
                            shadow-lg shadow-red-900/50">
                    {{ strtoupper(substr(auth()->user()->name ?? 'G', 0, 1)) }}
                </div>
            </div>
        </div> --}}
        {{-- Right Side --}}
        <div class="flex items-center gap-4 flex-shrink-0">
            <x-user-dropdown />
        </div>
    </div>
</header>
