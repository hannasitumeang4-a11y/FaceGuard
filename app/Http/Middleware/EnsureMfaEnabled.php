<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureMfaEnabled
{
    /**
     * User wajib mengonfirmasi authenticator sebelum
     * membuka registrasi wajah, verifikasi wajah,
     * dashboard, dan fitur transaksi.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // Halaman setup MFA harus tetap dapat diakses
        // agar pengguna bisa mengaktifkan dan mengonfirmasi MFA.
        if ($request->routeIs('mfa.setup')) {
            return $next($request);
        }

        // Jika belum login, biarkan middleware auth menangani.
        if (!$user) {
            return $next($request);
        }

        // MFA belum dikonfirmasi.
        if (is_null($user->two_factor_confirmed_at)) {
            return redirect()
                ->route('mfa.setup')
                ->with(
                    'status',
                    'Aktifkan dan konfirmasi authenticator terlebih dahulu.'
                );
        }

        return $next($request);
    }
}
