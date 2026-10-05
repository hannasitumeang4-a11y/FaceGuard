<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\TwoFactorLoginResponse as TwoFactorLoginResponseContract;

class TwoFactorLoginResponse implements TwoFactorLoginResponseContract
{
    /**
     * Response setelah OTP berhasil.
     */
    public function toResponse($request)
    {
        $user = $request->user();

        /*
        |--------------------------------------------------------------------------
        | WAJIB REGISTRASI WAJAH
        |--------------------------------------------------------------------------
        |
        | Jika user belum memiliki face profile,
        | arahkan ke registrasi wajah terlebih dahulu.
        |
        */

        if ($user && ! $user->faceProfile) {

            return redirect()->route(
                'face.registration'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | WAJIB VERIFIKASI WAJAH
        |--------------------------------------------------------------------------
        |
        | Jika wajah sudah terdaftar,
        | user TIDAK boleh langsung masuk dashboard.
        |
        */

        return redirect()->route(
            'face.verification'
        );
    }
}