<nav class="sticky top-0 z-50 bg-black
            border-b border-red-900/30 shadow-lg shadow-red-900/20">
    <div class="max-w-7xl mx-auto px-5 h-16 flex items-center justify-between">

        {{-- Logo (نفس السايدبار) --}}
        <a href="{{ route('employee.orders.index') }}" class="flex items-center gap-3">

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

        <div class="flex items-center gap-4 flex-shrink-0">
            <x-user-dropdown :profile-route="route('employee.profile.show')" />
        </div>
    </div>
</nav>
