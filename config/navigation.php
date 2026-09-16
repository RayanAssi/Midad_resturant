<?php

return [
    /*
    Admin Navigation
    */
    'admin' => [
        [
            'label'      => 'Menu Items',
            'icon'       => 'utensils',
            'route'      => 'admin.menu-items.index',
            'active'     => 'admin.menu-items.*',
        ],
        [
            'label'      => 'Orders',
            'icon'       => 'receipt',
            'route'      => 'orders.index',
            'active'     => 'orders.*',
        ],
        [
            'label'      => 'Invoices',
            'icon'       => 'file-text',
            'route'      => 'admin.invoices.index',
            'active'     => 'admin.invoices.*',
        ],
        [
            'label'      => 'Daily Expenses',
            'icon'       => 'wallet',
            'route'      => 'admin.expenses.index',
            'active'     => 'admin.expenses.*',
        ],
    ],

    /*
    Cashier Navigation
    */
    'cashier' => [
        [
            'label'      => 'Menu',
            'icon'       => 'utensils',
            'route'      => 'cashier.menu-items.index',
            'active'     => 'cashier.menu-items.*',
        ],
        [
            'label'      => 'New Order',
            'icon'       => 'plus-circle',
            'route'      => 'cashier.orders.create',
            'active'     => 'cashier.orders.create',
        ],
        [
            'label'      => 'Orders',
            'icon'       => 'receipt',
            'route'      => 'cashier.orders.index',
            'active'     => 'cashier.orders.index',
        ],
    ],
];