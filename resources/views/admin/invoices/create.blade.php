<x-layouts.admin title="Create Invoice">
    <div class="max-w-5xl mx-auto space-y-6">

        {{-- ============ Progress Steps ============ --}}
        <div class="flex items-center justify-center gap-4">
            <div class="flex items-center gap-2 opacity-50">
                <div class="w-8 h-8 rounded-full bg-gray-700 text-amber-200 font-black
                            flex items-center justify-center">
                    ✓
                </div>
                <span class="text-amber-200/60 font-bold">Order Details</span>
            </div>
            <div class="w-16 h-0.5 bg-amber-500/30"></div>
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-full bg-amber-500 text-white font-black
                            flex items-center justify-center shadow-lg shadow-amber-900/50">
                    2
                </div>
                <span class="text-amber-100 font-bold">Create Invoice</span>
            </div>
        </div>

        {{-- ============ Order Info Card ============ --}}
        <div class="rounded-2xl bg-gradient-to-br from-gray-900 via-gray-800 to-black
                    border-2 border-red-800/30 shadow-2xl overflow-hidden">

            <div class="px-6 py-5 bg-gradient-to-r from-red-900/60 to-transparent
                        border-b-2 border-red-800/50 flex items-center justify-between flex-wrap gap-3">
                <div>
                    <h2 class="text-2xl font-black text-amber-100">Create Invoice</h2>
                    <p class="text-amber-200/60 text-sm mt-1">
                        Order #{{ $order->id }} — {{ $order->user->name ?? '—' }}
                    </p>
                </div>

                @php
                    $badgeClass = match($order->type) {
                        'dine_in'  => 'bg-amber-500/20 text-amber-300 border-amber-500/40',
                        'delivery' => 'bg-red-500/20 text-red-300 border-red-500/40',
                        default    => 'bg-orange-500/20 text-orange-300 border-orange-500/40',
                    };
                    $badgeIcon = match($order->type) {
                        'dine_in'  => '🍽️',
                        'delivery' => '🛵',
                        default    => '🥡',
                    };
                    $badgeText = match($order->type) {
                        'dine_in'  => 'Dine In' . ($order->table_no ? ' — Table ' . $order->table_no : ''),
                        'delivery' => 'Delivery' . ($order->address ? ' — ' . $order->address : ''),
                        default    => 'Take Out',
                    };
                @endphp

                <span class="px-4 py-2 rounded-full text-sm font-bold border {{ $badgeClass }}">
                    {{ $badgeIcon }} {{ $badgeText }}
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-gradient-to-r from-red-900/60 to-transparent
                                   border-b-2 border-red-700/50">
                            <th class="px-6 py-4 text-sm font-bold text-amber-100">Item</th>
                            <th class="px-6 py-4 text-sm font-bold text-amber-100 text-center">Qty</th>
                            <th class="px-6 py-4 text-sm font-bold text-amber-100 text-right">Price</th>
                            <th class="px-6 py-4 text-sm font-bold text-amber-100 text-right">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-red-900/30">
                        @forelse($order->orderItems as $item)
                            <tr class="hover:bg-red-900/20 transition">
                                <td class="px-6 py-4 text-amber-100 font-bold">
                                    {{ $item->menuItem->name ?? 'Deleted item' }}
                                </td>
                                <td class="px-6 py-4 text-amber-100 text-center">× {{ $item->quantity }}</td>
                                <td class="px-6 py-4 text-amber-300 text-right">
                                    {{ number_format($item->price, 2) }}
                                </td>
                                <td class="px-6 py-4 text-amber-400 font-black text-right">
                                    {{ number_format($item->subtotal, 2) }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center text-amber-200/60">
                                    No items in this order
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot class="border-t-2 border-red-800/40 bg-black/30">
                        <tr>
                            <td colspan="3" class="px-6 py-4 text-right text-amber-100 font-bold">
                                Subtotal:
                            </td>
                            <td class="px-6 py-4 text-right text-amber-400 font-black text-lg">
                                {{ number_format($subtotal, 2) }} SYP
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        {{-- ============ Invoice Form ============ --}}
        <div class="rounded-2xl bg-gradient-to-br from-gray-900 via-gray-800 to-black
                    border-2 border-amber-500/40 shadow-2xl overflow-hidden">

            <div class="px-6 py-5 bg-gradient-to-r from-amber-900/60 to-transparent
                        border-b-2 border-amber-700/50">
                <h2 class="text-2xl font-black text-amber-100 flex items-center gap-2">
                    <span>💰</span> Invoice Details
                </h2>
                <p class="text-amber-200/60 text-sm mt-1">Customize the invoice before saving</p>
            </div>

            <div class="p-6">
                <form action="{{ route('admin.invoices.store') }}" method="POST" id="invoice-form" class="space-y-6">
                    @csrf

                    <input type="hidden" name="order_id" value="{{ $order->id }}">
                    <input type="hidden" name="subtotal" value="{{ $subtotal }}">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        <x-form.input
                            name="discount_amount"
                            type="number"
                            label="Discount Amount"
                            placeholder="0.00"
                            :value="old('discount_amount', 0)"
                        />

                        <x-form.input
                            name="tax_rate"
                            type="number"
                            label="Tax Rate (%)"
                            placeholder="15"
                            :value="old('tax_rate', $taxRate)"
                        />
                    </div>

                    <x-form.input
                        name="notes"
                        label="Notes"
                        placeholder="Any additional notes..."
                        :value="old('notes')"
                    />

                    {{-- Live Summary --}}
                    <div class="p-5 rounded-2xl bg-gradient-to-br from-gray-900 via-gray-800 to-black
                                border-2 border-green-500/40 shadow-lg shadow-green-900/20">
                        <h3 class="text-lg font-black text-amber-100 mb-4 flex items-center gap-2">
                            <span>📋</span>
                            Invoice Summary
                        </h3>

                        <div class="space-y-3">
                            <div class="flex justify-between text-amber-100">
                                <span class="font-bold">Subtotal:</span>
                                <span class="font-black text-amber-400" id="sum-subtotal">0.00 SYP</span>
                            </div>
                            <div class="flex justify-between text-amber-100">
                                <span class="font-bold">Discount:</span>
                                <span class="font-black text-red-400" id="sum-discount">-0.00 SYP</span>
                            </div>
                            <div class="flex justify-between text-amber-100">
                                <span class="font-bold">Tax (<span id="sum-tax-rate">{{ $taxRate }}</span>%):</span>
                                <span class="font-black text-orange-300" id="sum-tax">0.00 SYP</span>
                            </div>
                            <div class="flex justify-between border-t-2 border-green-500/30 pt-3">
                                <span class="font-black text-amber-100 text-lg">Total:</span>
                                <span class="font-black text-green-400 text-2xl" id="sum-total">0.00 SYP</span>
                            </div>
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="flex gap-3 pt-2">
                        <button type="submit"
                                class="flex-1 px-6 py-3 rounded-xl
                                       bg-gradient-to-r from-green-600 to-green-800
                                       hover:from-green-500 hover:to-green-700
                                       text-white font-black shadow-lg shadow-green-900/50
                                       transition-all hover:scale-105 active:scale-95">
                            ✓ Create Invoice
                        </button>

                        <a href="{{ route('admin.orders.show', $order->id) }}"
                           class="px-6 py-3 rounded-xl bg-gray-700/50 hover:bg-gray-600/50
                                  text-amber-100 font-bold transition-all border border-gray-600/50">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const subtotal   = {{ (float) $subtotal }};
            const discountEl = document.querySelector('[name="discount_amount"]');
            const taxRateEl  = document.querySelector('[name="tax_rate"]');

            function updateSummary() {
                const discount = parseFloat(discountEl.value) || 0;
                const taxRate  = parseFloat(taxRateEl.value) || 0;

                const taxable = subtotal - discount;
                const tax     = taxable * (taxRate / 100);
                const total   = taxable + tax;

                document.getElementById('sum-subtotal').textContent  = subtotal.toFixed(2) + ' SYP';
                document.getElementById('sum-discount').textContent  = '-' + discount.toFixed(2) + ' SYP';
                document.getElementById('sum-tax-rate').textContent  = taxRate;
                document.getElementById('sum-tax').textContent       = tax.toFixed(2) + ' SYP';
                document.getElementById('sum-total').textContent     = total.toFixed(2) + ' SYP';
            }

            if (discountEl) discountEl.addEventListener('input', updateSummary);
            if (taxRateEl)  taxRateEl.addEventListener('input', updateSummary);

            updateSummary();
        });
    </script>
</x-layouts.admin>