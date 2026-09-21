<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

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
            return view('employee.profile.show', [
                'user' => auth('web')->user(),
            ]);
        }

        abort(403);
    }
    public function updatePassword(Request $request)
    {
        $guard = auth('admin')->check() ? 'admin' : 'web';
        $user = auth($guard)->user();

        try {
            $validated = $request->validate([
                'current_password' => ['required', 'current_password:' . $guard],
                'password'         => ['required', 'confirmed', Password::defaults()],
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()
                ->with('error', $e->validator->errors()->first())
                ->withErrors($e->validator)
                ->withInput();
        }

        $user->password = Hash::make($validated['password']);
        $user->save();

        return back()->with('success', 'Password updated successfully.');
    }

    public function enableTwoFactor(Request $request)
    {
        $request->validate([
            'password' => ['required', 'current_password:admin'],
        ]);

        /** @var \App\Models\User $user */
        $user = auth('admin')->user();
        app(\Laravel\Fortify\Actions\EnableTwoFactorAuthentication::class)($user);

        return redirect()
            ->route('admin.profile.show')
            ->with('success', 'Two-Factor authentication enabled.');
    }

    public function disableTwoFactor(Request $request)
    {
        $request->validate([
            'password' => ['required', 'current_password:admin'],
        ]);

        /** @var \App\Models\User $user */
        $user = auth('admin')->user();
        app(\Laravel\Fortify\Actions\DisableTwoFactorAuthentication::class)($user);

        return redirect()
            ->route('admin.profile.show')
            ->with('success', 'Two-Factor authentication disabled.');
    }
}
