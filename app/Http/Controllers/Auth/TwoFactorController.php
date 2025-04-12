<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Notifications\TwoFactorCodeNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TwoFactorController extends Controller
{
    public function show()
    {
        return view('auth.two-factor');
    }

    public function verify(Request $request)
    {
        $request->validate([
            'code' => 'required|numeric|digits:6',
        ]);

        $user = Auth::user();

        if ($request->code == $user->two_factor_code) {
            if (now()->lt($user->two_factor_expires_at)) {
                $user->resetTwoFactorCode();
                return redirect()->intended(route('dashboard'));
            }

            $user->resetTwoFactorCode();
            Auth::logout();
            return redirect()->route('login')
                ->withErrors(['code' => 'The verification code has expired. Please login again.']);
        }

        return redirect()->back()
            ->withErrors(['code' => 'The verification code you entered is invalid.']);
    }

    public function resend()
    {
        $user = Auth::user();

        $user->resetTwoFactorCode();
        $user->sendTwoFactorCode();

        return redirect()->back()
            ->with('status', 'A new verification code has been sent to your email.');
    }
}
