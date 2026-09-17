<nav class="sticky top-0 z-50 bg-black
            border-b border-red-900/30 shadow-lg shadow-red-900/20">
    <div class="max-w-7xl mx-auto px-5 h-16 flex items-center justify-between">

        {{-- Logo (نفس السايدبار) --}}
        <a href="{{ route('cashier.orders.index') }}" class="flex items-center gap-3">

            <div
                class="w-10 h-10 rounded-lg
                        bg-red-600
                        flex items-center justify-center
                        shadow-lg shadow-red-900/40">
                <x-lucide-chef-hat class="w-5 h-5 text-white" />
            </div>

            <div>
                <h1 class="text-base font-bold text-white tracking-wide">
                    MIDAD
                </h1>
                <p class="text-[10px] text-red-200/40 uppercase tracking-widest">
                    Restaurant
                </p>
            </div>
        </a>


        {{-- <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="flex items-center gap-2 px-3 py-2 rounded-lg
                               text-sm font-medium
                               text-gray-400
                               bg-red-900/10
                               border border-red-900/40
                               hover:text-red-400
                               hover:bg-red-600/10
                               hover:border-red-600/60
                               transition-all duration-200">
                    <x-lucide-log-out class="w-4 h-4" />
                    Logout
                </button>
            </form> --}}
        @auth
            <button type="button" onclick="openLogoutModal()"
                class="flex items-center gap-2 px-3 py-2 rounded-lg
               text-sm font-medium
               text-gray-400
               bg-red-900/10
               border border-red-900/40
               hover:text-red-400
               hover:bg-red-600/10
               hover:border-red-600/60
               transition-all duration-200">
                <x-lucide-log-out class="w-4 h-4" />
                <span>Logout</span>
            </button>
        @endauth
    </div>
    </div>
</nav>
