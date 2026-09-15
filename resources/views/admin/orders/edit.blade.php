<x-layouts.app title="تعديل الطلب">
    <div class="max-w-3xl mx-auto">
        <x-card title="تعديل الطلب #{{ $order->id }}">
            <form action="{{ route('orders.update', $order->id) }}" method="POST" class="space-y-5">
                @csrf
                @method('PUT')

                <x-form.input name="table_no" label="رقم الطاولة" :value="$order->table_no" />

                <x-form.select
                    name="type"
                    label="نوع الطلب"
                    :selected="$order->type"
                    :option="[
                        'dine_in'  => 'داخل المطعم',
                        'take_out' => 'طلبات خارجية',
                        'delivery' => 'توصيل',
                    ]"
                />

                <x-form.input name="address" label="العنوان" :value="$order->address" />

                <x-form.input name="notes" label="ملاحظات" :value="$order->notes" />

                <div class="flex gap-3">
                    <x-button type="submit" variant="primary">تحديث</x-button>
                    <x-button href="{{ route('orders.index') }}" variant="secondary">إلغاء</x-button>
                </div>
            </form>
        </x-card>
    </div>
</x-layouts.app>