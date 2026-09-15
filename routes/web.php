<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Cashier\MenuItemController as CashierMenuItemController;
use App\Http\Controllers\Cashier\OrderController as CashierOrderController;
use App\Http\Controllers\Dashboard\MenuItemController;

Route::get('/', fn () => redirect()->route('admin.menu-items.index'));

// ============ Admin ============
Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('menu-items', MenuItemController::class);
});

// ============ Cashier ============
Route::prefix('cashier')->name('cashier.')->group(function () {
    Route::get('menu-items', [CashierMenuItemController::class, 'index'])
        ->name('menu-items.index');

    Route::get('orders', [CashierOrderController::class, 'index'])
        ->name('orders.index');

    Route::post('orders', [CashierOrderController::class, 'store'])
        ->name('orders.store');
});
require __DIR__.'/dashboard.php';
