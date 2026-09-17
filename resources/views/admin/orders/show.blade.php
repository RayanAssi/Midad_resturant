<x-layouts.admin title="تفاصيل الطلب #{{ $order->id }}">
    <div class="max-w-4xl mx-auto space-y-6">

        {{-- ============ الكارد الرئيسي - بيانات الطلب ============ --}}
        <div class="rounded-2xl bg-gradient-to-br from-gray-900 via-gray-800 to-black
                    border-2 border-red-800/30 shadow-2xl shadow-red-900/20 overflow-hidden">

            {{-- الرأس --}}
            <div class="px-6 py-5 bg-gradient-to-r from-red-900/60 via-red-800/40 to-transparent
                        border-b-2 border-red-800/50">
                <h2 class="text-2xl font-black text-amber-100">تفاصيل الطلب #{{ $order->id }}</h2>
                <p class="text-amber-200/60 text-sm mt-1">معلومات الطلب الكاملة</p>
            </div>

            {{-- الجسم --}}
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    {{-- النوع --}}
                    <div>
                        <p class="text-xs text-amber-200/60 font-bold mb-1">النوع</p>
                        <p class="text-amber-100 font-bold text-lg">
                            @if($order->type === 'dine_in')
                                <span class="px-3 py-1 rounded-full text-xs font-bold border bg-amber-500/20 text-amber-300 border-amber-500/40">
                                    داخل المطعم
                                </span>
                            @elseif($order->type === 'delivery')
                                <span class="px-3 py-1 rounded-full text-xs font-bold border bg-red-500/20 text-red-300 border-red-500/40">
                                    توصيل
                                </span>
                            @else
                                <span class="px-3 py-1 rounded-full text-xs font-bold border bg-orange-500/20 text-orange-300 border-orange-500/40">
                                    خارجي
                                </span>
                            @endif
                        </p>
                    </div>

                    {{-- الطاولة / العنوان --}}
                    <div>
                        <p class="text-xs text-amber-200/60 font-bold mb-1">
                            {{ $order->table_no ? 'رقم الطاولة' : 'العنوان' }}
                        </p>
                        <p class="text-amber-100 font-bold text-lg">
                            {{ $order->table_no ?? $order->address ?? '-' }}
                        </p>
                    </div>

                    {{-- المستخدم --}}
                    <div>
                        <p class="text-xs text-amber-200/60 font-bold mb-1">المستخدم</p>
                        <p class="text-amber-100 font-bold text-lg">
                            {{ $order->user->name ?? '-' }}
                        </p>
                    </div>

                    {{-- التاريخ --}}
                    <div>
                        <p class="text-xs text-amber-200/60 font-bold mb-1">التاريخ</p>
                        <p class="text-amber-100 font-bold text-lg">
                            {{ $order->created_at->format('Y-m-d H:i') }}
                        </p>
                    </div>

                    {{-- المجموع --}}
                    <div>
                        <p class="text-xs text-amber-200/60 font-bold mb-1">المجموع</p>
                        <p class="text-amber-400 font-black text-2xl">
                            {{ number_format($order->total_amount, 2) }} SYP
                        </p>
                    </div>

                    {{-- الملاحظات --}}
                    @if($order->notes)
                        <div class="md:col-span-2">
                            <p class="text-xs text-amber-200/60 font-bold mb-1">ملاحظات</p>
                            <p class="text-amber-100 bg-black/30 p-3 rounded-xl border border-red-800/30">
                                {{ $order->notes }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- ============ كارد الأصناف ============ --}}
        <div class="rounded-2xl bg-gradient-to-br from-gray-900 via-gray-800 to-black
                    border-2 border-red-800/30 shadow-2xl shadow-red-900/20 overflow-hidden">

            {{-- الرأس --}}
            <div class="px-6 py-5 bg-gradient-to-r from-red-900/60 via-red-800/40 to-transparent
                        border-b-2 border-red-800/50">
                <h2 class="text-2xl font-black text-amber-100">أصناف الطلب</h2>
                <p class="text-amber-200/60 text-sm mt-1">{{ $order->orderItems->count() }} صنف</p>
            </div>

            {{-- الجدول --}}
            <div class="overflow-x-auto">
                <table class="w-full text-right">
                    <thead>
                        <tr class="bg-gradient-to-r from-red-900/60 via-red-800/40 to-transparent
                                   border-b-2 border-red-700/50">
                            <th class="px-6 py-4 text-sm font-bold text-amber-100">الصنف</th>
                            <th class="px-6 py-4 text-sm font-bold text-amber-100">السعر</th>
                            <th class="px-6 py-4 text-sm font-bold text-amber-100">الكمية</th>
                            <th class="px-6 py-4 text-sm font-bold text-amber-100">المجموع</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-red-900/30">
                        @forelse($order->orderItems as $item)
                            <tr class="hover:bg-red-900/20 transition">
                                <td class="px-6 py-4 text-amber-100 font-bold">
                                    {{ $item->menuItem->name ?? 'صنف محذوف' }}
                                </td>
                                <td class="px-6 py-4 text-amber-300">
                                    {{ number_format($item->price, 2) }} SYP
                                </td>
                                <td class="px-6 py-4 text-amber-100 font-bold">
                                    {{ $item->quantity }}
                                </td>
                                <td class="px-6 py-4 text-amber-400 font-black">
                                    {{ number_format($item->price * $item->quantity, 2) }} SYP
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center text-amber-200/60">
                                    لا توجد أصناف لهذا الطلب
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                    {{-- المجاميع --}}
                    @if($order->orderItems->count() > 0)
                        <tfoot class="border-t-2 border-red-700/50 bg-black/30">
                            <tr>
                                <td colspan="3" class="px-6 py-4 text-amber-100 font-black text-left">
                                    المجموع الفرعي:
                                </td>
                                <td class="px-6 py-4 text-amber-400 font-black">
                                    {{ number_format($order->total_amount, 2) }} SYP
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3" class="px-6 py-4 text-amber-100 font-black text-left">
                                    الضريبة (15%):
                                </td>
                                <td class="px-6 py-4 text-orange-300 font-black">
                                    {{ number_format($order->total_amount * 0.15, 2) }} SYP
                                </td>
                            </tr>
                            <tr class="border-t-2 border-amber-500/30">
                                <td colspan="3" class="px-6 py-4 text-amber-100 font-black text-left text-lg">
                                    الإجمالي:
                                </td>
                                <td class="px-6 py-4 text-green-400 font-black text-2xl">
                                    @if($order->invoice)
                                        {{ number_format($order->invoice->total, 2) }} SYP
                                    @else
                                        {{ number_format($order->total_amount * 1.15, 2) }} SYP
                                    @endif
                                </td>
                            </tr>
                        </tfoot>
                    @endif
                </table>
            </div>
        </div>

        {{-- ============ معلومات الفاتورة (إذا موجودة) ============ --}}
        @if($order->invoice)
            <div class="rounded-2xl bg-gradient-to-br from-green-900/20 via-gray-800 to-black
                        border-2 border-green-500/30 shadow-2xl shadow-green-900/20 overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-green-900/60 via-green-800/40 to-transparent
                            border-b-2 border-green-700/50">
                    <h3 class="text-lg font-black text-green-200">✅ الفاتورة الضريبية</h3>
                </div>
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-xs text-green-200/60 font-bold mb-1">رقم الفاتورة الضريبية</p>
                        <p class="text-green-100 font-mono font-bold">
                            {{ $order->invoice->tax_number }}
                        </p>
                    </div>
                    <div>
                        <p class="text-xs text-green-200/60 font-bold mb-1">تاريخ الإصدار</p>
                        <p class="text-green-100 font-bold">
                            {{ $order->invoice->created_at->format('Y-m-d H:i') }}
                        </p>
                    </div>
                </div>
            </div>
        @endif

        {{-- ============ الأزرار ============ --}}
        <div class="flex gap-3">
            <a href="{{ route('orders.index') }}"
               class="px-6 py-3 rounded-xl bg-gray-700/50 hover:bg-gray-600/50
                      text-amber-100 font-bold transition-all border border-gray-600/50">
                رجوع
            </a>
            <a href="{{ route('orders.edit', $order->id) }}"
               class="px-6 py-3 rounded-xl bg-gradient-to-r from-amber-600 to-amber-700
                      hover:from-amber-500 hover:to-amber-600
                      text-white font-bold shadow-lg shadow-amber-900/30
                      transition-all hover:scale-105 active:scale-95">
                تعديل الطلب
            </a>
        </div>

    </div>
</x-layouts.admin>