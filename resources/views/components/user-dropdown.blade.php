@props([
    'name' => auth()->user()->name ?? 'Guest',
    'email' => auth()->user()->email ?? 'guest@midad.test',
    'profileRoute' => '#',
])

<div class="relative" id="userDropdownContainer">

    {{-- Trigger --}}
    <div id="userDropdownTrigger" class="flex items-center gap-3 cursor-pointer select-none group">

        <div class="text-right hidden sm:block">
            <p class="text-sm font-medium text-amber-50 group-hover:text-white transition-colors">
                {{ $name }}
            </p>
            <p class="text-[10px] text-amber-200/40">{{ $email }}</p>
        </div>

        <div
            class="w-10 h-10 rounded-full
                    bg-gradient-to-br from-amber-500 to-red-700
                    flex items-center justify-center
                    text-white font-bold text-sm
                    ring-2 ring-transparent group-hover:ring-amber-500/40
                    transition-all duration-300">
            {{ strtoupper(substr($name, 0, 1)) }}
        </div>

        <svg id="dropdownArrow" class="w-4 h-4 text-amber-200/50 transition-transform duration-300" fill="none"
            stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
        </svg>
    </div>

    {{-- Menu --}}
    <div id="userDropdownMenu"
        class="absolute right-0 mt-4 w-56
               opacity-0 invisible translate-y-2
               transition-all duration-200 ease-out z-50">

        {{-- Floating card --}}
        <div
            class="relative bg-[#131313]/95 backdrop-blur-md
                    border border-white/[0.08] rounded-2xl
                    shadow-[0_25px_50px_-12px_rgba(0,0,0,0.9)]
                    p-1.5">

            {{--  Profile (ديناميكي) --}}
            <a href="{{ $profileRoute }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm
                text-amber-100/80 hover:text-amber-50 hover:bg-amber-500/[0.08]
                transition-all duration-150">
                <svg class="w-4 h-4 text-amber-200/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                Profile
            </a>

            {{-- Help & Support --}}
            <button type="button" onclick="openHelpModal()"
                class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm
                    text-amber-100/80 hover:text-amber-50 hover:bg-amber-500/[0.08]
                    transition-all duration-150">
                <svg class="w-4 h-4 text-amber-200/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Help & Support
            </button>

            <div class="h-px bg-white/[0.06] mx-3 my-1"></div>

            {{-- Logout --}}
            <button type="button" onclick="openLogoutModal()"
                class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm
                       text-red-400/90 hover:text-red-300 hover:bg-red-500/[0.08]
                       transition-all duration-150">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                Logout
            </button>
        </div>
    </div>
</div>

{{-- Script --}}
<script>
    (function() {
        const trigger = document.getElementById('userDropdownTrigger');
        const menu = document.getElementById('userDropdownMenu');
        const arrow = document.getElementById('dropdownArrow');
        const container = document.getElementById('userDropdownContainer');

        if (!trigger || !menu || !container) return;

        trigger.addEventListener('click', function(e) {
            e.stopPropagation();
            const isOpen = menu.classList.contains('opacity-100');
            isOpen ? closeMenu() : openMenu();
        });

        document.addEventListener('click', function(e) {
            if (!container.contains(e.target)) closeMenu();
        });

        function openMenu() {
            menu.classList.remove('opacity-0', 'invisible', 'translate-y-2');
            menu.classList.add('opacity-100', 'visible', 'translate-y-0');
            arrow.classList.add('rotate-180');
        }

        function closeMenu() {
            menu.classList.add('opacity-0', 'invisible', 'translate-y-2');
            menu.classList.remove('opacity-100', 'visible', 'translate-y-0');
            arrow.classList.remove('rotate-180');
        }
    })();
</script>