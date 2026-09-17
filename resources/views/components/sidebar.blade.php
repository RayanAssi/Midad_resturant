@props([
    'items' => [],
    'title' => 'MIDAD',
    'subtitle' => 'Restaurant',
])

<aside
    class="fixed top-0 left-0 z-40 h-screen w-64 
              bg-black
              border-r border-red-900/30
              flex flex-col">

    {{-- Logo --}}
    <div class="flex items-center gap-3 px-5 py-3.5
                border-b border-red-900/30">

        <div
            class="w-10 h-10 rounded-lg
                    bg-red-600
                    flex items-center justify-center
                    shadow-lg shadow-red-900/40">
            <x-lucide-chef-hat class="w-5 h-5 text-white" />
        </div>

        <div>
            <h1 class="text-base font-bold text-white tracking-wide">
                {{ $title }}
            </h1>
            <p class="text-[10px] text-red-200/40 uppercase tracking-widest">
                {{ $subtitle }}
            </p>
        </div>
    </div>

    {{-- Nav --}}
    <nav class="flex-1 overflow-y-auto py-4 px-3 space-y-1">
        @foreach ($items as $item)
            @php
                $isActive = request()->routeIs($item['active'] ?? '');
            @endphp

            <a href="{{ route($item['route']) }}"
                class="group flex items-center gap-3 px-3 py-2.5 rounded-lg
                      text-sm font-medium
                      transition-colors duration-150
                      {{ $isActive ? 'bg-red-600/15 text-orange-400' : 'text-gray-400 hover:text-orange-400 hover:bg-red-600/10' }}">

                {{-- Icon --}}
                @switch($item['icon'])
                    @case('utensils')
                        <x-lucide-utensils class="w-5 h-5 flex-shrink-0" />
                    @break

                    @case('receipt')
                        <x-lucide-receipt class="w-5 h-5 flex-shrink-0" />
                    @break

                    @case('file-text')
                        <x-lucide-file-text class="w-5 h-5 flex-shrink-0" />
                    @break

                    @case('wallet')
                        <x-lucide-wallet class="w-5 h-5 flex-shrink-0" />
                    @break

                    @case('plus-circle')
                        <x-lucide-plus-circle class="w-5 h-5 flex-shrink-0" />
                    @break

                    @case('layout-dashboard')
                        <x-lucide-layout-dashboard class="w-5 h-5 flex-shrink-0" />
                    @break

                    @default
                        <x-lucide-circle class="w-5 h-5 flex-shrink-0" />
                @endswitch

                {{-- Label --}}
                <span class="flex-1 truncate">{{ $item['label'] }}</span>

                {{-- Active Dot --}}
                @if ($isActive)
                    <span class="w-1.5 h-1.5 rounded-full bg-orange-400"></span>
                @endif
            </a>
        @endforeach
    </nav>

    {{-- Logout --}}
    {{-- Logout Button --}}
    {{-- <div class="border-t border-red-900/30 p-3">
        <button type="button" onclick="openLogoutModal()"
            class="w-full flex items-center justify-center gap-2 px-3 py-2.5 rounded-lg
                   text-sm font-medium
                   text-gray-400
                   bg-red-900/10
                   border border-red-900/40
                   hover:text-red-400
                   hover:bg-red-600/10
                   hover:border-red-600/60
                   transition-all duration-200">
            <x-lucide-log-out class="w-5 h-5" />
            <span>Logout</span>
        </button>
    </div> --}}

    @auth
    <button type="button"
            onclick="openLogoutModal()"
            class="inline-flex items-center gap-2 px-3 py-2 rounded-lg
                   bg-red-900/30 hover:bg-red-900/50
                   border border-red-800/50 hover:border-red-600/60
                   text-amber-100 text-sm font-bold
                   transition-all">
        <x-lucide-log-out class="w-4 h-4" />
        <span class="hidden sm:inline">Logout</span>
    </button>
@endauth
</aside>
{{-- <x-logout-modal /> --}}
