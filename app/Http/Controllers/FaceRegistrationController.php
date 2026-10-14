<?php

namespace App\Http\Controllers;

use App\Models\FaceProfile;
use App\Models\FaceVerification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FaceRegistrationController extends Controller
{
    public function show()
    {
        $user = auth()->user();

        /*
        |--------------------------------------------------------------------------
        | BELUM LOGIN
        |--------------------------------------------------------------------------
        */

        if (!$user) {
            return redirect()->route('login');
        }

        /*
        |--------------------------------------------------------------------------
        | OTP HARUS SUDAH DIVERIFIKASI
        |--------------------------------------------------------------------------
        */

        if (session('otp_verified') !== true) {
            return redirect()->route('login');
        }

        /*
        |--------------------------------------------------------------------------
        | WAJAH SUDAH ADA
        |--------------------------------------------------------------------------
        */

        if ($user->faceProfile) {
            if (session('face_verified') === true) {
                if ($user->role === 'admin') {
                    return redirect()->route('admin.dashboard');
                }

                return redirect()->route('dashboard');
            }

            return redirect()->route('face.verification');
        }

        /*
        |--------------------------------------------------------------------------
        | BUAT RANDOM LIVENESS CHALLENGE
        |--------------------------------------------------------------------------
        */

        $challenge = ['blink', 'left', 'right'];
        shuffle($challenge);

        /*
        |--------------------------------------------------------------------------
        | SIMPAN CHALLENGE KE SESSION
        |--------------------------------------------------------------------------
        */

        session([
            'face_liveness_challenge' => $challenge,
            'face_liveness_type' => 'registration',
            'face_liveness_challenge_created_at' => now()->timestamp,
        ]);

        /*
        |--------------------------------------------------------------------------
        | TAMPILKAN REGISTRASI WAJAH
        |--------------------------------------------------------------------------
        */

        return view('auth.face-registration');
    }

    public function store(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | USER HARUS LOGIN
        |--------------------------------------------------------------------------
        */

        $user = auth()->user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Sesi login tidak ditemukan.',
            ], 401);
        }

        /*
        |--------------------------------------------------------------------------
        | OTP HARUS SUDAH DIVERIFIKASI
        |--------------------------------------------------------------------------
        */

        if (session('otp_verified') !== true) {
            return response()->json([
                'success' => false,
                'message' => 'Silakan lakukan verifikasi OTP terlebih dahulu.',
            ], 403);
        }

        /*
        |--------------------------------------------------------------------------
        | CEK APAKAH WAJAH SUDAH ADA
        |--------------------------------------------------------------------------
        */

        if ($user->faceProfile) {
            return response()->json([
                'success' => false,
                'message' => 'Wajah Anda sudah terdaftar.',
            ], 422);
        }

        /*
        |--------------------------------------------------------------------------
        | VALIDASI INPUT
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([
            'face_embedding' => ['required', 'array', 'size:128'],
            'face_embedding.*' => ['required', 'numeric'],
            'liveness_passed' => ['required', 'boolean'],
            'liveness_sequence' => ['required', 'array', 'size:3'],
            'liveness_sequence.*' => [
                'required',
                'string',
                'in:blink,left,right',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | CEK LIVENESS
        |--------------------------------------------------------------------------
        */

        if (!$request->boolean('liveness_passed')) {
            return response()->json([
                'success' => false,
                'message' => 'Liveness detection gagal.',
            ], 422);
        }

        /*
        |--------------------------------------------------------------------------
        | CEK CHALLENGE SESSION
        |--------------------------------------------------------------------------
        */

        $sessionChallenge = session('face_liveness_challenge');
        $submittedChallenge = $validated['liveness_sequence'];
        $challengeType = session('face_liveness_type');
        $challengeCreatedAt = session(
            'face_liveness_challenge_created_at'
        );

        if (
            !is_array($sessionChallenge) ||
            count($sessionChallenge) !== 3 ||
            $challengeType !== 'registration' ||
            !is_numeric($challengeCreatedAt)
        ) {
            return response()->json([
                'success' => false,
                'message' => 'Liveness challenge tidak ditemukan. Silakan ulangi.',
            ], 422);
        }

        /*
        |--------------------------------------------------------------------------
        | CHALLENGE MEMILIKI BATAS WAKTU
        |--------------------------------------------------------------------------
        */

        $challengeAge = now()->timestamp - (int) $challengeCreatedAt;

        if ($challengeAge < 0 || $challengeAge > 120) {
            session()->forget([
                'face_liveness_challenge',
                'face_liveness_type',
                'face_liveness_challenge_created_at',
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Challenge kedaluwarsa. Silakan ulangi registrasi wajah.',
            ], 422);
        }

        /*
        |--------------------------------------------------------------------------
        | CEK URUTAN CHALLENGE
        |--------------------------------------------------------------------------
        */

        if ($submittedChallenge !== $sessionChallenge) {
            return response()->json([
                'success' => false,
                'message' => 'Urutan liveness tidak sesuai dengan challenge.',
            ], 422);
        }

        /*
        |--------------------------------------------------------------------------
        | AMBIL DAN VALIDASI FACE EMBEDDING
        |--------------------------------------------------------------------------
        */

        $embedding = [];

        foreach ($validated['face_embedding'] as $val) {
            if (!is_numeric($val)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data struktur wajah tidak valid.',
                ], 422);
            }

            $number = (float) $val;

            if (is_nan($number) || is_infinite($number)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data struktur wajah mengandung nilai yang tidak valid.',
                ], 422);
            }

            $embedding[] = $number;
        }

        /*
        |--------------------------------------------------------------------------
        | SIMPAN PROFIL DAN HASIL VERIFIKASI
        |--------------------------------------------------------------------------
        */

        try {
            $faceProfile = DB::transaction(function () use (
                $user,
                $embedding
            ) {
                /*
                | Cegah pembuatan profil ganda jika permintaan dikirim
                | berulang kali atau bersamaan.
                */

                if ($user->faceProfile()->exists()) {
                    throw new \RuntimeException(
                        'Wajah Anda sudah terdaftar.'
                    );
                }

                $faceProfile = FaceProfile::create([
                    'user_id' => $user->id,
                    'face_embedding' => json_encode(
                        $embedding,
                        JSON_THROW_ON_ERROR
                    ),
                ]);

                FaceVerification::create([
                    'user_id' => $user->id,
                    'face_profile_id' => $faceProfile->id,
                    'verification_type' => 'registration',
                    'liveness_passed' => true,
                    'face_matched' => true,
                    'distance' => null,
                    'status' => 'success',
                    'verified_at' => now(),
                ]);

                return $faceProfile;
            });
        } catch (\RuntimeException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        } catch (\Throwable $e) {
            report($e);

            return response()->json([
                'success' => false,
                'message' => 'Registrasi wajah gagal disimpan. Silakan coba kembali.',
            ], 500);
        }

        /*
        |--------------------------------------------------------------------------
        | HAPUS CHALLENGE SETELAH BERHASIL
        |--------------------------------------------------------------------------
        */

        session()->forget([
            'face_liveness_challenge',
            'face_liveness_type',
            'face_liveness_challenge_created_at',
        ]);

        /*
        |--------------------------------------------------------------------------
        | REGISTRASI WAJAH BERHASIL
        |--------------------------------------------------------------------------
        */

        session([
            'face_verified' => true,
            'face_verified_at' => now()->timestamp,
        ]);

        /*
        |--------------------------------------------------------------------------
        | DASHBOARD BERDASARKAN ROLE
        |--------------------------------------------------------------------------
        */

        $redirect = $user->role === 'admin'
            ? route('admin.dashboard')
            : route('dashboard');

        return response()->json([
            'success' => true,
            'message' => 'Wajah berhasil didaftarkan.',
            'redirect' => $redirect,
        ]);
    }
}
