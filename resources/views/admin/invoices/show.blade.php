<x-layouts.admin title="فاتورة {{ $invoice->invoice_number }}">

    <div class="max-w-3xl mx-auto">

        <div class="flex items-center justify-between mb-6">
            <h1 class="text-3xl font-black text-transparent bg-clip-text
                       bg-gradient-to-r from-amber-300 to-orange-400">
                فاتورة {{ $invoice->invoice_number }}
            </h1>

            <div class="flex gap-2">
                <a href="{{ route('admin.invoices.index') }}"
                   class="px-4 py-2 rounded-lg bg-black/40 border border-amber-500/30
                          text-amber-200 hover:border-amber-400/60 transition-all">
                    ← رجوع
                </a>
                <button onclick="window.print()"
                        class="px-4 py-2 rounded-lg bg-gradient-to-r from-amber-500 to-amber-700
                               text-white font-bold">
                    🖨️ طباعة
                </button>
            </div>
        </div>

        <div class="bg-black/40 border border-amber-500/20 rounded-xl p-8 space-y-6">

            <div class="grid grid-cols-2 gap-4 text-sm">
                <div>
                    <span class="text-amber-200/60">رقم الفاتورة: </span>
                    <span class="text-amber-100 font-bold">{{ $invoice->invoice_number }}</span>
                </div>
                <div>
                    <span class="text-amber-200/60">التاريخ: </span>
                    <span class="text-amber-100">{{ $invoice->created_at->format('Y-m-d H:i') }}</span>
                </div>
                <div>
                    <span class="text-amber-200/60">الطلب: </span>
                    <span class="text-amber-100">{{ $invoice->order_id ? '#' . $invoice->order_id : '—' }}</span>
                </div>
                <div>
                    <span class="text-amber-200/60">الرقم الضريبي: </span>
                    <span class="text-amber-100">{{ $invoice->tax_number ?? '—' }}</span>
                </div>
                <div>
                    <span class="text-amber-200/60">الكاشير: </span>
                    <span class="text-amber-100">{{ $invoice->creator?->name ?? '—' }}</span>
                </div>
            </div>

            <div class="border-t border-amber-500/20"></div>

            <div class="space-y-3">
                <div class="flex justify-between text-amber-100">
                    <span>المجموع الفرعي</span>
                    <span>{{ number_format($invoice->subtotal, 2) }} {{ config('restaurant.currency') }}</span>
                </div>

                @if($invoice->discount_amount > 0)
                    <div class="flex justify-between text-red-300">
                        <span>الخصم</span>
                        <span>- {{ number_format($invoice->discount_amount, 2) }} {{ config('restaurant.currency') }}</span>
                    </div>
                @endif

                @if($invoice->tax_amount > 0)
                    <div class="flex justify-between text-blue-300">
                        <span>الضريبة ({{ $invoice->tax_rate }}%)</span>
                        <span>{{ number_format($invoice->tax_amount, 2) }} {{ config('restaurant.currency') }}</span>
                    </div>
                @endif

                <div class="flex justify-between text-xl font-black text-amber-300
                            border-t border-amber-500/30 pt-3">
                    <span>الإجمالي</span>
                    <span>{{ number_format($invoice->total_amount, 2) }} {{ config('restaurant.currency') }}</span>
                </div>
            </div>

            @if($invoice->notes)
                <div class="border-t border-amber-500/20 pt-4">
                    <span class="text-amber-200/60 text-sm">ملاحظات:</span>
                    <p class="text-amber-100 mt-1">{{ $invoice->notes }}</p>
                </div>
            @endif
        </div>

    </div>

</x-layouts.admin>