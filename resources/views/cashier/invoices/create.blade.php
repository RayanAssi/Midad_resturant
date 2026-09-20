<x-layouts.cashier title="إصدار فاتورة">

    <div class="max-w-2xl mx-auto">

        {{-- ═══ Header مع زر رجوع ═══ --}}
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-3xl font-black text-transparent bg-clip-text
                       bg-gradient-to-r from-amber-300 to-orange-400">
                إصدار فاتورة جديدة
            </h1>

            <a href="{{ route('cashier.orders.index') }}"
               class="px-4 py-2 rounded-lg bg-black/40 border border-amber-500/30
                      text-amber-200 hover:border-amber-400/60 hover:bg-amber-500/10
                      transition-all flex items-center gap-2">
                ← رجوع للطلبات
            </a>
        </div>

        {{-- ═══ إذا الفاتورة انصدرت بالفعل ═══ --}}
        @if(session('invoice_created'))
            <div class="bg-black/40 border border-emerald-500/40 rounded-xl p-8 space-y-6 text-center">

                <div class="w-20 h-20 mx-auto rounded-full bg-emerald-500/20
                            border-2 border-emerald-400/50 flex items-center justify-center">
                    <span class="text-4xl">✓</span>
                </div>

                <div>
                    <h2 class="text-2xl font-black text-emerald-300 mb-2">
                        تم إصدار الفاتورة بنجاح
                    </h2>
                    <p class="text-amber-200/70">
                        رقم الفاتورة:
                        <span class="text-amber-100 font-bold">
                            {{ session('invoice_created') }}
                        </span>
                    </p>
                </div>

                <a href="{{ route('cashier.orders.index') }}"
                   class="inline-block w-full px-6 py-3 rounded-lg
                          bg-gradient-to-r from-amber-600 to-amber-800
                          hover:from-amber-500 hover:to-amber-700
                          text-white font-black text-lg
                          shadow-lg shadow-amber-900/50 transition-all">
                    🏁 انتهاء
                </a>
            </div>
        @else
            {{-- ═══ الفورم العادي ═══ --}}
            <form action="{{ route('cashier.invoices.store') }}" method="POST"
                  class="bg-black/40 border border-amber-500/20 rounded-xl p-6 space-y-5">
                @csrf

                @if($selectedOrder)
                    <input type="hidden" name="order_id" value="{{ $selectedOrder->id }}">

                    <div class="bg-amber-500/10 border border-amber-400/30 rounded-lg p-4 space-y-2">
                        <div class="flex justify-between">
                            <span class="text-amber-200/60">رقم الطلب:</span>
                            <span class="text-amber-100 font-bold">#{{ $selectedOrder->id }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-amber-200/60">النوع:</span>
                            <span class="text-amber-100">{{ $selectedOrder->type }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-amber-200/60">المجموع الفرعي:</span>
                            <span class="text-amber-100 font-bold">
                                {{ number_format($selectedOrder->total_amount, 2) }} {{ config('restaurant.currency') }}
                            </span>
                        </div>
                    </div>

                    @php
                        $taxRate  = config('restaurant.tax_rate') / 100;
                        $subtotal = $selectedOrder->total_amount;
                        $discount = old('discount_amount', 0);
                        $tax      = ($subtotal - $discount) * $taxRate;
                        $total    = $subtotal - $discount + $tax;
                    @endphp

                    <div>
                        <label class="block text-amber-200 mb-2 font-bold">الخصم (اختياري)</label>
                        <input type="number" name="discount_amount" step="0.01" min="0"
                               value="{{ $discount }}"
                               class="w-full px-4 py-2.5 rounded-lg bg-black/60 border border-amber-500/30
                                      text-amber-100 focus:border-amber-400 focus:outline-none">
                    </div>

                    <div class="bg-black/50 border border-blue-400/20 rounded-lg p-4 space-y-2 text-sm">
                        <div class="flex justify-between text-amber-100">
                            <span>المجموع الفرعي</span>
                            <span>{{ number_format($subtotal, 2) }} {{ config('restaurant.currency') }}</span>
                        </div>
                        <div class="flex justify-between text-red-300">
                            <span>الخصم</span>
                            <span>- {{ number_format($discount, 2) }} {{ config('restaurant.currency') }}</span>
                        </div>
                        <div class="flex justify-between text-blue-300">
                            <span>الضريبة ({{ config('restaurant.tax_rate') }}%)</span>
                            <span>{{ number_format($tax, 2) }} {{ config('restaurant.currency') }}</span>
                        </div>
                        <div class="flex justify-between text-amber-300 font-black border-t border-amber-500/30 pt-2">
                            <span>الإجمالي</span>
                            <span>{{ number_format($total, 2) }} {{ config('restaurant.currency') }}</span>
                        </div>
                    </div>

                    <div>
                        <label class="block text-amber-200 mb-2 font-bold">ملاحظات (اختياري)</label>
                        <textarea name="notes" rows="2"
                                  class="w-full px-4 py-2.5 rounded-lg bg-black/60 border border-amber-500/30
                                         text-amber-100 focus:border-amber-400 focus:outline-none">{{ old('notes') }}</textarea>
                    </div>

                    <button type="submit"
                            class="w-full px-6 py-3 rounded-lg bg-gradient-to-r from-emerald-600 to-emerald-800
                                   hover:from-emerald-500 hover:to-emerald-700 text-white font-bold text-lg
                                   shadow-lg shadow-emerald-900/50 transition-all">
                        💰 إصدار الفاتورة
                    </button>
                @else
                    <div>
                        <label class="block text-amber-200 mb-2 font-bold">اختر الطلب</label>
                        <select name="order_id" required
                                class="w-full px-4 py-2.5 rounded-lg bg-black/60 border border-amber-500/30
                                       text-amber-100 focus:border-amber-400 focus:outline-none">
                            <option value="">-- اختر طلب --</option>
                            @foreach($orders as $order)
                                <option value="{{ $order->id }}" @selected(old('order_id') == $order->id)>
                                    #{{ $order->id }} — {{ $order->type }} — {{ number_format($order->total_amount, 2) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit"
                            class="w-full px-6 py-3 rounded-lg bg-gradient-to-r from-emerald-600 to-emerald-800
                                   hover:from-emerald-500 hover:to-emerald-700 text-white font-bold">
                        متابعة → إصدار الفاتورة
                    </button>
                @endif

            </form>
        @endif

    </div>

</x-layouts.cashier>