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
        | PASTIKAN USER DITEMUKAN
        |--------------------------------------------------------------------------
        */

        if (!$user) {
            return redirect()->route('login');
        }

        /*
        |--------------------------------------------------------------------------
        | OTP BERHASIL
        |--------------------------------------------------------------------------
        | Session ini menandakan bahwa pengguna telah melewati
        | proses verifikasi OTP pada login saat ini.
        */

        session([
            'otp_verified' => true,
        ]);

        /*
        |--------------------------------------------------------------------------
        | RESET STATUS VERIFIKASI WAJAH SEBELUMNYA
        |--------------------------------------------------------------------------
        | Login baru harus melakukan verifikasi wajah kembali.
        */

        session()->forget([
            'face_verified',
            'face_verified_at',
            'transaction_face_verified',
            'transaction_face_verified_at',
            'face_verification_redirect',
            'face_liveness_challenge',
            'face_liveness_type',
            'face_liveness_challenge_created_at',
        ]);

        /*
        |--------------------------------------------------------------------------
        | BELUM ADA FACE PROFILE
        |--------------------------------------------------------------------------
        | Pengguna diarahkan untuk mendaftarkan wajah.
        */

        if (!$user->faceProfile) {
            return redirect()->route('face.registration');
        }

        /*
        |--------------------------------------------------------------------------
        | SUDAH ADA FACE PROFILE
        |--------------------------------------------------------------------------
        | Pengguna melakukan verifikasi wajah sebelum masuk dashboard.
        */

        return redirect()->route('face.verification');
    }
}
