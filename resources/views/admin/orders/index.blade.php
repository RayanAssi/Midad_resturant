<x-layouts.admin title="Orders Management">

    <div class="space-y-6">

        <div class="flex items-center justify-between flex-wrap gap-4">
            <div>
                <h1
                    class="text-3xl font-black text-transparent bg-clip-text
                           bg-gradient-to-r from-amber-300 via-orange-400 to-red-500">
                    Orders Management
                </h1>
                <p class="text-amber-200/60 text-sm mt-1">
                    View and manage all restaurant orders
                </p>
            </div>

            <a href="{{ route('orders.create') }}"
                class="inline-flex items-center gap-2 px-6 py-3 rounded-xl
                      bg-gradient-to-r from-red-600 to-red-800
                      hover:from-red-500 hover:to-red-700
                      text-amber-50 font-bold shadow-lg shadow-red-900/50
                      transition-all hover:scale-105 active:scale-95">
                <span class="text-lg">+</span>
                New Order
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        </div>

        <div
            class="overflow-hidden rounded-2xl 
                    bg-gradient-to-br from-gray-900 via-gray-800 to-black
                    border-2 border-red-800/30 shadow-2xl shadow-red-900/20">

            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr
                            class="bg-gradient-to-r from-red-900/60 via-red-800/40 to-transparent
                                   border-b-2 border-red-700/50">
                            <th class="px-6 py-4 text-sm font-bold text-amber-100">#</th>
                            <th class="px-6 py-4 text-sm font-bold text-amber-100">Type</th>
                            <th class="px-6 py-4 text-sm font-bold text-amber-100">Table / Address</th>
                            <th class="px-6 py-4 text-sm font-bold text-amber-100">User</th>
                            <th class="px-6 py-4 text-sm font-bold text-amber-100">Total</th>
                            <th class="px-6 py-4 text-sm font-bold text-amber-100">Date</th>
                            <th class="px-6 py-4 text-sm font-bold text-amber-100">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-red-900/30">
                        @forelse($orders as $order)
                            <tr class="hover:bg-red-900/20 transition">
                                <td class="px-6 py-4 text-amber-400 font-black">#{{ $order->id }}</td>

                                <td class="px-6 py-4">
                                    <span
                                        class="px-3 py-1 rounded-full text-xs font-bold border
                                        @if ($order->type === 'dine_in') bg-amber-500/20 text-amber-300 border-amber-500/40
                                        @elseif($order->type === 'delivery') bg-red-500/20 text-red-300 border-red-500/40
                                        @else bg-orange-500/20 text-orange-300 border-orange-500/40 @endif">
                                        @if ($order->type === 'dine_in')
                                            Dine In
                                        @elseif($order->type === 'delivery')
                                            Delivery
                                        @else
                                            Take Out
                                        @endif
                                    </span>
                                </td>

                                <td class="px-6 py-4 text-amber-100">
                                    {{ $order->table_no ? 'Table ' . $order->table_no : $order->address ?? '-' }}
                                </td>

                                <td class="px-6 py-4 text-amber-200/80">{{ $order->user->name ?? '-' }}</td>

                                <td class="px-6 py-4 text-amber-400 font-black">
                                    {{ number_format($order->total_amount, 2) }} SYP
                                </td>

                                <td class="px-6 py-4 text-amber-200/60 text-xs">
                                    {{ $order->created_at->format('Y-m-d H:i') }}
                                </td>

                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('orders.show', $order->id) }}"
                                            class="w-8 h-8 rounded-lg bg-amber-500/20 hover:bg-amber-500/30
                                                  border border-amber-500/40 text-amber-300
                                                  flex items-center justify-center transition-all">👁</a>
                                        <a href="{{ route('orders.edit', $order->id) }}"
                                            class="w-8 h-8 rounded-lg bg-orange-500/20 hover:bg-orange-500/30
                                                  border border-orange-500/40 text-orange-300
                                                  flex items-center justify-center transition-all">✏️</a>
                                        <form action="{{ route('orders.destroy', $order->id) }}" method="POST"
                                            class="inline" onsubmit="return confirm('Are you sure?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="w-8 h-8 rounded-lg bg-red-500/20 hover:bg-red-500/30
                                                           border border-red-500/40 text-red-300
                                                           flex items-center justify-center transition-all">🗑</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center text-amber-200/60">
                                    No orders to display
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <x-pagination :paginator="$orders" />

    </div>

</x-layouts.admin>