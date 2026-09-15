<x-layouts.app :title="$item->name">

    <a href="{{ route('admin.menu-items.index') }}"
       class="inline-flex items-center gap-2 text-amber-300/70 
              hover:text-amber-200 mb-6 transition-colors">
        ← Back to list
    </a>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <div class="lg:col-span-1">
            <x-menu-item-card :item="$item" />
        </div>

        <div class="lg:col-span-2 space-y-6">

            {{-- Stats --}}
            <div class="rounded-2xl bg-gradient-to-br from-amber-950 via-amber-900 to-black
                        border-2 border-amber-700/50 shadow-2xl shadow-red-900/20 overflow-hidden">

                <div class="px-6 py-4 bg-gradient-to-r from-amber-900/40 to-transparent
                            border-b-2 border-amber-800/40">
                    <h3 class="text-lg font-bold text-amber-100">Statistics</h3>
                </div>

                <div class="p-6 grid grid-cols-2 gap-4">
                    <div class="text-center p-4 rounded-xl bg-black/30 border border-amber-700/30">
                        <p class="text-3xl font-black text-amber-300">
                            {{ $item->orders_count }}
                        </p>
                        <p class="text-xs text-amber-200/60 mt-1">Times Ordered</p>
                    </div>

                    <div class="text-center p-4 rounded-xl bg-black/30 border border-red-700/30">
                        <p class="text-3xl font-black text-transparent bg-clip-text 
                                   bg-gradient-to-r from-amber-300 to-orange-400">
                            {{ number_format($item->price, 2) }}
                        </p>
                        <p class="text-xs text-amber-200/60 mt-1">Price (SYP)</p>
                    </div>
                </div>
            </div>

            {{-- Recent Orders --}}
            <div class="rounded-2xl bg-gradient-to-br from-gray-900 via-gray-800 to-black
                        border-2 border-red-800/30 shadow-2xl shadow-red-900/20 overflow-hidden">

                <div class="px-6 py-4 bg-gradient-to-r from-red-900/40 to-transparent
                            border-b-2 border-red-800/40">
                    <h3 class="text-lg font-bold text-amber-100">Recent Orders</h3>
                </div>

                @if($recentOrders->count() > 0)
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-gradient-to-r from-red-900/60 via-red-800/40 to-transparent
                                       border-b-2 border-red-700/50">
                                <th class="px-6 py-3 text-sm font-bold text-amber-100 uppercase tracking-wider">Order</th>
                                <th class="px-6 py-3 text-sm font-bold text-amber-100 uppercase tracking-wider">Qty</th>
                                <th class="px-6 py-3 text-sm font-bold text-amber-100 uppercase tracking-wider">Subtotal</th>
                                <th class="px-6 py-3 text-sm font-bold text-amber-100 uppercase tracking-wider">Date</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-red-900/30">
                            @foreach($recentOrders as $order)
                                <tr class="hover:bg-red-900/20 transition-colors">
                                    <td class="px-6 py-3 text-amber-300 font-bold">#{{ $order->id }}</td>
                                    <td class="px-6 py-3 text-amber-50">{{ $order->pivot->quantity }}</td>
                                    <td class="px-6 py-3 text-amber-50">{{ number_format($order->pivot->subtotal, 2) }} SYP</td>
                                    <td class="px-6 py-3 text-amber-200/60 text-sm">{{ $order->created_at->format('Y-m-d H:i') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="p-12 text-center text-amber-200/50 text-sm">
                        No orders for this item yet.
                    </div>
                @endif
            </div>

        </div>
    </div>

</x-layouts.app>