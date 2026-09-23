<?php

use Illuminate\Support\Facades\Route;

// ═══ Home Redirect ═══
Route::get('/', function () {
    if (auth('admin')->check()) {
        return redirect()->route('admin.dashboard');
    }
    if (auth('web')->check()) {
        return redirect()->route('employee.dashboard');   
    }
    return redirect('/employee/login');
});

// ═══ Routes Files ═══
require __DIR__ . '/dashboard.php';
require __DIR__ . '/employee.php';