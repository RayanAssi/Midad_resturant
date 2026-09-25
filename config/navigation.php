<?php

return [
    /*
    Admin Navigation
    */
    'admin' => [
        [
            'label'  => 'Dashboard',
            'icon'   => 'layout-dashboard',
            'route'  => 'admin.dashboard',
            'active' => 'admin.dashboard',
        ],
        [
            'label'  => 'Menu Items',
            'icon'   => 'utensils',
            'route'  => 'admin.menu-items.index',
            'active' => 'admin.menu-items.*',
        ],
        [
            'label'  => 'Orders',
            'icon'   => 'receipt',
            'route'  => 'admin.orders.index',
            'active' => 'admin.orders.*',
        ],
        [
            'label'  => 'Invoices',
            'icon'   => 'file-text',
            'route'  => 'admin.invoices.index',
            'active' => 'admin.invoices.*',
        ],
        [
            'label'  => 'Daily Expenses',
            'icon'   => 'wallet',
            'route'  => 'admin.expenses.index',
            'active' => 'admin.expenses.*',
        ],
        [
            'label'  => 'Employees',
            'icon'   => 'user-group',
            'route'  => 'admin.users.index',
            'active' => 'admin.users.*',
        ],
    ],

    /*
    employee Navigation
    */
    'employee' => [
        [
            'label'      => 'Menu',
            'icon'       => 'utensils',
            'route'      => 'employee.menu-items.index',
            'active'     => 'employee.menu-items.*',
        ],
        [
            'label'      => 'New Order',
            'icon'       => 'plus-circle',
            'route'      => 'employee.orders.create',
            'active'     => 'employee.orders.create',
        ],
        [
            'label'      => 'Orders',
            'icon'       => 'receipt',
            'route'      => 'employee.orders.index',
            'active'     => 'employee.orders.index',
        ],
    ],
];
