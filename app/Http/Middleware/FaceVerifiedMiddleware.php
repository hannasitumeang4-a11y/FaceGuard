<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FaceVerifiedMiddleware
{
    public function handle(
        Request $request,
        Closure $next
    ): Response {

        /*
        |--------------------------------------------------------------------------
        | HARUS LOGIN
        |--------------------------------------------------------------------------
        */

        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        /*
        |--------------------------------------------------------------------------
        | FACE SUDAH DIVERIFIKASI
        |--------------------------------------------------------------------------
        |
        | Kalau pada sesi login sekarang wajah sudah diverifikasi,
        | izinkan user masuk ke halaman yang dilindungi.
        |
        */

        if (session('face_verified') === true) {
            return $next($request);
        }

        /*
        |--------------------------------------------------------------------------
        | BELUM ADA FACE PROFILE
        |--------------------------------------------------------------------------
        |
        | User belum mempunyai data wajah.
        | Arahkan ke registrasi wajah.
        |
        */

        if (!$user->faceProfile) {
            return redirect()->route('face.registration');
        }

        /*
        |--------------------------------------------------------------------------
        | SUDAH ADA FACE PROFILE
        |--------------------------------------------------------------------------
        |
        | User sudah mempunyai wajah, tetapi belum melakukan
        | verifikasi wajah pada sesi login sekarang.
        |
        */

        return redirect()->route('face.verification');
    }
}