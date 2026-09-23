<?php

use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => [
        'localeSessionRedirect',
        'localizationRedirect',
        'localeViewPath',
    ],
], function () {

    // ═══ main routes ═══
    Route::get('/', function () {
        if (auth('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }
        if (auth('web')->check()) {
            return redirect()->route('employee.dashboard');
        }
        return redirect('/employee/login');
    })->name('home');

    // ═══ switching locales ═══
    Route::get('/locale/{locale}', function ($locale) {
        if (array_key_exists($locale, config('laravellocalization.supportedLocales'))) {
            session(['locale' => $locale]);
            app()->setLocale($locale);
        }
        return redirect()->back();
    })->name('locale.switch');

    require __DIR__ . '/dashboard.php';
    require __DIR__ . '/employee.php';
});
