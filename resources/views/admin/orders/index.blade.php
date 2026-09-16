<x-layouts.admin title="إدارة الطلبات">

    <div class="space-y-6">

        {{-- رأس الصفحة --}}
        <div class="flex items-center justify-between flex-wrap gap-4">
            <div>
                <h1 class="text-3xl font-black text-transparent bg-clip-text
                           bg-gradient-to-r from-amber-300 via-orange-400 to-red-500">
                    إدارة الطلبات
                </h1>
                <p class="text-amber-200/60 text-sm mt-1">
                    عرض وإدارة جميع طلبات المطعم
                </p>
            </div>

            <a href="{{ route('orders.create') }}"
               class="inline-flex items-center gap-2
                      px-6 py-3 rounded-xl
                      bg-gradient-to-r from-red-600 to-red-800
                      hover:from-red-500 hover:to-red-700
                      text-amber-50 font-bold
                      shadow-lg shadow-red-900/50
                      transition-all hover:scale-105 active:scale-95">
                <span class="text-lg">+</span>
                طلب جديد
            </a>
        </div>

        {{-- الفلاتر --}}
        <x-card>
            <form method="GET" action="{{ route('orders.index') }}"
                  class="grid grid-cols-1 md:grid-cols-4 gap-4">

                <x-form.input name="search" label="بحث" placeholder="رقم الطاولة أو العنوان..." :value="request('search')" />

                <x-form.select name="type" label="نوع الطلب" :selected="request('type')"
                    :option="['' => 'الكل', 'dine_in' => 'داخل المطعم', 'take_out' => 'خارجي', 'delivery' => 'توصيل']" />

                <x-form.input name="date" type="date" label="التاريخ" :value="request('date')" />

                <div class="flex items-end gap-2">
                    <x-button type="submit" variant="primary" class="flex-1">تطبيق</x-button>
                    <x-button href="{{ route('orders.index') }}" variant="secondary">مسح</x-button>
                </div>
            </form>
        </x-card>

        {{-- إحصائيات --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <x-card variant="danger" padding="p-5">
                <p class="text-xs text-amber-200/60 font-bold">إجمالي الطلبات</p>
                <p class="text-3xl font-black text-amber-400 mt-2">{{ $stats['total'] ?? 0 }}</p>
            </x-card>
            <x-card variant="gold" padding="p-5">
                <p class="text-xs text-amber-200/60 font-bold">طلبات اليوم</p>
                <p class="text-3xl font-black text-amber-400 mt-2">{{ $stats['today'] ?? 0 }}</p>
            </x-card>
            <x-card variant="success" padding="p-5">
                <p class="text-xs text-amber-200/60 font-bold">الإيرادات</p>
                <p class="text-3xl font-black text-green-400 mt-2">{{ number_format($stats['revenue'] ?? 0, 2) }}</p>
            </x-card>
            <x-card variant="default" padding="p-5">
                <p class="text-xs text-amber-200/60 font-bold">متوسط الطلب</p>
                <p class="text-3xl font-black text-amber-400 mt-2">{{ number_format($stats['average'] ?? 0, 2) }}</p>
            </x-card>
        </div>

        {{-- الجدول --}}
        <x-card title="قائمة الطلبات" :icon="'<span class=\'text-xl\'>📋</span>'">
            <x-table
                :headers="['#', 'النوع', 'الطاولة/العنوان', 'المستخدم', 'المجموع', 'التاريخ', 'إجراءات']"
                :rows="$orders->map(function ($order) {
                    return [
                        '<span class=\'text-amber-400 font-black\'>#' . $order->id . '</span>',
                        '<span class=\'px-3 py-1 rounded-full text-xs font-bold border ' . ($order->type === 'dine_in' ? 'bg-amber-500/20 text-amber-300 border-amber-500/40' : ($order->type === 'delivery' ? 'bg-red-500/20 text-red-300 border-red-500/40' : 'bg-orange-500/20 text-orange-300 border-orange-500/40')) . '\'>' . ($order->type === 'dine_in' ? 'داخل المطعم' : ($order->type === 'delivery' ? 'توصيل' : 'خارجي')) . '</span>',
                        '<span class=\'text-amber-100\'>' . ($order->table_no ? 'طاولة ' . $order->table_no : ($order->address ?? '-')) . '</span>',
                        '<span class=\'text-amber-200/80\'>' . ($order->user->name ?? '-') . '</span>',
                        '<span class=\'text-amber-400 font-black\'>' . number_format($order->total_amount, 2) . ' SYP</span>',
                        '<span class=\'text-amber-200/60 text-xs\'>' . $order->created_at->format('Y-m-d H:i') . '</span>',
                        '<div class=\'flex items-center gap-2\'>
                            <a href=\'' . route('orders.show', $order->id) . '\' class=\'w-8 h-8 rounded-lg bg-amber-500/20 hover:bg-amber-500/30 border border-amber-500/40 text-amber-300 flex items-center justify-center transition-all\'>👁</a>
                            <a href=\'' . route('orders.edit', $order->id) . '\' class=\'w-8 h-8 rounded-lg bg-orange-500/20 hover:bg-orange-500/30 border border-orange-500/40 text-orange-300 flex items-center justify-center transition-all\'>✏️</a>
                            <form action=\'' . route('orders.destroy', $order->id) . '\' method=\'POST\' class=\'inline\' onsubmit=\'return confirm("هل أنت متأكد؟")\'>' . csrf_field() . method_field('DELETE') . '<button type=\'submit\' class=\'w-8 h-8 rounded-lg bg-red-500/20 hover:bg-red-500/30 border border-red-500/40 text-red-300 flex items-center justify-center transition-all\'>🗑</button></form>
                        </div>',
                    ];
                })->toArray()"
                emptyMessage="لا توجد طلبات لعرضها حالياً"
            />

            <x-slot:footer>
                <x-pagination :paginator="$orders" />
            </x-slot:footer>
        </x-card>

    </div>

</x-layouts.admin>