<?php

use App\Http\Controllers\Employee\DashboardController;
use App\Http\Controllers\Employee\InvoiceController;
use App\Http\Controllers\Employee\MenuItemController as EmployeeMenuItemController;
use App\Http\Controllers\Employee\OrdersController as EmployeeOrdersController;
use App\Http\Controllers\Employee\ExpensesController as EmployeeExpensesController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')
    ->prefix('employee')
    ->name('employee.')
    ->group(function () {

        Route::get('/', function () {
            return redirect()->route('employee.dashboard');
        })->name('home');


        Route::get('dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');


        Route::get('profile', [ProfileController::class, 'show'])
            ->name('profile.show');


        Route::middleware('role:menu-manager|super-admin')
            ->prefix('menu-items')
            ->name('menu-items.')
            ->group(function () {
                Route::get('/', [EmployeeMenuItemController::class, 'index'])->name('index');
                Route::get('create',   [EmployeeMenuItemController::class, 'create'])->name('create');
                Route::post('/',       [EmployeeMenuItemController::class, 'store'])->name('store');
                Route::get('{menuItem}',        [EmployeeMenuItemController::class, 'show'])->name('show');
                Route::get('{menuItem}/edit',   [EmployeeMenuItemController::class, 'edit'])->name('edit');
                Route::put('{menuItem}',        [EmployeeMenuItemController::class, 'update'])->name('update');
                Route::delete('{menuItem}',     [EmployeeMenuItemController::class, 'destroy'])->name('destroy');
            });


        Route::middleware('role:cashier|super-admin')
            ->prefix('orders')
            ->name('orders.')
            ->group(function () {
                Route::get('/', [EmployeeOrdersController::class, 'index'])->name('index');
                Route::get('create', [EmployeeOrdersController::class, 'create'])->name('create');
                Route::post('/', [EmployeeOrdersController::class, 'store'])->name('store');
                Route::get('{order}', [EmployeeOrdersController::class, 'show'])->name('show');
                Route::get('{order}/edit', [EmployeeOrdersController::class, 'edit'])->name('edit');
                Route::put('{order}', [EmployeeOrdersController::class, 'update'])->name('update');
                Route::delete('{order}', [EmployeeOrdersController::class, 'destroy'])->name('destroy');
            });


        Route::middleware('role:cashier|super-admin')
            ->prefix('invoices')
            ->name('invoices.')
            ->group(function () {
                Route::get('/', [InvoiceController::class, 'index'])->name('index');
                Route::get('create', [InvoiceController::class, 'create'])->name('create');
                Route::post('/', [InvoiceController::class, 'store'])->name('store');
                Route::get('{invoice}', [InvoiceController::class, 'show'])->name('show');
            });

        Route::middleware('role:expense-manager|super-admin')
            ->prefix('expenses')
            ->name('expenses.')
            ->group(function () {  
                Route::get('/', [EmployeeExpensesController::class, 'index'])->name('index');
                Route::get('create', [EmployeeExpensesController::class, 'create'])->name('create');
                Route::post('/', [EmployeeExpensesController::class, 'store'])->name('store');
                Route::get('{expense}', [EmployeeExpensesController::class, 'show'])->name('show');
                Route::get('{expense}/edit', [EmployeeExpensesController::class, 'edit'])->name('edit');
                Route::put('{expense}', [EmployeeExpensesController::class, 'update'])->name('update');
                Route::delete('{expense}', [EmployeeExpensesController::class, 'destroy'])->name('destroy');
          });
    });