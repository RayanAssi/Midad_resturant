<x-layouts.employee title="Orders">

    <div class="flex items-center justify-between mb-6">
        <h1
            class="text-3xl font-black text-transparent bg-clip-text
                   bg-gradient-to-r from-amber-300 to-orange-400">
            Orders
        </h1>

        <a href="{{ route('employee.orders.create') }}"
            class="px-5 py-2.5 rounded-lg bg-gradient-to-r from-red-600 to-red-800
                  hover:from-red-500 hover:to-red-700 text-amber-50 font-bold
                  shadow-lg shadow-red-900/50 transition-all">
            + New Order
        </a>
    </div>

    @php
        $headers = ['#', 'Type', 'Table / Address', 'Notes', 'Total', 'Date', 'Actions'];

        $typeLabels = [
            'dine_in' => 'Dine In',
            'take_out' => 'Take Out',
            'delivery' => 'Delivery',
        ];

        // قالب الأزرار
        $actionsTemplate = <<<'BLADE'
            <div class="flex items-center justify-center gap-2">
                <a href="{{ route('employee.orders.show', $order) }}"
                   title="View"
                   class="p-2 rounded-lg border border-amber-400/40 bg-amber-500/10
                          text-amber-300 hover:bg-amber-500/20 hover:border-amber-400/70
                          transition-all">
                    <x-lucide-eye class="w-4 h-4" />
                </a>

                <a href="{{ route('employee.orders.edit', $order) }}"
                   title="Edit"
                   class="p-2 rounded-lg border border-blue-400/40 bg-blue-500/10
                          text-blue-300 hover:bg-blue-500/20 hover:border-blue-400/70
                          transition-all">
                    <x-lucide-edit class="w-4 h-4" />
                </a>

                <form action="{{ route('employee.orders.destroy', $order) }}"
                      method="POST"
                      onsubmit="return confirm('هل أنت متأكد من حذف هذا الطلب؟');"
                      class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            title="Delete"
                            class="p-2 rounded-lg border border-red-400/40 bg-red-500/10
                                   text-red-300 hover:bg-red-500/20 hover:border-red-400/70
                                   transition-all">
                        <x-lucide-trash class="w-4 h-4" />
                    </button>
                </form>
            </div>
        BLADE;

        $rows = $orders
            ->map(function ($order) use ($typeLabels, $actionsTemplate) {
                $location = '—';
                if ($order->type === 'dine_in' && $order->table_no) {
                    $location = 'Table ' . $order->table_no;
                } elseif ($order->type === 'delivery' && $order->address) {
                    $location = $order->address;
                }

                $notes = $order->notes
                    ? '<span class="text-amber-200/70" title="' .
                        e($order->notes) .
                        '">' .
                        \Illuminate\Support\Str::limit($order->notes, 30) .
                        '</span>'
                    : '<span class="text-amber-200/30">—</span>';

                $actions = \Illuminate\Support\Facades\Blade::render($actionsTemplate, ['order' => $order]);

                return [
                    '<span class="text-amber-200/70">#' . $order->id . '</span>',
                    '<span class="px-2 py-1 rounded-md text-xs bg-red-800/40 text-amber-100">' .
                    ($typeLabels[$order->type] ?? $order->type) .
                    '</span>',
                    '<span class="text-amber-100">' . $location . '</span>',
                    $notes,
                    '<span class="font-bold text-amber-100">' . number_format($order->total_amount, 2) . ' SYP</span>',
                    '<span class="text-amber-200/60">' . $order->created_at->format('Y-m-d H:i') . '</span>',
                    $actions,
                ];
            })
            ->toArray();
    @endphp

    <x-table :headers="$headers" :rows="$rows" emptyMessage="لا توجد طلبات بعد">
        <x-slot:footer>
            <x-pagination :paginator="$orders" />
        </x-slot:footer>
    </x-table>

</x-layouts.employee>