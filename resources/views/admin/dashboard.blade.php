<x-layouts.admin title="Dashboard">

    {{-- ═══ Header ═══ --}}
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-black text-transparent bg-clip-text
                       bg-gradient-to-r from-amber-300 to-orange-400">
                Dashboard
            </h1>
            <p class="text-amber-200/60 text-sm mt-1">
                Welcome back Maneger {{-- {{ auth('admin')->user()->name }} --}}
            </p>
        </div>
        <div class="text-right text-sm">
            <p class="text-amber-200/60">{{ now()->format('l, F j, Y') }}</p>
        </div>
    </div>

    {{-- ═══ Stats Cards ═══ --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">

        {{-- Orders Today --}}
        <div class="rounded-2xl bg-gradient-to-br from-gray-900 via-gray-800 to-black
                    border-2 border-amber-500/30 p-5 shadow-xl shadow-amber-900/10">
            <div class="flex items-start justify-between mb-3">
                <div class="p-2.5 rounded-lg bg-amber-500/10 border border-amber-400/30">
                    <x-lucide-shopping-bag class="w-5 h-5 text-amber-300" />
                </div>
                @if($ordersChange >= 0)
                    <span class="text-xs font-bold text-emerald-300 flex items-center gap-1">
                        <x-lucide-trending-up class="w-3.5 h-3.5" />
                        {{ number_format($ordersChange, 1) }}%
                    </span>
                @else
                    <span class="text-xs font-bold text-red-300 flex items-center gap-1">
                        <x-lucide-trending-down class="w-3.5 h-3.5" />
                        {{ number_format(abs($ordersChange), 1) }}%
                    </span>
                @endif
            </div>
            <p class="text-amber-200/60 text-xs uppercase tracking-wider mb-1">Orders Today</p>
            <p class="text-3xl font-black text-amber-100">{{ $ordersToday }}</p>
        </div>

        {{-- Revenue Today --}}
        <div class="rounded-2xl bg-gradient-to-br from-gray-900 via-gray-800 to-black
                    border-2 border-emerald-500/30 p-5 shadow-xl shadow-emerald-900/10">
            <div class="flex items-start justify-between mb-3">
                <div class="p-2.5 rounded-lg bg-emerald-500/10 border border-emerald-400/30">
                    <x-lucide-dollar-sign class="w-5 h-5 text-emerald-300" />
                </div>
                @if($revenueChange >= 0)
                    <span class="text-xs font-bold text-emerald-300 flex items-center gap-1">
                        <x-lucide-trending-up class="w-3.5 h-3.5" />
                        {{ number_format($revenueChange, 1) }}%
                    </span>
                @else
                    <span class="text-xs font-bold text-red-300 flex items-center gap-1">
                        <x-lucide-trending-down class="w-3.5 h-3.5" />
                        {{ number_format(abs($revenueChange), 1) }}%
                    </span>
                @endif
            </div>
            <p class="text-emerald-200/60 text-xs uppercase tracking-wider mb-1">Revenue Today</p>
            <p class="text-2xl font-black text-emerald-100">
                {{ number_format($revenueToday, 0) }}
                <span class="text-sm">{{ config('restaurant.currency') }}</span>
            </p>
        </div>

        {{-- Invoices Today --}}
        <div class="rounded-2xl bg-gradient-to-br from-gray-900 via-gray-800 to-black
                    border-2 border-blue-500/30 p-5 shadow-xl shadow-blue-900/10">
            <div class="flex items-start justify-between mb-3">
                <div class="p-2.5 rounded-lg bg-blue-500/10 border border-blue-400/30">
                    <x-lucide-file-text class="w-5 h-5 text-blue-300" />
                </div>
                @if($invoicesChange >= 0)
                    <span class="text-xs font-bold text-emerald-300 flex items-center gap-1">
                        <x-lucide-trending-up class="w-3.5 h-3.5" />
                        {{ number_format($invoicesChange, 1) }}%
                    </span>
                @else
                    <span class="text-xs font-bold text-red-300 flex items-center gap-1">
                        <x-lucide-trending-down class="w-3.5 h-3.5" />
                        {{ number_format(abs($invoicesChange), 1) }}%
                    </span>
                @endif
            </div>
            <p class="text-blue-200/60 text-xs uppercase tracking-wider mb-1">Invoices Today</p>
            <p class="text-3xl font-black text-blue-100">{{ $invoicesToday }}</p>
        </div>

        {{-- Expenses Today --}}
        <div class="rounded-2xl bg-gradient-to-br from-gray-900 via-gray-800 to-black
                    border-2 border-red-500/30 p-5 shadow-xl shadow-red-900/10">
            <div class="flex items-start justify-between mb-3">
                <div class="p-2.5 rounded-lg bg-red-500/10 border border-red-400/30">
                    <x-lucide-receipt class="w-5 h-5 text-red-300" />
                </div>
                @if($expensesChange <= 0)
                    <span class="text-xs font-bold text-emerald-300 flex items-center gap-1">
                        <x-lucide-trending-down class="w-3.5 h-3.5" />
                        {{ number_format(abs($expensesChange), 1) }}%
                    </span>
                @else
                    <span class="text-xs font-bold text-red-300 flex items-center gap-1">
                        <x-lucide-trending-up class="w-3.5 h-3.5" />
                        {{ number_format($expensesChange, 1) }}%
                    </span>
                @endif
            </div>
            <p class="text-red-200/60 text-xs uppercase tracking-wider mb-1">Expenses Today</p>
            <p class="text-2xl font-black text-red-100">
                {{ number_format($expensesToday, 0) }}
                <span class="text-sm">{{ config('restaurant.currency') }}</span>
            </p>
        </div>

    </div>

    {{-- ═══ Chart + Quick Actions ═══ --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">

        {{-- Sales Chart --}}
        <div class="lg:col-span-2 rounded-2xl bg-gradient-to-br from-gray-900 via-gray-800 to-black
                    border-2 border-amber-500/20 p-6">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-xl font-black text-amber-100">Sales Last 7 Days</h2>
                    <p class="text-amber-200/50 text-xs mt-0.5">Daily revenue overview</p>
                </div>
                <div class="p-2 rounded-lg bg-amber-500/10 border border-amber-400/30">
                    <x-lucide-bar-chart-3 class="w-5 h-5 text-amber-300" />
                </div>
            </div>

            <div class="flex items-end justify-between gap-2 h-48">
                @foreach($salesLast7Days as $day)
                    @php
                        $height = $maxSale > 0 ? ($day['total'] / $maxSale) * 100 : 0;
                        $height = max($height, 2);
                    @endphp
                    <div class="flex-1 flex flex-col items-center gap-2 group">
                        <div class="w-full flex items-end justify-center" style="height: 160px;">
                            <div class="w-full rounded-t-lg bg-gradient-to-t
                                        from-amber-600 to-amber-400
                                        group-hover:from-amber-500 group-hover:to-amber-300
                                        transition-all relative"
                                 style="height: {{ $height }}%;"
                                 title="{{ number_format($day['total'], 0) }} {{ config('restaurant.currency') }}">
                                <div class="absolute -top-7 left-1/2 -translate-x-1/2
                                            opacity-0 group-hover:opacity-100
                                            bg-black/80 text-amber-100 text-xs
                                            px-2 py-1 rounded whitespace-nowrap
                                            transition-opacity">
                                    {{ number_format($day['total'], 0) }}
                                </div>
                            </div>
                        </div>
                        <span class="text-xs text-amber-200/60 font-bold">{{ $day['date'] }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Quick Actions --}}
        <div class="rounded-2xl bg-gradient-to-br from-gray-900 via-gray-800 to-black
                    border-2 border-amber-500/20 p-6">
            <h2 class="text-xl font-black text-amber-100 mb-4">Quick Actions</h2>

            <div class="space-y-3">

                <a href="{{ route('admin.orders.create') }}"
                   class="flex items-center gap-3 p-3 rounded-xl
                          bg-amber-500/10 border border-amber-500/30
                          hover:bg-amber-500/20 hover:border-amber-400/60
                          transition-all group">
                    <div class="p-2 rounded-lg bg-amber-500/20 group-hover:bg-amber-500/30">
                        <x-lucide-plus-circle class="w-5 h-5 text-amber-300" />
                    </div>
                    <div>
                        <p class="text-amber-100 font-bold text-sm">New Order</p>
                        <p class="text-amber-200/50 text-xs">Create a new customer order</p>
                    </div>
                </a>

                <a href="{{ route('admin.invoices.index') }}"
                   class="flex items-center gap-3 p-3 rounded-xl
                          bg-blue-500/10 border border-blue-500/30
                          hover:bg-blue-500/20 hover:border-blue-400/60
                          transition-all group">
                    <div class="p-2 rounded-lg bg-blue-500/20 group-hover:bg-blue-500/30">
                        <x-lucide-file-plus class="w-5 h-5 text-blue-300" />
                    </div>
                    <div>
                        <p class="text-blue-100 font-bold text-sm">Invoices</p>
                        <p class="text-blue-200/50 text-xs">View all invoices</p>
                    </div>
                </a>

                <a href="{{ route('admin.menu-items.index') }}"
                   class="flex items-center gap-3 p-3 rounded-xl
                          bg-emerald-500/10 border border-emerald-500/30
                          hover:bg-emerald-500/20 hover:border-emerald-400/60
                          transition-all group">
                    <div class="p-2 rounded-lg bg-emerald-500/20 group-hover:bg-emerald-500/30">
                        <x-lucide-utensils class="w-5 h-5 text-emerald-300" />
                    </div>
                    <div>
                        <p class="text-emerald-100 font-bold text-sm">Menu Items</p>
                        <p class="text-emerald-200/50 text-xs">Manage menu</p>
                    </div>
                </a>

                <a href="{{ route('admin.expenses.index') }}"
                   class="flex items-center gap-3 p-3 rounded-xl
                          bg-red-500/10 border border-red-500/30
                          hover:bg-red-500/20 hover:border-red-400/60
                          transition-all group">
                    <div class="p-2 rounded-lg bg-red-500/20 group-hover:bg-red-500/30">
                        <x-lucide-wallet class="w-5 h-5 text-red-300" />
                    </div>
                    <div>
                        <p class="text-red-100 font-bold text-sm">Expenses</p>
                        <p class="text-red-200/50 text-xs">Track expenses</p>
                    </div>
                </a>

            </div>
        </div>

    </div>

    {{-- ═══ Recent Orders + Top Items ═══ --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        {{-- Recent Orders --}}
        <div class="rounded-2xl bg-gradient-to-br from-gray-900 via-gray-800 to-black
                    border-2 border-amber-500/20 overflow-hidden">
            <div class="px-6 py-4 border-b border-amber-500/20 flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-black text-amber-100">Recent Orders</h2>
                    <p class="text-amber-200/50 text-xs mt-0.5">Latest 5 orders</p>
                </div>
                <a href="{{ route('admin.orders.index') }}"
                   class="text-xs text-amber-300 hover:text-amber-200
                          flex items-center gap-1 transition-colors">
                    View All
                    <x-lucide-arrow-right class="w-3.5 h-3.5" />
                </a>
            </div>

            @if($recentOrders->isEmpty())
                <div class="p-12 text-center">
                    <x-lucide-inbox class="w-10 h-10 text-amber-200/20 mx-auto mb-2" />
                    <p class="text-amber-200/40 text-sm">No orders yet</p>
                </div>
            @else
                <div class="divide-y divide-amber-500/10">
                    @foreach($recentOrders as $order)
                        <a href="{{ route('admin.orders.show', $order->id) }}"
                           class="flex items-center justify-between px-6 py-3
                                  hover:bg-amber-500/5 transition-colors">
                            <div class="flex items-center gap-3">
                                <div class="p-2 rounded-lg bg-amber-500/10 border border-amber-400/30">
                                    <x-lucide-shopping-cart class="w-4 h-4 text-amber-300" />
                                </div>
                                <div>
                                    <p class="text-amber-100 font-bold text-sm">Order #{{ $order->id }}</p>
                                    <p class="text-amber-200/50 text-xs capitalize">
                                        {{ str_replace('_', ' ', $order->type) }}
                                    </p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-amber-100 font-bold text-sm">
                                    {{ number_format($order->total_amount, 0) }}
                                    <span class="text-xs">{{ config('restaurant.currency') }}</span>
                                </p>
                                <p class="text-amber-200/40 text-xs">
                                    {{ $order->created_at->diffForHumans() }}
                                </p>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Top Selling Items --}}
        <div class="rounded-2xl bg-gradient-to-br from-gray-900 via-gray-800 to-black
                    border-2 border-amber-500/20 overflow-hidden">
            <div class="px-6 py-4 border-b border-amber-500/20 flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-black text-amber-100">Top Selling Items</h2>
                    <p class="text-amber-200/50 text-xs mt-0.5">Best performers</p>
                </div>
                <div class="p-2 rounded-lg bg-amber-500/10 border border-amber-400/30">
                    <x-lucide-trophy class="w-4 h-4 text-amber-300" />
                </div>
            </div>

            @if($topItems->isEmpty())
                <div class="p-12 text-center">
                    <x-lucide-inbox class="w-10 h-10 text-amber-200/20 mx-auto mb-2" />
                    <p class="text-amber-200/40 text-sm">No data yet</p>
                </div>
            @else
                <div class="divide-y divide-amber-500/10">
                    @foreach($topItems as $index => $item)
                        <div class="flex items-center gap-4 px-6 py-3">
                            <div class="w-8 h-8 rounded-lg flex items-center justify-center
                                        font-black text-sm
                                        @if($index === 0) bg-amber-500/20 text-amber-300 border border-amber-400/40
                                        @elseif($index === 1) bg-gray-400/10 text-gray-300 border border-gray-400/30
                                        @elseif($index === 2) bg-orange-500/15 text-orange-300 border border-orange-400/30
                                        @else bg-amber-500/5 text-amber-200/50 border border-amber-500/20
                                        @endif">
                                {{ $index + 1 }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-amber-100 font-bold text-sm truncate">
                                    {{ $item->name }}
                                </p>
                            </div>
                            <div class="text-right">
                                <p class="text-amber-100 font-bold text-sm">
                                    {{ $item->total_qty }}
                                </p>
                                <p class="text-amber-200/40 text-xs">orders</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

    </div>

</x-layouts.admin>