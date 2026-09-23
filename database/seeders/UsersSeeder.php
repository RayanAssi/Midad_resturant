<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        
        $admin = User::updateOrCreate(
            ['email' => 'admin@midad.com'],
            [
                'name'     => 'مدير المطعم',
                'password' => Hash::make('password'),
                'role'     => 'manager',
                'position' => 'main manager',
                'phone'    => '0911111111',
            ]
        );

        $admin->assignRole('super-admin');

        
        $cashier = User::updateOrCreate(
            ['email' => 'cashier@midad.com'],
            [
                'name'     => 'أحمد الكاشير',
                'password' => Hash::make('password'),
                'role'     => 'employee',
                'position' => 'cashier',
                'phone'    => '0922222222',
            ]
        );
    $cashier->syncRoles(['cashier']);
        
        $chef = User::updateOrCreate(
            ['email' => 'chef@midad.com'],
            [
                'name'     => 'علي الطباخ',
                'password' => Hash::make('password'),
                'role'     => 'employee',
                'position' => 'chef',
                'phone'    => '0933333333',
            ]
        );
        $chef->syncRoles(['menu-manager']);

        
        $expenseManager = User::updateOrCreate(
            ['email' => 'expense@midad.com'],
            [
                'name'     => 'سامر مسؤول المصاريف',
                'password' => Hash::make('password'),
                'role'     => 'employee',
                'position' => 'expense-manager',
                'phone'    => '0944444444',
            ]
        );
        $expenseManager->syncRoles(['expense-manager']);

        

        $this->command->info('✅ تم إنشاء المستخدمين بنجاح');
    }
}