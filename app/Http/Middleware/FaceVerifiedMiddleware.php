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
        | CEK LOGIN
        |--------------------------------------------------------------------------
        */

        if (! auth()->check()) {

            return redirect()->route('login');

        }


        /*
        |--------------------------------------------------------------------------
        | CEK FACE VERIFICATION
        |--------------------------------------------------------------------------
        */

        if (! session('face_verified')) {

            /*
            | Jika belum punya wajah,
            | arahkan ke registrasi.
            */

            if (! auth()->user()->faceProfile) {

                return redirect()->route(
                    'face.registration'
                );
            }


            /*
            | Jika sudah punya wajah,
            | arahkan ke verifikasi.
            */

            return redirect()->route(
                'face.verification'
            );
        }


        return $next($request);
    }
}