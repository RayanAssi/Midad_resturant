<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function show()
    {
        // $user = Auth::user();
        // return view('profile.show', compact('user'));
        // المدير
        if (auth('admin')->check()) {
            return view('admin.profile.show', [
                'user' => auth('admin')->user(),
            ]);
        }

        // الكاشير
        if (auth('web')->check()) {
            return view('cashier.profile.show', [
                'user' => auth('web')->user(),
            ]);
        }

        abort(403);
    }
}
