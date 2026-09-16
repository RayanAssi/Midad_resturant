<x-layouts.admin title="طلب جديد">
    <div class="max-w-3xl mx-auto">
        <x-card title="إضافة طلب جديد" subtitle="املأ البيانات التالية">
            <form action="{{ route('orders.store') }}" method="POST" class="space-y-5">
                @csrf

                <x-form.input name="table_no" label="رقم الطاولة" placeholder="مثال: 5" />

                <x-form.select
                    name="type"
                    label="نوع الطلب"
                    :option="[
                        'dine_in'  => 'داخل المطعم',
                        'take_out' => 'طلبات خارجية',
                        'delivery' => 'توصيل',
                    ]"
                />

                <x-form.input name="address" label="العنوان" placeholder="للتوصيل فقط" />

                <x-form.input name="notes" label="ملاحظات" placeholder="أي ملاحظات..." />

                <div class="flex gap-3">
                    <x-button type="submit" variant="primary">حفظ</x-button>
                    <x-button href="{{ route('orders.index') }}" variant="secondary">إلغاء</x-button>
                </div>
            </form>
        </x-card>
    </div>
</x-layouts.admin>