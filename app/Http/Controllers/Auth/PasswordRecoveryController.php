<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PasswordRecoveryController extends Controller
{
    /**
     * Menampilkan form masukkan email.
     */
    public function showEmailForm()
    {
        return view('auth.forgot-password');
    }

    /**
     * Menampilkan pertanyaan keamanan.
     */
    public function showSecurityQuestion(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $user = User::where('email', strtolower($request->email))->first();

        if (!$user) {
            return back()->withErrors([
                'email' => 'Email tidak ditemukan.',
            ])->withInput();
        }

        if (!$user->security_question) {
            return back()->withErrors([
                'email' => 'Akun ini belum memiliki pertanyaan keamanan.',
            ])->withInput();
        }

        session([
            'password_recovery_user_id' => $user->id,
        ]);

        return view('auth.security-question', [
            'securityQuestion' => $user->security_question,
        ]);
    }

    /**
     * Memeriksa jawaban keamanan.
     */
    public function verifyAnswer(Request $request)
    {
        $request->validate([
            'security_answer' => ['required', 'string'],
        ]);

        $userId = session('password_recovery_user_id');

        if (!$userId) {
            return redirect()
                ->route('password.request')
                ->withErrors([
                    'email' => 'Sesi pemulihan password telah berakhir.',
                ]);
        }

        $user = User::find($userId);

        if (!$user || !Hash::check($request->security_answer, $user->security_answer)) {
            return back()->withErrors([
                'security_answer' => 'Jawaban keamanan salah.',
            ]);
        }

        session([
            'password_recovery_verified' => true,
        ]);

        return view('auth.reset-password');
    }

    /**
     * Mengubah password setelah jawaban keamanan benar.
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        if (session('password_recovery_verified') !== true) {
            return redirect()
                ->route('password.request')
                ->withErrors([
                    'email' => 'Silakan ulangi proses pemulihan password.',
                ]);
        }

        $userId = session('password_recovery_user_id');

        $user = User::find($userId);

        if (!$user) {
            return redirect()
                ->route('password.request')
                ->withErrors([
                    'email' => 'Akun tidak ditemukan.',
                ]);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        session()->forget([
            'password_recovery_user_id',
            'password_recovery_verified',
        ]);

        return redirect()
            ->route('login')
            ->with('status', 'Password berhasil diubah. Silakan login dengan password baru.');
    }
}