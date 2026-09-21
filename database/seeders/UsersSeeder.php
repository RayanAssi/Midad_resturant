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
                'position' => 'main manager',
                'phone'    => '0911111111',
            ]
        );

        // الكاشير
         // المدير
        User::updateOrCreate(
            ['email' => 'manager@midad.com'],
            [
                'name'     => 'مدير المطعم',
                'password' => Hash::make('password'),
                'role'     => 'manager',
                'position' => 'manager',
                'phone'    => '0911111111',
            ]
        );

        // كاشير
        User::updateOrCreate(
            ['email' => 'cashier@midad.com'],
            [
                'name'     => 'أحمد الكاشير',
                'password' => Hash::make('password'),
                'role'     => 'employee',
                'position' => 'cashier',
                'phone'    => '0922222222',
            ]
        );

        // طباخ
        User::updateOrCreate(
            ['email' => 'chef@midad.com'],
            [
                'name'     => 'علي الطباخ',
                'password' => Hash::make('password'),
                'role'     => 'employee',
                'position' => 'chef',
                'phone'    => '0933333333',
            ]
        );

        // عامل نظافة
        User::updateOrCreate(
            ['email' => 'cleaner@midad.com'],
            [
                'name'     => 'محمد عامل النظافة',
                'password' => Hash::make('password'),
                'role'     => 'employee',
                'position' => 'cleaner',
                'phone'    => '0944444444',
            ]
        );

        

        $this->command->info('✅ تم إنشاء المستخدمين بنجاح');
    }
}