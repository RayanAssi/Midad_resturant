<x-layouts.cashier title="Invoice {{ $invoice->invoice_number }}">

    <style>
        @media print {
            /* إخفاء كل شي */
            body * {
                visibility: hidden;
            }

            /* إظهار الفاتورة بس */
            #printable-invoice,
            #printable-invoice * {
                visibility: visible;
            }

            /* تثبيت الفاتورة بأعلى الصفحة */
            #printable-invoice {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                padding: 20px;
            }

            /* إخفاء الأزرار */
            .no-print {
                display: none !important;
            }

            /* خلفية بيضاء للطباعة */
            body {
                background: white !important;
            }

            #printable-invoice {
                background: white !important;
                color: #000 !important;
                border: 1px solid #ddd !important;
            }

            #printable-invoice * {
                color: #000 !important;
                background: transparent !important;
                border-color: #ddd !important;
            }
        }
    </style>

    <div class="max-w-3xl mx-auto">

        {{-- ═══ Header ═══ --}}
        <div class="flex items-center justify-between mb-6 no-print">
            <div>
                <h1 class="text-3xl font-black text-transparent bg-clip-text
                           bg-gradient-to-r from-amber-300 to-orange-400">
                    Invoice
                </h1>
                <p class="text-amber-200/60 text-sm mt-1">
                    {{ $invoice->invoice_number }}
                </p>
            </div>

            <div class="flex gap-2">
                {{-- ✅ بدّل الـ route للكاشير --}}
                <a href="{{ route('cashier.orders.index') }}"
                   class="px-4 py-2 rounded-lg bg-black/40 border border-amber-500/30
                          text-amber-200 hover:border-amber-400/60 hover:bg-amber-500/10
                          transition-all flex items-center gap-2">
                    ← Back to Orders
                </a>
                <button onclick="window.print()"
                        class="px-5 py-2 rounded-lg bg-gradient-to-r from-amber-500 to-amber-700
                               hover:from-amber-400 hover:to-amber-600
                               text-white font-bold shadow-lg shadow-amber-900/50
                               transition-all flex items-center gap-2">
                    <x-lucide-printer class="w-4 h-4" />
                    Print
                </button>
            </div>
        </div>

        {{-- ═══ الفاتورة (الجزء القابل للطباعة) ═══ --}}
        <div id="printable-invoice"
             class="bg-gradient-to-br from-gray-900 via-gray-800 to-black
                    border-2 border-amber-500/30 rounded-2xl overflow-hidden
                    shadow-2xl shadow-amber-900/20">

            {{-- Header الفاتورة --}}
            <div class="px-8 py-6 bg-gradient-to-r from-amber-900/40 via-amber-800/20 to-transparent
                        border-b-2 border-amber-500/30">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-2xl font-black text-amber-100">INVOICE</h2>
                        <p class="text-amber-200/60 text-sm mt-1">Midad restaurant</p>
                    </div>
                    <div class="text-right">
                        <p class="text-amber-200/60 text-xs uppercase tracking-wider">Invoice Number</p>
                        <p class="text-amber-100 font-black text-lg">{{ $invoice->invoice_number }}</p>
                    </div>
                </div>
            </div>

            {{-- معلومات الفاتورة --}}
            <div class="px-8 py-6 grid grid-cols-2 gap-6 text-sm border-b border-amber-500/20">

                <div class="space-y-1">
                    <p class="text-amber-200/50 text-xs uppercase tracking-wider">Date</p>
                    <p class="text-amber-100 font-bold">
                        {{ $invoice->created_at->format('Y-m-d H:i') }}
                    </p>
                </div>

                <div class="space-y-1 text-right">
                    <p class="text-amber-200/50 text-xs uppercase tracking-wider">Order</p>
                    <p class="text-amber-100 font-bold">
                        {{ $invoice->order_id ? '#' . $invoice->order_id : '—' }}
                    </p>
                </div>

                <div class="space-y-1">
                    <p class="text-amber-200/50 text-xs uppercase tracking-wider">Tax Number</p>
                    <p class="text-amber-100 font-bold">
                        {{ $invoice->tax_number ?? '—' }}
                    </p>
                </div>

                <div class="space-y-1 text-right">
                    <p class="text-amber-200/50 text-xs uppercase tracking-wider">Cashier</p>
                    <p class="text-amber-100 font-bold">
                        {{ $invoice->creator?->name ?? '—' }}
                    </p>
                </div>

            </div>

            {{-- المجاميع --}}
            <div class="px-8 py-6 space-y-3">

                <div class="flex justify-between items-center text-amber-100">
                    <span class="text-sm uppercase tracking-wider text-amber-200/60">Subtotal</span>
                    <span class="font-bold">
                        {{ number_format($invoice->subtotal, 2) }} {{ config('restaurant.currency') }}
                    </span>
                </div>

                {{-- ✅ الخصم مع النسبة --}}
                @if($invoice->discount_amount > 0)
                    @php
                        $discountRate = $invoice->subtotal > 0
                            ? ($invoice->discount_amount / $invoice->subtotal) * 100
                            : 0;
                    @endphp

                    <div class="flex justify-between items-center text-red-300">
                        <span class="text-sm uppercase tracking-wider">
                            Discount
                            <span class="text-red-200/70 normal-case">
                                ({{ number_format($discountRate, 1) }}%)
                            </span>
                        </span>
                        <span class="font-bold">
                            - {{ number_format($invoice->discount_amount, 2) }} {{ config('restaurant.currency') }}
                        </span>
                    </div>
                @endif

                @if($invoice->tax_amount > 0)
                    <div class="flex justify-between items-center text-blue-300">
                        <span class="text-sm uppercase tracking-wider">
                            Tax ({{ $invoice->tax_rate }}%)
                        </span>
                        <span class="font-bold">
                            {{ number_format($invoice->tax_amount, 2) }} {{ config('restaurant.currency') }}
                        </span>
                    </div>
                @endif

                {{-- الإجمالي --}}
                <div class="flex justify-between items-center pt-4 mt-4
                            border-t-2 border-amber-500/40">
                    <span class="text-lg font-black text-amber-200 uppercase tracking-wider">
                        Total
                    </span>
                    <span class="text-2xl font-black text-amber-300">
                        {{ number_format($invoice->total_amount, 2) }}
                        <span class="text-sm">{{ config('restaurant.currency') }}</span>
                    </span>
                </div>

            </div>

            {{-- ملاحظات --}}
            @if($invoice->notes)
                <div class="px-8 py-4 bg-amber-500/5 border-t border-amber-500/20">
                    <p class="text-amber-200/50 text-xs uppercase tracking-wider mb-1">Notes</p>
                    <p class="text-amber-100 text-sm">{{ $invoice->notes }}</p>
                </div>
            @endif

            {{-- Footer --}}
            <div class="px-8 py-4 bg-black/40 border-t border-amber-500/20 text-center">
                <p class="text-amber-200/40 text-xs">
                    Thank you for your visit • Meddad Restaurant
                </p>
            </div>

        </div>

    </div>

</x-layouts.cashier>