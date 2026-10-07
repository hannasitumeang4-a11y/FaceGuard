<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class ForgotPasswordController extends Controller
{
    public function showEmailForm()
    {
        return view('auth.forgot-password');
    }

    public function checkEmail(Request $request)
    {
        $request->validate([
            'email' => [
                'required',
                'email',
            ],
        ]);

        $email = strtolower(trim($request->email));

        $user = User::where('email', $email)->first();

        if (!$user) {
            return back()
                ->withInput()
                ->withErrors([
                    'email' => 'Email tidak ditemukan.',
                ]);
        }

        if (
            !$user->recovery_question_1 ||
            !$user->recovery_question_2 ||
            !$user->recovery_question_3 ||
            !$user->recovery_answer_1 ||
            !$user->recovery_answer_2 ||
            !$user->recovery_answer_3
        ) {
            return back()
                ->withInput()
                ->withErrors([
                    'email' => 'Akun ini belum memiliki pertanyaan pemulihan password.',
                ]);
        }

        session([
            'password_recovery_user_id' => $user->id,
        ]);

        return redirect()->route('password.recovery.questions');
    }

    public function showQuestions()
    {
        $userId = session('password_recovery_user_id');

        if (!$userId) {
            return redirect()->route('password.request');
        }

        $user = User::find($userId);

        if (!$user) {
            session()->forget('password_recovery_user_id');

            return redirect()->route('password.request');
        }

        return view('auth.recovery-questions', compact('user'));
    }

    public function verifyQuestions(Request $request)
    {
        $userId = session('password_recovery_user_id');

        if (!$userId) {
            return redirect()->route('password.request');
        }

        $user = User::find($userId);

        if (!$user) {
            session()->forget('password_recovery_user_id');

            return redirect()->route('password.request');
        }

        $request->validate([
            'recovery_answer_1' => [
                'required',
                'string',
            ],

            'recovery_answer_2' => [
                'required',
                'string',
            ],

            'recovery_answer_3' => [
                'required',
                'string',
            ],
        ]);

        $answer1 = strtolower(trim($request->recovery_answer_1));
        $answer2 = strtolower(trim($request->recovery_answer_2));
        $answer3 = strtolower(trim($request->recovery_answer_3));

        $correct1 = Hash::check(
            $answer1,
            $user->recovery_answer_1
        );

        $correct2 = Hash::check(
            $answer2,
            $user->recovery_answer_2
        );

        $correct3 = Hash::check(
            $answer3,
            $user->recovery_answer_3
        );

        if (!$correct1 || !$correct2 || !$correct3) {
            return back()
                ->withErrors([
                    'recovery_answer_1' =>
                        'Jawaban pertanyaan keamanan tidak sesuai.',
                ]);
        }

        session([
            'password_recovery_verified' => true,
        ]);

        return redirect()->route('password.recovery.reset');
    }

    public function showResetForm()
    {
        $userId = session('password_recovery_user_id');
        $verified = session('password_recovery_verified');

        if (!$userId || !$verified) {
            return redirect()->route('password.request');
        }

        return view('auth.reset-password-recovery');
    }

    public function resetPassword(Request $request)
    {
        $userId = session('password_recovery_user_id');
        $verified = session('password_recovery_verified');

        if (!$userId || !$verified) {
            return redirect()->route('password.request');
        }

        $request->validate([
            'password' => [
                'required',
                'string',
                'confirmed',
                Rules\Password::defaults(),
            ],
        ]);

        $user = User::find($userId);

        if (!$user) {
            session()->forget([
                'password_recovery_user_id',
                'password_recovery_verified',
            ]);

            return redirect()->route('password.request')
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
            ->with(
                'status',
                'Password berhasil diubah. Silakan login menggunakan password baru.'
            );
    }
}