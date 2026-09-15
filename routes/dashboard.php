<?php

use App\Http\Controllers\Dashboard\MenuItemController;
use App\Http\Controllers\OrdersController;
use Illuminate\Support\Facades\Route;

//orders routes
Route::prefix('orders')->group(function () {
    
    Route::get('/', [OrdersController::class, 'index']);
    Route::post('/', [OrdersController::class, 'store']);
    Route::get('/{id}', [OrdersController::class, 'show']);
    Route::put('/{id}', [OrdersController::class, 'update']);
    Route::delete('/{id}', [OrdersController::class, 'destroy']);
    
    
    Route::get('/{id}/calculate', [OrdersController::class, 'calculateInvoice']);
    Route::post('/{id}/invoice', [OrdersController::class, 'createInvoice']);
    Route::get('/filter/type/{type}', [OrdersController::class, 'filterByType']);
    Route::get('/today/list', [OrdersController::class, 'todayOrders']);
    Route::get('/statistics/data', [OrdersController::class, 'statistics']);
    Route::get('/user/{userId}', [OrdersController::class, 'ordersByUser']);
    Route::get('/table/{tableNo}', [OrdersController::class, 'ordersByTable']);
    Route::post('/{id}/duplicate', [OrdersController::class, 'duplicateOrder']);

    Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('menu-items', MenuItemController::class);
});
});
