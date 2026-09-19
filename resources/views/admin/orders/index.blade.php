<x-layouts.admin title="Orders Management">

    <div class="space-y-6">

        {{-- ============ Header ============ --}}
        <div class="flex items-center justify-between flex-wrap gap-4">
            <div>
                <h1 class="text-3xl font-black text-transparent bg-clip-text
                           bg-gradient-to-r from-amber-300 via-orange-400 to-red-500">
                    Orders Management
                </h1>
                <p class="text-amber-200/60 text-sm mt-1">
                    View and manage all restaurant orders
                </p>
            </div>

            <a href="{{ route('admin.orders.create') }}"
               class="inline-flex items-center gap-2 px-6 py-3 rounded-xl
                      bg-gradient-to-r from-red-600 to-red-800
                      hover:from-red-500 hover:to-red-700
                      text-amber-50 font-bold shadow-lg shadow-red-900/50
                      transition-all hover:scale-105 active:scale-95">
                <span class="text-lg">+</span>
                New Order
            </a>
        </div>

        {{-- ============ Stats Cards ============ --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">

            <div class="rounded-2xl bg-gradient-to-br from-gray-900 via-gray-800 to-black
                        border-2 border-red-800/30 shadow-lg shadow-red-900/20 p-5">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-2xl">📋</span>
                    <span class="text-[10px] font-bold text-red-300/60 uppercase tracking-wider">
                        All Time
                    </span>
                </div>
                <p class="text-xs text-amber-200/60 font-bold">Total Orders</p>
                <p class="text-3xl font-black text-amber-400 mt-1">
                    {{ number_format($stats['total'] ?? 0) }}
                </p>
            </div>

            <div class="rounded-2xl bg-gradient-to-br from-gray-900 via-gray-800 to-black
                        border-2 border-amber-500/30 shadow-lg shadow-amber-900/20 p-5">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-2xl">📅</span>
                    <span class="text-[10px] font-bold text-amber-300/60 uppercase tracking-wider">
                        Today
                    </span>
                </div>
                <p class="text-xs text-amber-200/60 font-bold">Today's Orders</p>
                <p class="text-3xl font-black text-amber-400 mt-1">
                    {{ number_format($stats['today'] ?? 0) }}
                </p>
            </div>

            <div class="rounded-2xl bg-gradient-to-br from-gray-900 via-gray-800 to-black
                        border-2 border-green-500/30 shadow-lg shadow-green-900/20 p-5">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-2xl">💰</span>
                    <span class="text-[10px] font-bold text-green-300/60 uppercase tracking-wider">
                        All Time
                    </span>
                </div>
                <p class="text-xs text-amber-200/60 font-bold">Total Revenue</p>
                <p class="text-2xl font-black text-green-400 mt-1">
                    {{ number_format($stats['revenue'] ?? 0, 2) }}
                    <span class="text-xs">SYP</span>
                </p>
            </div>

            <div class="rounded-2xl bg-gradient-to-br from-gray-900 via-gray-800 to-black
                        border-2 border-orange-500/30 shadow-lg shadow-orange-900/20 p-5">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-2xl">📊</span>
                    <span class="text-[10px] font-bold text-orange-300/60 uppercase tracking-wider">
                        Average
                    </span>
                </div>
                <p class="text-xs text-amber-200/60 font-bold">Avg. Order</p>
                <p class="text-2xl font-black text-orange-400 mt-1">
                    {{ number_format($stats['average'] ?? 0, 2) }}
                    <span class="text-xs">SYP</span>
                </p>
            </div>
        </div>

        {{-- ============ Filter Tabs ============ --}}
        <div class="rounded-2xl bg-gradient-to-br from-gray-900 via-gray-800 to-black
                    border-2 border-red-800/30 shadow-lg overflow-hidden">
            <div class="p-3 flex items-center gap-2 overflow-x-auto">

                {{-- All --}}
                <a href="{{ route('admin.orders.index', array_filter(request()->except('type', 'page'))) }}"
                   class="flex items-center gap-2 px-5 py-2.5 rounded-xl font-bold text-sm
                          transition-all whitespace-nowrap
                          @if(!request('type'))
                              bg-gradient-to-r from-amber-600 to-amber-700 text-white shadow-lg shadow-amber-900/40
                          @else
                              bg-black/40 text-amber-200/70 hover:bg-red-900/30 hover:text-amber-100
                              border border-red-800/30
                          @endif">
                    <span>🎯</span>
                    <span>All Orders</span>
                    <span class="px-2 py-0.5 rounded-full text-[10px] font-black
                                 @if(!request('type')) bg-white/20 @else bg-red-900/40 @endif">
                        {{ $stats['total'] ?? 0 }}
                    </span>
                </a>

                {{-- Dine In --}}
                <a href="{{ route('admin.orders.index', array_merge(request()->except('type', 'page'), ['type' => 'dine_in'])) }}"
                   class="flex items-center gap-2 px-5 py-2.5 rounded-xl font-bold text-sm
                          transition-all whitespace-nowrap
                          @if(request('type') === 'dine_in')
                              bg-gradient-to-r from-amber-600 to-amber-700 text-white shadow-lg shadow-amber-900/40
                          @else
                              bg-black/40 text-amber-200/70 hover:bg-amber-900/30 hover:text-amber-100
                              border border-amber-800/30
                          @endif">
                    <span>🍽️</span>
                    <span>Dine In</span>
                    <span class="px-2 py-0.5 rounded-full text-[10px] font-black
                                 @if(request('type') === 'dine_in') bg-white/20 @else bg-amber-900/40 @endif">
                        {{ $typeCounts['dine_in'] ?? 0 }}
                    </span>
                </a>

                {{-- Take Out --}}
                <a href="{{ route('admin.orders.index', array_merge(request()->except('type', 'page'), ['type' => 'take_out'])) }}"
                   class="flex items-center gap-2 px-5 py-2.5 rounded-xl font-bold text-sm
                          transition-all whitespace-nowrap
                          @if(request('type') === 'take_out')
                              bg-gradient-to-r from-orange-600 to-orange-700 text-white shadow-lg shadow-orange-900/40
                          @else
                              bg-black/40 text-amber-200/70 hover:bg-orange-900/30 hover:text-amber-100
                              border border-orange-800/30
                          @endif">
                    <span>🥡</span>
                    <span>Take Out</span>
                    <span class="px-2 py-0.5 rounded-full text-[10px] font-black
                                 @if(request('type') === 'take_out') bg-white/20 @else bg-orange-900/40 @endif">
                        {{ $typeCounts['take_out'] ?? 0 }}
                    </span>
                </a>

                {{-- Delivery --}}
                <a href="{{ route('admin.orders.index', array_merge(request()->except('type', 'page'), ['type' => 'delivery'])) }}"
                   class="flex items-center gap-2 px-5 py-2.5 rounded-xl font-bold text-sm
                          transition-all whitespace-nowrap
                          @if(request('type') === 'delivery')
                              bg-gradient-to-r from-red-600 to-red-700 text-white shadow-lg shadow-red-900/40
                          @else
                              bg-black/40 text-amber-200/70 hover:bg-red-900/30 hover:text-amber-100
                              border border-red-800/30
                          @endif">
                    <span>🛵</span>
                    <span>Delivery</span>
                    <span class="px-2 py-0.5 rounded-full text-[10px] font-black
                                 @if(request('type') === 'delivery') bg-white/20 @else bg-red-900/40 @endif">
                        {{ $typeCounts['delivery'] ?? 0 }}
                    </span>
                </a>

                {{-- Search --}}
                <form method="GET" action="{{ route('admin.orders.index') }}"
                      class="flex items-center gap-2 ml-auto">
                    @if(request('type'))
                        <input type="hidden" name="type" value="{{ request('type') }}">
                    @endif

                    <div class="relative">
                        <input type="text" name="search"
                               value="{{ request('search') }}"
                               placeholder="Search..."
                               class="w-48 px-4 py-2.5 pl-10 rounded-xl bg-black/40
                                      border border-red-800/30 text-amber-100 text-sm
                                      placeholder-amber-200/30
                                      focus:outline-none focus:border-amber-400 transition">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-amber-200/40">
                            🔍
                        </span>
                    </div>

                    @if(request('search') || request('type') || request('date'))
                        <a href="{{ route('admin.orders.index') }}"
                           class="px-3 py-2.5 rounded-xl bg-red-500/20 hover:bg-red-500/30
                                  border border-red-500/40 text-red-300 text-sm font-bold
                                  transition-all whitespace-nowrap">
                            ✕ Clear
                        </a>
                    @endif
                </form>
            </div>
        </div>

        {{-- ============ Orders Table ============ --}}
        @php
            $headers = ['#', 'Type', 'Table / Address', 'User', 'Total', 'Date', 'Actions'];

            // SVG Icons
            $eyeSvg = '<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>';
            $editSvg = '<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/><path d="m15 5 4 4"/></svg>';
            $trashSvg = '<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>';

            $rows = $orders->map(function ($order) use ($eyeSvg, $editSvg, $trashSvg) {
                // Type badge
                $typeBadge = match($order->type) {
                    'dine_in'  => '<span class="px-2 py-1 rounded-md text-xs font-bold bg-amber-500/20 text-amber-300 border border-amber-500/40">🍽️ Dine In</span>',
                    'delivery' => '<span class="px-2 py-1 rounded-md text-xs font-bold bg-red-500/20 text-red-300 border border-red-500/40">🛵 Delivery</span>',
                    default    => '<span class="px-2 py-1 rounded-md text-xs font-bold bg-orange-500/20 text-orange-300 border border-orange-500/40">🥡 Take Out</span>',
                };

                // Location
                if ($order->table_no) {
                    $location = '<span class="text-amber-100">Table ' . e($order->table_no) . '</span>';
                } elseif ($order->address) {
                    $location = '<span class="text-amber-100">' . e($order->address) . '</span>';
                } else {
                    $location = '<span class="text-amber-200/40">—</span>';
                }

                // Actions (SVG مباشر — نفس طريقة cashier)
                $actions = '
                    <div class="flex items-center justify-center gap-2">
                        <a href="' . route('admin.orders.show', $order->id) . '"
                           title="View"
                           class="p-2 rounded-lg border border-amber-400/40 bg-amber-500/10
                                  text-amber-300 hover:bg-amber-500/20 hover:border-amber-400/70
                                  transition-all">
                            ' . $eyeSvg . '
                        </a>
                        <a href="' . route('admin.orders.edit', $order->id) . '"
                           title="Edit"
                           class="p-2 rounded-lg border border-blue-400/40 bg-blue-500/10
                                  text-blue-300 hover:bg-blue-500/20 hover:border-blue-400/70
                                  transition-all">
                            ' . $editSvg . '
                        </a>
                        <form action="' . route('admin.orders.destroy', $order->id) . '"
                              method="POST"
                              onsubmit="return confirm(\'Are you sure?\');"
                              class="inline">
                            ' . csrf_field() . method_field('DELETE') . '
                            <button type="submit"
                                    title="Delete"
                                    class="p-2 rounded-lg border border-red-400/40 bg-red-500/10
                                           text-red-300 hover:bg-red-500/20 hover:border-red-400/70
                                           transition-all">
                                ' . $trashSvg . '
                            </button>
                        </form>
                    </div>
                ';

                return [
                    '<span class="text-amber-400 font-black">#' . $order->id . '</span>',
                    $typeBadge,
                    $location,
                    '<span class="text-amber-200/80">' . e($order->user->name ?? '—') . '</span>',
                    '<span class="text-amber-400 font-black">' . number_format($order->total_amount, 2) . ' SYP</span>',
                    '<span class="text-amber-200/60 text-xs">' . ($order->created_at?->format('Y-m-d H:i') ?? '—') . '</span>',
                    $actions,
                ];
            })->toArray();
        @endphp

        <x-table
            :headers="$headers"
            :rows="$rows"
            emptyMessage="{{ request('type') || request('search') ? 'No orders match your filters' : 'No orders to display' }}"
        >
            <x-slot:footer>
                <x-pagination :paginator="$orders" />
            </x-slot:footer>
        </x-table>

    </div>

</x-layouts.admin>