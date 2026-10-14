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
        // Halaman autentikasi wajah dan setup MFA
        // tidak boleh diarahkan kembali oleh middleware ini.
        if ($request->routeIs(
            'mfa.setup',
            'face.registration',
            'face.verification'
        )) {
            return $next($request);
        }

        // Pengguna wajib login.
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = $request->user();

        // Wajah sudah diverifikasi pada sesi login ini.
        if (session('face_verified') === true) {
            return $next($request);
        }

        // Belum mempunyai profil wajah.
        if (!$user->faceProfile) {
            return redirect()->route('face.registration');
        }

        // Profil wajah tersedia, tetapi sesi ini belum diverifikasi.
        return redirect()->route('face.verification');
    }
}
