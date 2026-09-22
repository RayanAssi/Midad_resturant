<?php

use App\Http\Controllers\Employee\DashboardController;
use App\Http\Controllers\Employee\InvoiceController;
use App\Http\Controllers\Employee\MenuItemController as EmployeeMenuItemController;
use App\Http\Controllers\Employee\OrdersController as EmployeeOrdersController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')
    ->prefix('employee')
    ->name('employee.')
    ->group(function () {

            
        Route::get('/', function () {
            return redirect()->route('employee.dashboard');
        })->name('home');

        // ═══ Dashboard ═══
        Route::get('dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');

        // ═══ Menu Items ═══
        Route::get('menu-items', [EmployeeMenuItemController::class, 'index'])
            ->name('menu-items.index');

        // ═══ Orders ═══
        Route::get('orders', [EmployeeOrdersController::class, 'index'])
            ->name('orders.index');
        Route::get('orders/create', [EmployeeOrdersController::class, 'create'])
            ->name('orders.create');
        Route::post('orders', [EmployeeOrdersController::class, 'store'])
            ->name('orders.store');
        Route::get('orders/{order}', [EmployeeOrdersController::class, 'show'])
            ->name('orders.show');
        Route::get('orders/{order}/edit', [EmployeeOrdersController::class, 'edit'])
            ->name('orders.edit');
        Route::put('orders/{order}', [EmployeeOrdersController::class, 'update'])
            ->name('orders.update');
        Route::delete('orders/{order}', [EmployeeOrdersController::class, 'destroy'])
            ->name('orders.destroy');

        // ═══ Profile ═══
        Route::get('profile', [ProfileController::class, 'show'])
            ->name('profile.show');

        // ═══ Invoices ═══
        Route::get('invoices', [InvoiceController::class, 'index'])
            ->name('invoices.index');
        Route::get('invoices/create', [InvoiceController::class, 'create'])
            ->name('invoices.create');
        Route::post('invoices', [InvoiceController::class, 'store'])
            ->name('invoices.store');
        Route::get('invoices/{invoice}', [InvoiceController::class, 'show'])
            ->name('invoices.show');
    });