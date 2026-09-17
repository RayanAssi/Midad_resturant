<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Cashier\MenuItemController as CashierMenuItemController;
use App\Http\Controllers\Cashier\OrderController as CashierOrderController;
use App\Http\Controllers\Cashier\OrdersController as CashierOrdersController;
use App\Http\Controllers\Dashboard\MenuItemController;
use App\Http\Controllers\Dashboard\OrdersController;

Route::get('/', fn () => redirect()->route('admin.menu-items.index'));

// ============ Cashier ============
Route::prefix('cashier')->name('cashier.')->group(function () {
    Route::get('menu-items', [CashierMenuItemController::class, 'index'])
        ->name('menu-items.index');

    Route::get('/', [CashierOrdersController::class, 'index'])->name('orders.index');
        Route::get('orders/create', [CashierOrdersController::class, 'create'])
        ->name('orders.create');

    Route::post('orders', [CashierOrdersController::class, 'store'])
        ->name('orders.store');
        Route::get('/orders/{order}', [CashierOrdersController::class, 'show'])->name('orders.show');
        Route::get('/orders/{order}/edit', [OrdersController::class, 'edit'])->name('orders.edit');
        Route::put('/orders/{order}', [OrdersController::class, 'update'])->name('orders.update');
        Route::delete('/orders/{order}', [OrdersController::class, 'destroy'])->name('orders.destroy');
    });

require __DIR__.'/dashboard.php';
