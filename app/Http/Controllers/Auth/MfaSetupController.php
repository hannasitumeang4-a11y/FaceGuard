<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Fortify\Actions\EnableTwoFactorAuthentication;

class MfaSetupController extends Controller
{
    /**
     * Display MFA setup page.
     */
    public function show(Request $request)
    {
        $user = $request->user();

        /*
        |--------------------------------------------------------------------------
        | CEK LOGIN
        |--------------------------------------------------------------------------
        */

        if (!$user) {
            return redirect()->route('login');
        }

        /*
        |--------------------------------------------------------------------------
        | MFA SUDAH AKTIF
        |--------------------------------------------------------------------------
        |
        | Kalau MFA sudah aktif, jangan membuat QR baru.
        |
        | Selanjutnya:
        |
        | Belum punya wajah
        |       ↓
        | Face Registration
        |
        | Sudah punya wajah
        |       ↓
        | Face Verification
        |
        */

        if ($user->hasEnabledTwoFactorAuthentication()) {

            if (!$user->faceProfile) {

                return redirect()->route(
                    'face.registration'
                );
            }

            return redirect()->route(
                'face.verification'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | GENERATE MFA SECRET
        |--------------------------------------------------------------------------
        |
        | Kalau belum mempunyai secret, generate MFA.
        |
        */

        if (empty($user->two_factor_secret)) {

            app(
                EnableTwoFactorAuthentication::class
            )($user);

            $user->refresh();
        }

        /*
        |--------------------------------------------------------------------------
        | TAMPILKAN QR CODE
        |--------------------------------------------------------------------------
        */

        return view(
            'auth.mfa-setup',
            [
                'user' => $user,
            ]
        );
    }
}