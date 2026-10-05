<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Laravel\Fortify\Actions\EnableTwoFactorAuthentication;

class MfaSetupController extends Controller
{
    public function show(Request $request)
    {
        $user = $request->user();


        /*
        |--------------------------------------------------------------------------
        | Kalau MFA sudah aktif
        |--------------------------------------------------------------------------
        |
        | Jangan tampilkan QR lagi.
        | Langsung ke dashboard.
        |
        */

        if (
            $user->hasEnabledTwoFactorAuthentication()
        ) {

            if ($user->role === 'admin') {
                return redirect()->route(
                    'admin.dashboard'
                );
            }

            return redirect()->route(
                'dashboard'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Kalau belum punya secret
        |--------------------------------------------------------------------------
        |
        | Buat QR Code MFA.
        |
        */

        if (empty($user->two_factor_secret)) {

            app(
                EnableTwoFactorAuthentication::class
            )($user);

            $user->refresh();
        }


        return view(
            'auth.mfa-setup',
            [
                'user' => $user,
            ]
        );
    }
}