<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AdminLogoutController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\InvoiceController;
use App\Http\Controllers\Dashboard\OrdersController;
use App\Http\Controllers\Dashboard\MenuItemController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Dashboard\RoleController;

/*
|--------------------------------------------------------------------------
| Admin Logout
|--------------------------------------------------------------------------
*/

Route::post('/admin/logout', AdminLogoutController::class)
    ->middleware('auth:admin')
    ->name('admin.logout');

/*
|--------------------------------------------------------------------------
| Admin Routes (محمية بـ auth:admin)
|--------------------------------------------------------------------------
*/
Route::middleware('auth:admin')
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Dashboard
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        // Orders
        Route::prefix('orders')->name('orders.')->group(function () {
            Route::get('/', [OrdersController::class, 'index'])->name('index');
            Route::get('/create', [OrdersController::class, 'create'])->name('create');
            Route::post('/', [OrdersController::class, 'store'])->name('store');
            Route::get('/{id}', [OrdersController::class, 'show'])->name('show');
            Route::get('/{id}/edit', [OrdersController::class, 'edit'])->name('edit');
            Route::put('/{id}', [OrdersController::class, 'update'])->name('update');
            Route::delete('/{id}', [OrdersController::class, 'destroy'])->name('destroy');
        });

        // Profile
        Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
        Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
        Route::post('user/two-factor-authentication', [ProfileController::class, 'enableTwoFactor'])
            ->name('two-factor.enable');
        Route::delete('user/two-factor-authentication', [ProfileController::class, 'disableTwoFactor'])
            ->name('two-factor.disable');
        // 2FA Confirm Page
        Route::get('profile/2fa/confirm', function () {
            return view('admin.auth.confirm-password');
        })->name('profile.2fa.confirm');      
        
        // Menu Items
        Route::resource('menu-items', MenuItemController::class);

        // Expenses
        Route::get('expenses', fn() => view('admin.expenses.index'))->name('expenses.index');

        Route::resource('invoices', InvoiceController::class)
            ->except(['create', 'store']);

        //Roles
        Route::prefix('roles')->name('roles.')->group(function () {
            Route::get('/', [RoleController::class, 'index'])->name('index');
            Route::get('/create', [RoleController::class, 'create'])->name('create');
            Route::post('/', [RoleController::class, 'store'])->name('store');
            Route::get('/{id}', [RoleController::class, 'show'])->name('show');
            Route::get('/{id}/edit', [RoleController::class, 'edit'])->name('edit');
            Route::put('/{id}', [RoleController::class, 'update'])->name('update');
            Route::delete('/{id}', [RoleController::class, 'destroy'])->name('destroy');
        });
    });
