<x-layouts.cashier title="Orders">

    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-black text-transparent bg-clip-text
                   bg-gradient-to-r from-amber-300 to-orange-400">
            Orders
        </h1>

        <a href="{{ route('cashier.orders.create') }}"
           class="px-5 py-2.5 rounded-lg bg-gradient-to-r from-red-600 to-red-800
                  hover:from-red-500 hover:to-red-700 text-amber-50 font-bold
                  shadow-lg shadow-red-900/50 transition-all">
            + New Order
        </a>
    </div>

    @php
        $headers = ['#', 'Type', 'Table / Address', 'Notes', 'Total', 'Date', 'Actions'];

        $typeLabels = [
            'dine_in'  => '🍽️ Dine In',
            'take_out' => '🥡 Take Out',
            'delivery' => '🛵 Delivery',
        ];

        // قالب الأزرار
        $actionsTemplate = '
            <div class="flex items-center gap-2">
                <a href="{{ route(\'cashier.orders.show\', $order) }}"
                   title="View"
                   class="p-1.5 rounded-md text-amber-300/70 hover:text-amber-200
                          hover:bg-amber-500/10 transition-colors">
                    <x-lucide-eye class="w-5 h-5" />
                </a>

                <a href="{{ route(\'cashier.orders.edit\', $order) }}"
                   title="Edit"
                   class="p-1.5 rounded-md text-blue-300/70 hover:text-blue-200
                          hover:bg-blue-500/10 transition-colors">
                    <x-lucide-pencil class="w-5 h-5" />
                </a>

                <form action="{{ route(\'cashier.orders.destroy\', $order) }}"
                      method="POST"
                      onsubmit="return confirm(\'هل أنت متأكد من حذف هذا الطلب؟\');"
                      class="inline">
                    @csrf
                    @method(\'DELETE\')
                    <button type="submit"
                            title="Delete"
                            class="p-1.5 rounded-md text-red-400/70 hover:text-red-300
                                   hover:bg-red-500/10 transition-colors">
                        <x-lucide-trash-2 class="w-5 h-5" />
                    </button>
                </form>
            </div>
        ';

        $rows = $orders->map(function ($order) use ($typeLabels, $actionsTemplate) {
            $location = '—';
            if ($order->type === 'dine_in' && $order->table_no) {
                $location = 'Table ' . $order->table_no;
            } elseif ($order->type === 'delivery' && $order->address) {
                $location = $order->address;
            }

            $notes = $order->notes
                ? '<span class="text-amber-200/70" title="' . e($order->notes) . '">'
                    . \Illuminate\Support\Str::limit($order->notes, 30)
                    . '</span>'
                : '<span class="text-amber-200/30">—</span>';

            // ✅ المسار الكامل بدل use
            $actions = \Illuminate\Support\Facades\Blade::render($actionsTemplate, ['order' => $order]);

            return [
                '<span class="text-amber-200/70">#' . $order->id . '</span>',
                '<span class="px-2 py-1 rounded-md text-xs bg-red-800/40 text-amber-100">'
                    . ($typeLabels[$order->type] ?? $order->type) . '</span>',
                '<span class="text-amber-100">' . $location . '</span>',
                $notes,
                '<span class="font-bold text-amber-100">'
                    . number_format($order->total_amount, 2) . ' SYP</span>',
                '<span class="text-amber-200/60">'
                    . $order->created_at->format('Y-m-d H:i') . '</span>',
                $actions,
            ];
        })->toArray();
    @endphp

    <x-table :headers="$headers" :rows="$rows" emptyMessage="لا توجد طلبات بعد">
        <x-slot:footer>
            <x-pagination :paginator="$orders" />
        </x-slot:footer>
    </x-table>

</x-layouts.cashier>