<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\MenuItem;
use App\Models\User;
use Illuminate\Database\Seeder;

class OrdersSeeder extends Seeder
{
    public function run(): void
    {
        // جلب الكاشير
        $cashier = User::where('role', 'cashier')->first();

        // جلب أصناف القائمة
        $menuItems = MenuItem::all();

        // التحقق من البيانات
        if (!$cashier) {
            $this->command->error('❌ لازم تشغل UsersSeeder أولاً!');
            return;
        }

        if ($menuItems->isEmpty()) {
            $this->command->error('❌ لازم تشغل MenuItemSeeder أولاً!');
            return;
        }

        $types = ['dine_in', 'take_out', 'delivery'];

        // إنشاء 15 طلب تجريبي
        for ($i = 0; $i < 15; $i++) {
            $type = $types[array_rand($types)];

            // 1. إنشاء الطلب
            $order = Order::create([
                'user_id'      => $cashier->id,
                'type'         => $type,
                'table_no'     => $type === 'dine_in' ? 'طاولة ' . rand(1, 20) : null,
                'address'      => $type === 'delivery' ? 'شارع ' . rand(1, 50) . '، بناء ' . rand(1, 10) : null,
                'notes'        => rand(0, 1) ? 'ملاحظة تجريبية' : null,
                'total_amount' => 0,
            ]);

            // 2. إضافة 1-4 أصناف عشوائية
            $itemCount = rand(1, 4);
            $randomItems = $menuItems->random($itemCount);

            $totalAmount = 0;

            foreach ($randomItems as $menuItem) {
                $quantity = rand(1, 3);
                $price = $menuItem->price;
                $subtotal = $quantity * $price;

                OrderItem::create([
                    'order_id'     => $order->id,
                    'menu_item_id' => $menuItem->id,
                    'quantity'     => $quantity,
                    'price'        => $price,
                    'subtotal'     => $subtotal,
                ]);

                $totalAmount += $subtotal;
            }

            // 3. تحديث مجموع الطلب
            $order->update(['total_amount' => $totalAmount]);
        }

        $this->command->info('✅ تم إنشاء 15 طلب تجريبي بنجاح');
    }
}