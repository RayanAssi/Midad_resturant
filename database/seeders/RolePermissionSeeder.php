<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        
        $permissions = [
            // Menu Items
            'menu-items.view',
            'menu-items.create',
            'menu-items.edit',
            'menu-items.delete',

            // Orders
            'orders.view',
            'orders.create',
            'orders.edit',
            'orders.delete',

            // Invoices
            'invoices.view',
            'invoices.create',
            'invoices.delete',

            // Expenses
            'expenses.view',
            'expenses.create',
            'expenses.edit',
            'expenses.delete',

            // Users
            'users.view',
            'users.create',
            'users.edit',
            'users.delete',

            // Roles
            'roles.view',
            'roles.manage',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web',
            ]);
        }

        
        // Super Admin
        $superAdmin = Role::firstOrCreate([
            'name' => 'super-admin',
            'guard_name' => 'web',
        ]);
        $superAdmin->syncPermissions(Permission::where('guard_name', 'web')->get());

        // Menu Manager
        $menuManager = Role::firstOrCreate([
            'name' => 'menu-manager',
            'guard_name' => 'web',
        ]);
        $menuManager->syncPermissions([
            'menu-items.view',
            'menu-items.create',
            'menu-items.edit',
            'menu-items.delete',
        ]);

        // Expense Manager
        $expenseManager = Role::firstOrCreate([
            'name' => 'expense-manager',
            'guard_name' => 'web',
        ]);
        $expenseManager->syncPermissions([
            'expenses.view',
            'expenses.create',
            'expenses.edit',
            'expenses.delete',
        ]);

        // Cashier
        $cashier = Role::firstOrCreate([
            'name' => 'cashier',
            'guard_name' => 'web',
        ]);
        $cashier->syncPermissions([
            'orders.view',
            'orders.create',
            'orders.edit',
            'invoices.view',
            'invoices.create',
        ]);

        
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $this->command->info('🎉 Roles & Permissions seeded successfully!');
        $this->command->info('Roles: super-admin, menu-manager, expense-manager, cashier');
        $this->command->info('Permissions: ' . Permission::count());
    }
}