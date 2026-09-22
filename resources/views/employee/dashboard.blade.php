<x-layouts.employee title="Dashboard">

    <div class="space-y-6">

        {{-- ═══ Header ═══ --}}
        <div class="flex items-center justify-between flex-wrap gap-4">
            <div>
                <h1 class="text-3xl font-black text-transparent bg-clip-text
                           bg-gradient-to-r from-amber-300 via-orange-400 to-red-500">
                    Welcome, {{ auth()->user()->name }}
                </h1>
                <p class="text-amber-200/60 text-sm mt-1">
                    {{ auth()->user()->getRoleNames()->first() ?? 'Employee' }} Dashboard
                </p>
            </div>
        </div>

        {{-- ═══ الطلبات — للكاشير ═══ --}}
        @can('orders.view')
            <div class="rounded-2xl bg-gradient-to-br from-gray-900 via-gray-800 to-black
                        border-2 border-red-800/30 shadow-2xl overflow-hidden">

                <div class="px-6 py-5 bg-gradient-to-r from-red-900/60 to-transparent
                            border-b-2 border-red-800/50 flex items-center justify-between">
                    <h2 class="text-2xl font-black text-amber-100 flex items-center gap-2">
                        🍽️ Orders
                    </h2>
                    <a href="{{ route('employee.orders.index') }}"
                       class="text-amber-400 hover:text-amber-300 text-sm font-bold transition-all">
                        View All →
                    </a>
                </div>

                <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="p-5 rounded-xl bg-black/40 border border-red-800/30">
                        <p class="text-xs text-amber-200/60 font-bold">Total Orders</p>
                        <p class="text-3xl font-black text-amber-400 mt-2">
                            {{ number_format($stats['orders']['total'] ?? 0) }}
                        </p>
                    </div>

                    <div class="p-5 rounded-xl bg-black/40 border border-amber-800/30">
                        <p class="text-xs text-amber-200/60 font-bold">Today</p>
                        <p class="text-3xl font-black text-amber-400 mt-2">
                            {{ number_format($stats['orders']['today'] ?? 0) }}
                        </p>
                    </div>

                    <div class="p-5 rounded-xl bg-black/40 border border-green-800/30">
                        <p class="text-xs text-amber-200/60 font-bold">Revenue</p>
                        <p class="text-2xl font-black text-green-400 mt-2">
                            {{ number_format($stats['orders']['revenue'] ?? 0, 2) }} SYP
                        </p>
                    </div>
                </div>

                <div class="px-6 pb-6">
                    <a href="{{ route('employee.orders.create') }}"
                       class="inline-flex items-center gap-2 px-6 py-3 rounded-xl
                              bg-gradient-to-r from-emerald-600 to-emerald-800
                              hover:from-emerald-500 hover:to-emerald-700
                              text-white font-bold shadow-lg shadow-emerald-900/50
                              transition-all hover:scale-105 active:scale-95">
                        <span>+</span>
                        Create New Order
                    </a>
                </div>
            </div>
        @endcan

        {{-- ═══ الفواتير ═══ --}}
        @can('invoices.view')
            <div class="rounded-2xl bg-gradient-to-br from-gray-900 via-gray-800 to-black
                        border-2 border-amber-800/30 shadow-2xl overflow-hidden">

                <div class="px-6 py-5 bg-gradient-to-r from-amber-900/60 to-transparent
                            border-b-2 border-amber-800/50 flex items-center justify-between">
                    <h2 class="text-2xl font-black text-amber-100 flex items-center gap-2">
                        🧾 Invoices
                    </h2>
                    <a href="{{ route('employee.invoices.index') }}"
                       class="text-amber-400 hover:text-amber-300 text-sm font-bold transition-all">
                        View All →
                    </a>
                </div>

                <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="p-5 rounded-xl bg-black/40 border border-amber-800/30">
                        <p class="text-xs text-amber-200/60 font-bold">My Invoices</p>
                        <p class="text-3xl font-black text-amber-400 mt-2">
                            {{ number_format($stats['invoices']['total'] ?? 0) }}
                        </p>
                    </div>

                    <div class="p-5 rounded-xl bg-black/40 border border-orange-800/30">
                        <p class="text-xs text-amber-200/60 font-bold">Today</p>
                        <p class="text-3xl font-black text-orange-400 mt-2">
                            {{ number_format($stats['invoices']['today'] ?? 0) }}
                        </p>
                    </div>

                    <div class="p-5 rounded-xl bg-black/40 border border-green-800/30">
                        <p class="text-xs text-amber-200/60 font-bold">Revenue</p>
                        <p class="text-2xl font-black text-green-400 mt-2">
                            {{ number_format($stats['invoices']['revenue'] ?? 0, 2) }} SYP
                        </p>
                    </div>
                </div>
            </div>
        @endcan

        {{-- ═══ المنيو ═══ --}}
        @can('menu-items.view')
            <div class="rounded-2xl bg-gradient-to-br from-gray-900 via-gray-800 to-black
                        border-2 border-blue-800/30 shadow-2xl overflow-hidden">

                <div class="px-6 py-5 bg-gradient-to-r from-blue-900/60 to-transparent
                            border-b-2 border-blue-800/50 flex items-center justify-between">
                    <h2 class="text-2xl font-black text-amber-100 flex items-center gap-2">
                        📖 Menu Items
                    </h2>
                    <a href="{{ route('employee.menu-items.index') }}"
                       class="text-blue-400 hover:text-blue-300 text-sm font-bold transition-all">
                        View All →
                    </a>
                </div>

                <div class="p-6">
                    <div class="p-5 rounded-xl bg-black/40 border border-blue-800/30">
                        <p class="text-xs text-amber-200/60 font-bold">Total Items</p>
                        <p class="text-3xl font-black text-blue-400 mt-2">
                            {{ number_format($stats['menu']['total'] ?? 0) }}
                        </p>
                    </div>
                </div>
            </div>
        @endcan

        {{-- ═══ المصاريف ═══ --}}
        @can('expenses.view')
            <div class="rounded-2xl bg-gradient-to-br from-gray-900 via-gray-800 to-black
                        border-2 border-orange-800/30 shadow-2xl overflow-hidden">

                <div class="px-6 py-5 bg-gradient-to-r from-orange-900/60 to-transparent
                            border-b-2 border-orange-800/50 flex items-center justify-between">
                    <h2 class="text-2xl font-black text-amber-100 flex items-center gap-2">
                        💸 Daily Expenses
                    </h2>
                    <a href="{{ route('admin.expenses.index') }}"
                       class="text-orange-400 hover:text-orange-300 text-sm font-bold transition-all">
                        View All →
                    </a>
                </div>

                <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="p-5 rounded-xl bg-black/40 border border-orange-800/30">
                        <p class="text-xs text-amber-200/60 font-bold">Records</p>
                        <p class="text-3xl font-black text-orange-400 mt-2">
                            {{ number_format($stats['expenses']['count'] ?? 0) }}
                        </p>
                    </div>

                    <div class="p-5 rounded-xl bg-black/40 border border-red-800/30">
                        <p class="text-xs text-amber-200/60 font-bold">Today</p>
                        <p class="text-2xl font-black text-red-400 mt-2">
                            {{ number_format($stats['expenses']['today'] ?? 0, 2) }} SYP
                        </p>
                    </div>

                    <div class="p-5 rounded-xl bg-black/40 border border-red-800/30">
                        <p class="text-xs text-amber-200/60 font-bold">Total</p>
                        <p class="text-2xl font-black text-red-400 mt-2">
                            {{ number_format($stats['expenses']['total'] ?? 0, 2) }} SYP
                        </p>
                    </div>
                </div>
            </div>
        @endcan

    </div>

</x-layouts.employee>