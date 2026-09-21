<x-layouts.employee title="Order #{{ $order->id }}">

    {{-- Header --}}
    <div class="flex items-start justify-between mb-6 flex-wrap gap-4">
        <div>
            <h1 class="text-3xl font-black text-transparent bg-clip-text
                       bg-gradient-to-r from-amber-300 to-orange-400">
                Order #{{ $order->id }}
            </h1>

            <p class="text-sm text-amber-200/50 mt-1">
                {{ $order->created_at?->format('Y-m-d H:i') ?? '—' }}
            </p>

            {{-- Table / Address Badge --}}
            <div class="flex items-center gap-2 mt-3 flex-wrap">
                @if($order->type === 'dine_in' && $order->table_no)
                    <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg
                                 bg-amber-500/20 border border-amber-500/40
                                 text-amber-300 text-sm font-bold">
                        🍽️ Table {{ $order->table_no }}
                    </span>
                @elseif($order->type === 'delivery' && $order->address)
                    <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg
                                 bg-red-500/20 border border-red-500/40
                                 text-red-300 text-sm font-bold max-w-md truncate">
                        🛵 {{ $order->address }}
                    </span>
                @elseif($order->type === 'take_out')
                    <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg
                                 bg-orange-500/20 border border-orange-500/40
                                 text-orange-300 text-sm font-bold">
                        🥡 Take Out
                    </span>
                @endif
            </div>
        </div>

        <a href="{{ route('employee.orders.index') }}"
           class="px-5 py-2.5 rounded-lg bg-black/40 border-2 border-red-800/40
                  text-amber-100 hover:border-red-600/60 transition-all">
            ← Back to Orders
        </a>
    </div>

    {{-- Order Info Card --}}
    <div class="rounded-2xl bg-gradient-to-br from-gray-900 via-gray-800 to-black
                border-2 border-red-800/30 shadow-2xl overflow-hidden mb-6">

        <div class="px-6 py-4 bg-gradient-to-r from-red-900/40 to-transparent
                    border-b-2 border-red-800/40">
            <h2 class="text-lg font-bold text-amber-100">Order Details</h2>
        </div>

        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-5">

            {{-- Type --}}
            <div>
                <p class="text-xs text-amber-300/60 uppercase tracking-wider mb-1">Type</p>
                <p class="text-amber-100 font-bold">
                    @switch($order->type)
                        @case('dine_in') 🍽️ Dine In @break
                        @case('take_out') 🥡 Take Out @break
                        @case('delivery') 🛵 Delivery @break
                    @endswitch
                </p>
            </div>

            {{-- Table / Address --}}
            @if ($order->type === 'dine_in')
                <div>
                    <p class="text-xs text-amber-300/60 uppercase tracking-wider mb-1">Table No.</p>
                    <p class="text-amber-100 font-bold">
                        {{ $order->table_no ? 'Table ' . $order->table_no : '—' }}
                    </p>
                </div>
            @elseif ($order->type === 'delivery')
                <div>
                    <p class="text-xs text-amber-300/60 uppercase tracking-wider mb-1">Address</p>
                    <p class="text-amber-100 font-bold">
                        {{ $order->address ?? '—' }}
                    </p>
                </div>
            @endif

            {{-- employee --}}
            <div>
                <p class="text-xs text-amber-300/60 uppercase tracking-wider mb-1">Employee</p>
                <p class="text-amber-100 font-bold">{{ $order->user->name ?? '—' }}</p>
            </div>

            {{-- Total --}}
            <div>
                <p class="text-xs text-amber-300/60 uppercase tracking-wider mb-1">Total</p>
                <p class="text-amber-100 font-black text-xl">
                    {{ number_format($order->total_amount ?? 0, 2) }} SYP
                </p>
            </div>

            {{-- Notes --}}
            @if ($order->notes)
                <div class="md:col-span-2">
                    <p class="text-xs text-amber-300/60 uppercase tracking-wider mb-1">Notes</p>
                    <p class="text-amber-100 bg-black/30 rounded-lg p-3 border border-red-900/30">
                        {{ $order->notes }}
                    </p>
                </div>
            @endif
        </div>
    </div>

    {{-- Items Section --}}
    <div class="rounded-2xl bg-gradient-to-br from-gray-900 via-gray-800 to-black
                border-2 border-red-800/30 shadow-2xl overflow-hidden">

        <div class="px-6 py-4 bg-gradient-to-r from-red-900/40 to-transparent
                    border-b-2 border-red-800/40 flex items-center justify-between">
            <h2 class="text-lg font-bold text-amber-100">Items</h2>
            <span class="text-sm text-amber-200/60">
                {{ $order->orderItems->count() }}
                {{ $order->orderItems->count() === 1 ? 'item' : 'items' }}
            </span>
        </div>

        @if ($order->orderItems->isEmpty())
            <div class="p-12 text-center">
                <p class="text-amber-200/50">No items in this order.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gradient-to-r from-red-900/60 via-red-800/40 to-transparent
                                   border-b-2 border-red-700/50">
                            <th class="px-6 py-4 text-sm font-bold text-amber-100 tracking-wider uppercase text-left">
                                Item
                            </th>
                            <th class="px-6 py-4 text-sm font-bold text-amber-100 tracking-wider uppercase text-center">
                                Qty
                            </th>
                            <th class="px-6 py-4 text-sm font-bold text-amber-100 tracking-wider uppercase text-center">
                                Price
                            </th>
                            <th class="px-6 py-4 text-sm font-bold text-amber-100 tracking-wider uppercase text-center">
                                Subtotal
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-red-900/30">
                        @foreach ($order->orderItems as $item)
                            <tr class="hover:bg-gradient-to-r hover:from-red-900/30 hover:to-transparent
                                       transition-all duration-200">

                                {{-- Item --}}
                                <td class="px-6 py-4 text-sm text-amber-50">
                                    <div class="flex items-center gap-3">
                                        @if ($item->menuItem && $item->menuItem->image_url)
                                            <img src="{{ $item->menuItem->image_url }}"
                                                 alt="{{ $item->menuItem->name }}"
                                                 class="w-10 h-10 rounded-lg object-cover border border-red-800/40" />
                                        @endif
                                        <span class="font-medium">
                                            {{ $item->menuItem->name ?? 'Deleted item' }}
                                        </span>
                                    </div>
                                </td>

                                {{-- Qty --}}
                                <td class="px-6 py-4 text-sm text-amber-100 text-center font-bold">
                                    × {{ $item->quantity }}
                                </td>

                                {{-- Price --}}
                                <td class="px-6 py-4 text-sm text-amber-200/70 text-center">
                                    {{ number_format($item->price ?? 0, 2) }} SYP
                                </td>

                                {{-- Subtotal --}}
                                <td class="px-6 py-4 text-sm text-amber-100 text-center font-bold">
                                    {{ number_format($item->subtotal ?? 0, 2) }} SYP
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                    {{-- Total --}}
                    <tfoot>
                        <tr class="border-t-2 border-red-800/40 bg-gradient-to-r from-transparent to-red-900/20">
                            <td colspan="3" class="px-6 py-4 text-right font-bold text-amber-200/80">
                                Total
                            </td>
                            <td class="px-6 py-4 text-center font-black text-amber-100 text-lg">
                                {{ number_format($order->orderItems->sum('subtotal') ?? 0, 2) }} SYP
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        @endif
    </div>

</x-layouts.employee>