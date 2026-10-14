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

        // Pengguna wajib login.
        if (!$user) {
            return redirect()->route('login');
        }

        // MFA sudah dikonfirmasi.
        // Jangan membuat QR baru.
        if (!is_null($user->two_factor_confirmed_at)) {
            if (!$user->faceProfile) {
                return redirect()->route('face.registration');
            }

            return redirect()->route('face.verification');
        }

        // Buat secret MFA hanya jika belum ada.
        // Jika secret sudah ada tetapi belum dikonfirmasi,
        // pertahankan secret tersebut untuk proses setup.
        if (empty($user->two_factor_secret)) {
            app(EnableTwoFactorAuthentication::class)($user);

            $user->refresh();
        }

        // Tampilkan halaman setup untuk memindai QR
        // dan menyelesaikan konfirmasi MFA.
        return view('auth.mfa-setup', [
            'user' => $user,
        ]);
    }
}
