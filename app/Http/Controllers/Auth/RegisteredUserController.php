<?php

namespace App\Http\Controllers\Auth;

use App\Actions\Fortify\CreateNewUser;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request, CreateNewUser $creator): RedirectResponse
    {
        /*
        |--------------------------------------------------------------------------
        | Normalisasi email
        |--------------------------------------------------------------------------
        */

        $request->merge([
            'email' => strtolower(trim((string) $request->email)),
        ]);

        /*
        |--------------------------------------------------------------------------
        | Buat user baru
        |--------------------------------------------------------------------------
        |
        | Validasi & penyimpanan (termasuk 3 pertanyaan pemulihan
        | yang jawabannya di-hash) ditangani CreateNewUser.
        |
        | Semua akun yang melakukan registrasi otomatis menjadi USER.
        | Admin tidak dibuat melalui halaman registrasi.
        |
        */

        $user = $creator->create(
            $request->only([
                'name',
                'email',
                'password',
                'password_confirmation',
                'recovery_question_1',
                'recovery_answer_1',
                'recovery_question_2',
                'recovery_answer_2',
                'recovery_question_3',
                'recovery_answer_3',
            ])
        );

        event(new Registered($user));

        /*
        |--------------------------------------------------------------------------
        | Setelah registrasi
        |--------------------------------------------------------------------------
        |
        | User di-login HANYA agar bisa mengakses halaman setup MFA.
        | Dashboard & fitur transaksi tetap terkunci sampai:
        |
        | QR Authenticator + OTP terkonfirmasi
        |   ↓
        | Registrasi wajah
        |   ↓
        | Verifikasi wajah
        |
        */

        Auth::login($user);

        $request->session()->regenerate();

        return redirect()
            ->route('mfa.setup')
            ->with(
                'status',
                'Registrasi berhasil. Pindai QR code dengan aplikasi authenticator, lalu masukkan kode OTP.'
            );
    }
}