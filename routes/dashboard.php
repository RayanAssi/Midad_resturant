<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\OrdersController;
use App\Http\Controllers\Dashboard\MenuItemController;



// ============ Admin ============
Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('menu-items', MenuItemController::class);
});

/*
|--------------------------------------------------------------------------
| Orders Routes
|--------------------------------------------------------------------------
*/

Route::prefix('orders')->name('orders.')->group(function () {

    // CRUD الأساسي
    Route::get('/', [OrdersController::class, 'index'])->name('index');
    Route::get('/create', [OrdersController::class, 'create'])->name('create');
    Route::post('/', [OrdersController::class, 'store'])->name('store');
    Route::get('/{id}', [OrdersController::class, 'show'])->name('show');
    Route::get('/{id}/edit', [OrdersController::class, 'edit'])->name('edit');
    Route::put('/{id}', [OrdersController::class, 'update'])->name('update');
    Route::delete('/{id}', [OrdersController::class, 'destroy'])->name('destroy');

    // Routes إضافية
    Route::get('/{id}/calculate', [OrdersController::class, 'calculateInvoice'])->name('calculate');
    Route::post('/{id}/invoice', [OrdersController::class, 'createInvoice'])->name('invoice');
    Route::get('/filter/type/{type}', [OrdersController::class, 'filterByType'])->name('filter.type');
    Route::get('/today/list', [OrdersController::class, 'todayOrders'])->name('today');
    Route::get('/statistics/data', [OrdersController::class, 'statistics'])->name('statistics');
    Route::get('/user/{userId}', [OrdersController::class, 'ordersByUser'])->name('by.user');
    Route::get('/table/{tableNo}', [OrdersController::class, 'ordersByTable'])->name('by.table');
    Route::post('/{id}/duplicate', [OrdersController::class, 'duplicateOrder'])->name('duplicate');
});

/*
|--------------------------------------------------------------------------
| Admin Routes (MenuItems, Invoices, Expenses)
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('menu-items', MenuItemController::class);
    Route::get('invoices', fn() => view('admin.invoices.index'))->name('invoices.index');
    Route::get('expenses', fn() => view('admin.expenses.index'))->name('expenses.index');
});