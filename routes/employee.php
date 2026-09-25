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

        // ═══════════════════════════════════════════════════════
        // ═══ Home ═══
        // ═══════════════════════════════════════════════════════
        Route::get('/', function () {
            return redirect()->route('employee.dashboard');
        })->name('home');

        // ═══════════════════════════════════════════════════════
        // ═══ Dashboard ═══
        // ═══════════════════════════════════════════════════════
        Route::get('dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');

        // ═══════════════════════════════════════════════════════
        // ═══ Profile ═══
        // ═══════════════════════════════════════════════════════
        Route::get('profile', [ProfileController::class, 'show'])
            ->name('profile.show');

        // ═══════════════════════════════════════════════════════
        // ═══ Menu Items ═══
        // ═══════════════════════════════════════════════════════
        Route::prefix('menu-items')
            ->name('menu-items.')
            ->group(function () {

                Route::middleware('permission:menu-items.view')->group(function () {
                    Route::get('/', [EmployeeMenuItemController::class, 'index'])->name('index');
                });

                Route::middleware('permission:menu-items.create')->group(function () {
                    Route::get('create', [EmployeeMenuItemController::class, 'create'])->name('create');
                    Route::post('/', [EmployeeMenuItemController::class, 'store'])->name('store');
                });

                Route::middleware('permission:menu-items.edit')->group(function () {
                    Route::get('{menuItem}/edit', [EmployeeMenuItemController::class, 'edit'])->name('edit');
                    Route::put('{menuItem}', [EmployeeMenuItemController::class, 'update'])->name('update');
                });

                Route::middleware('permission:menu-items.view')->group(function () {
                    Route::get('{menuItem}', [EmployeeMenuItemController::class, 'show'])->name('show');
                });

                Route::middleware('permission:menu-items.delete')->group(function () {
                    Route::delete('{menuItem}', [EmployeeMenuItemController::class, 'destroy'])->name('destroy');
                });
            });

        // ═══════════════════════════════════════════════════════
        // ═══ Orders ═══
        // ═══════════════════════════════════════════════════════
        Route::prefix('orders')
            ->name('orders.')
            ->group(function () {

                Route::middleware('permission:orders.view')->group(function () {
                    Route::get('/', [EmployeeOrdersController::class, 'index'])->name('index');
                });

                Route::middleware('permission:orders.create')->group(function () {
                    Route::get('create', [EmployeeOrdersController::class, 'create'])->name('create');
                    Route::post('/', [EmployeeOrdersController::class, 'store'])->name('store');
                });

                Route::middleware('permission:orders.edit')->group(function () {
                    Route::get('{order}/edit', [EmployeeOrdersController::class, 'edit'])->name('edit');
                    Route::put('{order}', [EmployeeOrdersController::class, 'update'])->name('update');
                });

                Route::middleware('permission:orders.view')->group(function () {
                    Route::get('{order}', [EmployeeOrdersController::class, 'show'])->name('show');
                });

                Route::middleware('permission:orders.delete')->group(function () {
                    Route::delete('{order}', [EmployeeOrdersController::class, 'destroy'])->name('destroy');
                });
            });

        // ═══════════════════════════════════════════════════════
        // ═══ Invoices ═══
        // ═══════════════════════════════════════════════════════
        Route::prefix('invoices')
            ->name('invoices.')
            ->group(function () {

                Route::middleware('permission:invoices.view')->group(function () {
                    Route::get('/', [InvoiceController::class, 'index'])->name('index');
                });

                Route::middleware('permission:invoices.create')->group(function () {
                    Route::get('create', [InvoiceController::class, 'create'])->name('create');
                    Route::post('/', [InvoiceController::class, 'store'])->name('store');
                });

                Route::middleware('permission:invoices.view')->group(function () {
                    Route::get('{invoice}', [InvoiceController::class, 'show'])->name('show');
                });

                Route::middleware('permission:invoices.delete')->group(function () {
                    Route::delete('{invoice}', [InvoiceController::class, 'destroy'])->name('destroy');
                });
            });

        // ═══════════════════════════════════════════════════════
        // ═══ Expenses ═══
        // ═══════════════════════════════════════════════════════
        Route::prefix('expenses')
            ->name('expenses.')
            ->group(function () {

                Route::middleware('permission:expenses.view')->group(function () {
                    Route::get('/', [EmployeeExpensesController::class, 'index'])->name('index');
                });

                Route::middleware('permission:expenses.create')->group(function () {
                    Route::get('create', [EmployeeExpensesController::class, 'create'])->name('create');
                    Route::post('/', [EmployeeExpensesController::class, 'store'])->name('store');
                });

                Route::middleware('permission:expenses.edit')->group(function () {
                    Route::get('{expense}/edit', [EmployeeExpensesController::class, 'edit'])->name('edit');
                    Route::put('{expense}', [EmployeeExpensesController::class, 'update'])->name('update');
                });

                Route::middleware('permission:expenses.view')->group(function () {
                    Route::get('{expense}', [EmployeeExpensesController::class, 'show'])->name('show');
                });

                Route::middleware('permission:expenses.delete')->group(function () {
                    Route::delete('{expense}', [EmployeeExpensesController::class, 'destroy'])->name('destroy');
                });
            });

    });   