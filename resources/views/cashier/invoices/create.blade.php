<x-layouts.cashier title="Issue Invoice">

    <div class="max-w-2xl mx-auto">

        {{-- ═══ Header ═══ --}}
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-3xl font-black text-transparent bg-clip-text
                           bg-gradient-to-r from-amber-300 to-orange-400">
                    Issue Invoice
                </h1>
                <p class="text-amber-200/60 text-sm mt-1">
                    Complete the invoice details
                </p>
            </div>

        </div>

        {{-- ═══ Success State ═══ --}}
        @if(session('invoice_created'))
            <div class="bg-gradient-to-br from-gray-900 via-gray-800 to-black
                        border-2 border-emerald-500/40 rounded-2xl p-8 space-y-6 text-center
                        shadow-2xl shadow-emerald-900/20">

                <div class="w-20 h-20 mx-auto rounded-full
                            bg-gradient-to-br from-emerald-500/30 to-emerald-700/20
                            border-2 border-emerald-400/50
                            flex items-center justify-center
                            shadow-lg shadow-emerald-900/50">
                    <x-lucide-check class="w-10 h-10 text-emerald-300" />
                </div>

                <div>
                    <h2 class="text-2xl font-black text-emerald-300 mb-2">
                        Invoice Issued Successfully
                    </h2>
                    <p class="text-amber-200/70 text-sm">
                        Invoice Number:
                        <span class="text-amber-100 font-bold">
                            {{ session('invoice_created') }}
                        </span>
                    </p>
                </div>

                {{-- ✅ زرين: Print + Done --}}
                <div class="grid grid-cols-2 gap-3">

                    {{-- Print Button --}}
                    @if(session('invoice_id'))
                        <a href="{{ route('cashier.invoices.show', session('invoice_id')) }}"
                           class="flex items-center justify-center gap-2
                                  px-6 py-3 rounded-lg
                                  bg-gradient-to-r from-amber-600 to-amber-800
                                  hover:from-amber-500 hover:to-amber-700
                                  text-white font-black text-lg
                                  shadow-lg shadow-amber-900/50
                                  transition-all">
                            <x-lucide-printer class="w-5 h-5" />
                            Print
                        </a>
                    @endif

                    {{-- Done Button --}}
                    <a href="{{ route('cashier.orders.index') }}"
                       class="flex items-center justify-center gap-2
                              px-6 py-3 rounded-lg
                              bg-gradient-to-r from-emerald-600 to-emerald-800
                              hover:from-emerald-500 hover:to-emerald-700
                              text-white font-black text-lg
                              shadow-lg shadow-emerald-900/50
                              transition-all">
                        <x-lucide-check-circle class="w-5 h-5" />
                        Done
                    </a>

                </div>
            </div>
        @else
            {{-- ═══ Form ═══ --}}
            <form action="{{ route('cashier.invoices.store') }}" method="POST"
                  class="bg-gradient-to-br from-gray-900 via-gray-800 to-black
                         border-2 border-amber-500/30 rounded-2xl overflow-hidden
                         shadow-2xl shadow-amber-900/20">
                @csrf

                @if($selectedOrder)
                    <input type="hidden" name="order_id" value="{{ $selectedOrder->id }}">

                    {{-- ═══ Order Info Header ═══ --}}
                    <div class="px-6 py-5 bg-gradient-to-r from-amber-900/40 via-amber-800/20 to-transparent
                                border-b-2 border-amber-500/30">
                        <div class="flex items-center justify-between">
                            <div>
                                <h2 class="text-lg font-black text-amber-100">Order Details</h2>
                                <p class="text-amber-200/60 text-xs mt-0.5">Review before issuing</p>
                            </div>
                            <div class="p-2 rounded-lg bg-amber-500/10 border border-amber-400/30">
                                <x-lucide-shopping-bag class="w-5 h-5 text-amber-300" />
                            </div>
                        </div>
                    </div>

                    {{-- ═══ Order Info ═══ --}}
                    <div class="px-6 py-5 grid grid-cols-3 gap-4 border-b border-amber-500/20">
                        <div>
                            <p class="text-amber-200/50 text-xs uppercase tracking-wider mb-1">Order #</p>
                            <p class="text-amber-100 font-black text-lg">#{{ $selectedOrder->id }}</p>
                        </div>
                        <div>
                            <p class="text-amber-200/50 text-xs uppercase tracking-wider mb-1">Type</p>
                            <p class="text-amber-100 font-bold capitalize">
                                {{ str_replace('_', ' ', $selectedOrder->type) }}
                            </p>
                        </div>
                        <div class="text-right">
                            <p class="text-amber-200/50 text-xs uppercase tracking-wider mb-1">Subtotal</p>
                            <p class="text-amber-100 font-black">
                                {{ number_format($selectedOrder->total_amount, 2) }}
                                <span class="text-xs">{{ config('restaurant.currency') }}</span>
                            </p>
                        </div>
                    </div>

                    {{-- ═══ Calculations ═══ --}}
                    @php
                        $taxRate  = config('restaurant.tax_rate') / 100;
                        $subtotal = $selectedOrder->total_amount;
                        $discount = old('discount_amount', 0);
                        $tax      = ($subtotal - $discount) * $taxRate;
                        $total    = $subtotal - $discount + $tax;
                    @endphp

                    {{-- ═══ Discount Input ═══ --}}
                    <div class="px-6 py-5 border-b border-amber-500/20">
                        <label class="flex items-center gap-2 text-amber-200 font-bold mb-3 text-sm">
                            <x-lucide-percent class="w-4 h-4" />
                            Discount (Optional)
                        </label>
                        <input type="number" name="discount_amount" step="0.01" min="0"
                               value="{{ $discount }}"
                               placeholder="0.00"
                               class="w-full px-4 py-3 rounded-lg bg-black/60 border-2 border-amber-500/30
                                      text-amber-100 font-bold text-lg
                                      focus:border-amber-400 focus:outline-none
                                      transition-colors">
                    </div>

                    {{-- ═══ Summary ═══ --}}
                    <div class="px-6 py-5 border-b border-amber-500/20">
                        <div class="flex items-center gap-2 mb-3">
                            <x-lucide-receipt class="w-4 h-4 text-amber-300" />
                            <h3 class="text-amber-200 font-bold text-sm uppercase tracking-wider">
                                Summary
                            </h3>
                        </div>

                        <div class="bg-black/50 border border-amber-500/20 rounded-xl p-4 space-y-3">

                            <div class="flex justify-between items-center text-amber-100">
                                <span class="text-sm uppercase tracking-wider text-amber-200/60">Subtotal</span>
                                <span class="font-bold">
                                    {{ number_format($subtotal, 2) }} {{ config('restaurant.currency') }}
                                </span>
                            </div>

                            <div class="flex justify-between items-center text-red-300">
                                <span class="text-sm uppercase tracking-wider">Discount</span>
                                <span class="font-bold">
                                    - {{ number_format($discount, 2) }} {{ config('restaurant.currency') }}
                                </span>
                            </div>

                            <div class="flex justify-between items-center text-blue-300">
                                <span class="text-sm uppercase tracking-wider">
                                    Tax ({{ config('restaurant.tax_rate') }}%)
                                </span>
                                <span class="font-bold">
                                    {{ number_format($tax, 2) }} {{ config('restaurant.currency') }}
                                </span>
                            </div>

                            <div class="flex justify-between items-center pt-3 border-t-2 border-amber-500/40">
                                <span class="text-base font-black text-amber-200 uppercase tracking-wider">
                                    Total
                                </span>
                                <span class="text-2xl font-black text-amber-300">
                                    {{ number_format($total, 2) }}
                                    <span class="text-sm">{{ config('restaurant.currency') }}</span>
                                </span>
                            </div>

                        </div>
                    </div>

                    {{-- ═══ Notes ═══ --}}
                    <div class="px-6 py-5 border-b border-amber-500/20">
                        <label class="flex items-center gap-2 text-amber-200 font-bold mb-3 text-sm">
                            <x-lucide-message-square class="w-4 h-4" />
                            Notes (Optional)
                        </label>
                        <textarea name="notes" rows="3"
                                  placeholder="Any additional notes..."
                                  class="w-full px-4 py-2.5 rounded-lg bg-black/60 border-2 border-amber-500/30
                                         text-amber-100 focus:border-amber-400 focus:outline-none
                                         resize-none transition-colors">{{ old('notes') }}</textarea>
                    </div>

                    {{-- ═══ Submit ═══ --}}
                    <div class="px-6 py-5 bg-black/30">
                        <button type="submit"
                                class="w-full flex items-center justify-center gap-2
                                       px-6 py-4 rounded-xl
                                       bg-gradient-to-r from-emerald-600 to-emerald-800
                                       hover:from-emerald-500 hover:to-emerald-700
                                       text-white font-black text-lg
                                       shadow-lg shadow-emerald-900/50
                                       transition-all
                                       hover:scale-[1.02] active:scale-[0.98]">
                            <x-lucide-receipt class="w-5 h-5" />
                            Issue Invoice
                        </button>
                    </div>

                @else
                    {{-- ═══ Order Selection ═══ --}}
                    <div class="px-6 py-6 border-b border-amber-500/20">
                        <label class="flex items-center gap-2 text-amber-200 font-bold mb-3 text-sm">
                            <x-lucide-list class="w-4 h-4" />
                            Select Order
                        </label>
                        <select name="order_id" required
                                class="w-full px-4 py-3 rounded-lg bg-black/60 border-2 border-amber-500/30
                                       text-amber-100 font-medium
                                       focus:border-amber-400 focus:outline-none
                                       transition-colors">
                            <option value="">-- Choose an order --</option>
                            @foreach($orders as $order)
                                <option value="{{ $order->id }}" @selected(old('order_id') == $order->id)>
                                    #{{ $order->id }} — {{ ucfirst(str_replace('_', ' ', $order->type)) }} — {{ number_format($order->total_amount, 2) }} {{ config('restaurant.currency') }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="px-6 py-5 bg-black/30">
                        <button type="submit"
                                class="w-full flex items-center justify-center gap-2
                                       px-6 py-4 rounded-xl
                                       bg-gradient-to-r from-emerald-600 to-emerald-800
                                       hover:from-emerald-500 hover:to-emerald-700
                                       text-white font-black text-lg
                                       shadow-lg shadow-emerald-900/50
                                       transition-all
                                       hover:scale-[1.02] active:scale-[0.98]">
                            <x-lucide-arrow-right class="w-5 h-5" />
                            Continue to Invoice
                        </button>
                    </div>
                @endif

            </form>
        @endif

    </div>

</x-layouts.cashier>