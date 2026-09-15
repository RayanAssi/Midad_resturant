<x-layouts.app title="تفاصيل الطلب #{{ $order->id }}">
    <div class="max-w-4xl mx-auto space-y-6">

        <x-card title="تفاصيل الطلب #{{ $order->id }}">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-xs text-amber-200/60">النوع</p>
                    <p class="text-amber-100 font-bold">{{ $order->type }}</p>
                </div>
                <div>
                    <p class="text-xs text-amber-200/60">الطاولة/العنوان</p>
                    <p class="text-amber-100 font-bold">
                        {{ $order->table_no ?? $order->address ?? '-' }}
                    </p>
                </div>
                <div>
                    <p class="text-xs text-amber-200/60">المجموع</p>
                    <p class="text-amber-400 font-black text-2xl">
                        {{ number_format($order->total_amount, 2) }} SYP
                    </p>
                </div>
                <div>
                    <p class="text-xs text-amber-200/60">التاريخ</p>
                    <p class="text-amber-100">{{ $order->created_at->format('Y-m-d H:i') }}</p>
                </div>
            </div>
        </x-card>

        <x-card title="أصناف الطلب">
            <x-table
                :headers="['الصنف', 'السعر', 'الكمية', 'المجموع']"
                :rows="$order->orderItems->map(fn($item) => [
                    '<span class=\'text-amber-100\'>' . $item->menuItem->name . '</span>',
                    '<span class=\'text-amber-300\'>' . number_format($item->menuItem->price, 2) . '</span>',
                    '<span class=\'text-amber-100\'>' . $item->quantity . '</span>',
                    '<span class=\'text-amber-400 font-bold\'>'
                        . number_format($item->menuItem->price * $item->quantity, 2) . '</span>',
                ])->toArray()"
            />
        </x-card>

        <div class="flex gap-3">
            <x-button href="{{ route('orders.index') }}" variant="secondary">
                رجوع
            </x-button>
            <x-button href="{{ route('orders.edit', $order->id) }}" variant="gold">
                تعديل
            </x-button>
        </div>

    </div>
</x-layouts.app>