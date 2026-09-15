<?php

namespace Database\Seeders;

use App\Models\MenuItem;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class MenuItemSeeder extends Seeder
{
    public function run(): void
    {
        // تأكدي إن المجلد موجود
        Storage::disk('public')->makeDirectory('menu-items');

        // نفس الصورة لكل الأصناف
        $defaultImage = 'menu-items/hummus.jpg';

        $items = [
            // Appetizers
            ['name' => 'Hummus',         'price' => 15000, 'category' => 'appetizer'],
            ['name' => 'Mutabbal',       'price' => 16000, 'category' => 'appetizer'],
            ['name' => 'Fattoush',       'price' => 18000, 'category' => 'appetizer'],
            ['name' => 'Tabbouleh',      'price' => 17000, 'category' => 'appetizer'],
            ['name' => 'Cheese Rolls',   'price' => 22000, 'category' => 'appetizer'],

            // Main Courses
            ['name' => 'Grilled Chicken', 'price' => 65000, 'category' => 'main_course'],
            ['name' => 'Mixed Grill',     'price' => 95000, 'category' => 'main_course'],
            ['name' => 'Shawarma Plate',  'price' => 55000, 'category' => 'main_course'],
            ['name' => 'Beef Kebab',      'price' => 80000, 'category' => 'main_course'],
            ['name' => 'Chicken Biryani', 'price' => 60000, 'category' => 'main_course'],
            ['name' => 'Falafel Plate',   'price' => 35000, 'category' => 'main_course'],

            // Desserts
            ['name' => 'Kunafa',     'price' => 30000, 'category' => 'dessert'],
            ['name' => 'Baklava',    'price' => 25000, 'category' => 'dessert'],
            ['name' => 'Muhallabia', 'price' => 20000, 'category' => 'dessert'],
            ['name' => 'Ice Cream',  'price' => 18000, 'category' => 'dessert'],

            // Beverages
            ['name' => 'Fresh Orange Juice', 'price' => 15000, 'category' => 'beverage'],
            ['name' => 'Lemon Mint',         'price' => 14000, 'category' => 'beverage'],
            ['name' => 'Arabic Coffee',      'price' => 10000, 'category' => 'beverage'],
            ['name' => 'Tea',                'price' => 8000,  'category' => 'beverage'],
            ['name' => 'Soft Drink',         'price' => 10000, 'category' => 'beverage'],
        ];

        foreach ($items as $item) {
            MenuItem::updateOrCreate(
                ['name' => $item['name']],
                [
                    'name'     => $item['name'],
                    'price'    => $item['price'],
                    'category' => $item['category'],
                    'image'    => $defaultImage,
                ]
            );
        }
    }
}