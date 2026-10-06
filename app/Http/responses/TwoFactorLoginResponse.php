<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\TwoFactorLoginResponse as TwoFactorLoginResponseContract;

class TwoFactorLoginResponse implements TwoFactorLoginResponseContract
{
    /**
     * Handle successful two-factor authentication.
     */
    public function toResponse($request)
    {
        $user = $request->user();

        /*
        |--------------------------------------------------------------------------
        | OTP BERHASIL
        |--------------------------------------------------------------------------
        */

        session([
            'otp_verified' => true,
        ]);

        /*
        |--------------------------------------------------------------------------
        | RESET FACE VERIFICATION
        |--------------------------------------------------------------------------
        |
        | Setiap login baru harus melakukan verifikasi wajah lagi.
        |
        */

        session()->forget([
            'face_verified',
            'face_verified_at',
        ]);

        /*
        |--------------------------------------------------------------------------
        | BELUM ADA FACE PROFILE
        |--------------------------------------------------------------------------
        |
        | User sudah lolos OTP tetapi belum pernah mendaftarkan
        | wajahnya.
        |
        */

        if (!$user || !$user->faceProfile) {

            return redirect()->route(
                'face.registration'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | SUDAH ADA FACE PROFILE
        |--------------------------------------------------------------------------
        |
        | User tinggal melakukan face verification.
        |
        */

        return redirect()->route(
            'face.verification'
        );
    }
}