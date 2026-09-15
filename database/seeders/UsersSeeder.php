<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        // المدير
        User::updateOrCreate(
            ['email' => 'admin@midad.com'],
            [
                'name'     => 'مدير المطعم',
                'password' => Hash::make('password'),
                'role'     => 'manager',
                'phone'    => '0911111111',
            ]
        );

        // الكاشير
        User::updateOrCreate(
            ['email' => 'cashier@midad.com'],
            [
                'name'     => 'أحمد الكاشير',
                'password' => Hash::make('password'),
                'role'     => 'cashier',
                'phone'    => '0922222222',
            ]
        );

        

        $this->command->info('✅ تم إنشاء المستخدمين بنجاح');
    }
}