<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Cashier\MenuItemController as CashierMenuItemController;
use App\Http\Controllers\Cashier\OrdersController as CashierOrdersController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Home redirect
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    if (auth('admin')->check()) {
        return redirect()->route('admin.menu-items.index');
    }
    if (auth('web')->check()) {
        return redirect()->route('cashier.orders.index');
    }
    return redirect('/cashier/login');
});

/*
|--------------------------------------------------------------------------
| Cashier Routes (محمية بـ auth)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')
    ->prefix('cashier')
    ->name('cashier.')
    ->group(function () {

        // Menu Items
        Route::get('menu-items', [CashierMenuItemController::class, 'index'])
            ->name('menu-items.index');

        // Orders
        Route::get('/', [CashierOrdersController::class, 'index'])
            ->name('orders.index');

        Route::get('/orders/create', [CashierOrdersController::class, 'create'])
            ->name('orders.create');
        Route::post('/orders', [CashierOrdersController::class, 'store'])
            ->name('orders.store');
        Route::get('/orders/{order}', [CashierOrdersController::class, 'show'])
            ->name('orders.show');
        Route::get('/orders/{order}/edit', [CashierOrdersController::class, 'edit'])
            ->name('orders.edit');
        Route::put('/orders/{order}', [CashierOrdersController::class, 'update'])
            ->name('orders.update');
        Route::delete('/orders/{order}', [CashierOrdersController::class, 'destroy'])
            ->name('orders.destroy');
        Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    
            });

/*
|--------------------------------------------------------------------------
| Admin Routes (كلها في dashboard.php)
|--------------------------------------------------------------------------
*/
require __DIR__.'/dashboard.php';