<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AdminLogoutController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\InvoiceController;
use App\Http\Controllers\Dashboard\OrdersController;
use App\Http\Controllers\Dashboard\MenuItemController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Dashboard\RoleController;
use App\Http\Controllers\Dashboard\ExpensesController;
use App\Http\Controllers\Dashboard\TranslationController;

/*
|--------------------------------------------------------------------------
| Admin Logout
|--------------------------------------------------------------------------
*/

Route::post('/admin/logout', AdminLogoutController::class)
    ->middleware('auth:admin')
    ->name('admin.logout');

/*
Admin Routes
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
        Route::get('profile/2fa/confirm', function () {
            return view('admin.auth.confirm-password');
        })->name('profile.2fa.confirm');

        // Menu Items
        Route::resource('menu-items', MenuItemController::class);

        // Expenses — خارج roles، مباشرة جوّا admin
        Route::prefix('expenses')
            ->name('expenses.')
            ->group(function () {
                Route::get('/', [ExpensesController::class, 'index'])->name('index');
                Route::get('create', [ExpensesController::class, 'create'])->name('create');
                Route::post('/', [ExpensesController::class, 'store'])->name('store');
                Route::get('{expense}', [ExpensesController::class, 'show'])->name('show');
                Route::get('{expense}/edit', [ExpensesController::class, 'edit'])->name('edit');
                Route::put('{expense}', [ExpensesController::class, 'update'])->name('update');
                Route::delete('{expense}', [ExpensesController::class, 'destroy'])->name('destroy');
            });

        // Invoices
        Route::resource('invoices', InvoiceController::class);

        // Roles — لحالها بدون expenses
        Route::prefix('roles')->name('roles.')->group(function () {
            Route::get('/', [RoleController::class, 'index'])->name('index');
            Route::get('/create', [RoleController::class, 'create'])->name('create');
            Route::post('/', [RoleController::class, 'store'])->name('store');
            Route::get('/{id}', [RoleController::class, 'show'])->name('show');
            Route::get('/{id}/edit', [RoleController::class, 'edit'])->name('edit');
            Route::put('/{id}', [RoleController::class, 'update'])->name('update');
            Route::delete('/{id}', [RoleController::class, 'destroy'])->name('destroy');
        });

        // Translations
        Route::match(['post', 'put'], '/translate/{group}/{field}', [TranslationController::class, 'translate'])
            ->name('translations.translate')
            ->where(['group' => '[a-z_]+', 'field' => '[a-z_]+']);

        Route::post('translations/update/{group}/{field}', [TranslationController::class, 'update'])
            ->name('translations.update')
            ->where(['group' => '[a-z_]+', 'field' => '[a-z_]+']);

        Route::post('translations/destroy/{group}/{field}', [TranslationController::class, 'destroy'])
            ->name('translations.destroy')
            ->where(['group' => '[a-z_]+', 'field' => '[a-z_]+']);
    });
