<?php

namespace App\Http\Controllers;

use App\Models\FaceVerification;
use Illuminate\Http\Request;

class FaceVerificationController extends Controller
{
    /**
     * Display face verification page.
     */
    public function show(Request $request)
    {
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
        | CEK FACE PROFILE
        |--------------------------------------------------------------------------
        */

        if (!$user->faceProfile) {
            return redirect()->route('face.registration');
        }

        /*
        |--------------------------------------------------------------------------
        | TENTUKAN JENIS VERIFIKASI
        |--------------------------------------------------------------------------
        */

        $verificationType = $request->query('type', 'login');

        if (!in_array($verificationType, ['login', 'transaction'])) {
            $verificationType = 'login';
        }

        /*
        |--------------------------------------------------------------------------
        | VERIFIKASI LOGIN
        |--------------------------------------------------------------------------
        */

        if ($verificationType === 'login' && session('otp_verified') !== true) {
            return redirect()->route('login');
        }

        /*
        |--------------------------------------------------------------------------
        | LOGIN SUDAH VERIFIED
        |--------------------------------------------------------------------------
        */

        if ($verificationType === 'login' && session('face_verified') === true) {
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }
            return redirect()->route('dashboard');
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
            'face_liveness_type' => $verificationType,
        ]);

        /*
        |--------------------------------------------------------------------------
        | TAMPILKAN HALAMAN FACE VERIFICATION
        |--------------------------------------------------------------------------
        */

        return view('auth.face-verification');
    }

    /**
     * Verify submitted face embedding.
     */
    public function verify(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | VALIDASI
        |--------------------------------------------------------------------------
        */

        $request->validate([
            'face_embedding' => ['required', 'array', 'size:128'],
            'face_embedding.*' => ['numeric'], // Harus dipastikan numeric
            'liveness_passed' => ['required', 'boolean'],
            'liveness_sequence' => ['required', 'array', 'size:3'],
        ]);

        /*
        |--------------------------------------------------------------------------
        | CEK LOGIN
        |--------------------------------------------------------------------------
        */

        if (!auth()->check()) {
            return response()->json([
                'success' => false,
                'message' => 'Sesi login tidak ditemukan.',
            ], 401);
        }

        $user = auth()->user();

        /*
        |--------------------------------------------------------------------------
        | AMBIL JENIS VERIFIKASI DARI SESSION
        |--------------------------------------------------------------------------
        */

        $verificationType = session('face_liveness_type', 'login');

        if (!in_array($verificationType, ['login', 'transaction'])) {
            $verificationType = 'login';
        }

        /*
        |--------------------------------------------------------------------------
        | CEK OTP HANYA UNTUK LOGIN
        |--------------------------------------------------------------------------
        */

        if ($verificationType === 'login' && session('otp_verified') !== true) {
            return response()->json([
                'success' => false,
                'message' => 'OTP belum diverifikasi.',
            ], 403);
        }

        /*
        |--------------------------------------------------------------------------
        | CEK FACE PROFILE
        |--------------------------------------------------------------------------
        */

        if (!$user->faceProfile) {
            return response()->json([
                'success' => false,
                'message' => 'Wajah Anda belum terdaftar.',
            ], 422);
        }

        /*
        |--------------------------------------------------------------------------
        | CEK LIVENESS (Dari Server Logic)
        |--------------------------------------------------------------------------
        */

        if (!$request->boolean('liveness_passed')) {
            $this->logFailedVerification($user, $verificationType, null);
            return response()->json([
                'success' => false,
                'message' => 'Liveness detection gagal.',
            ], 422);
        }

        /*
        |--------------------------------------------------------------------------
        | CEK RANDOM CHALLENGE
        |--------------------------------------------------------------------------
        */

        $sessionChallenge = session('face_liveness_challenge');
        $submittedChallenge = $request->input('liveness_sequence');

        if (!is_array($sessionChallenge) || count($sessionChallenge) !== 3) {
            return response()->json([
                'success' => false,
                'message' => 'Liveness challenge tidak ditemukan. Silakan ulangi.',
            ], 422);
        }

        if (!is_array($submittedChallenge) || count($submittedChallenge) !== 3 || $submittedChallenge !== $sessionChallenge) {
            $this->logFailedVerification($user, $verificationType, null);
            return response()->json([
                'success' => false,
                'message' => 'Urutan liveness tidak sesuai dengan challenge.',
            ], 422);
        }

        /*
        |--------------------------------------------------------------------------
        | AMBIL FACE EMBEDDING TERDAFTAR
        |--------------------------------------------------------------------------
        */

        $registeredEmbedding = json_decode($user->faceProfile->face_embedding, true);
        $currentEmbedding = $request->face_embedding;

        /*
        |--------------------------------------------------------------------------
        | VALIDASI EMBEDDING KAMERA & REPLAY ATTACK CHECK
        |--------------------------------------------------------------------------
        */

        if (!is_array($registeredEmbedding) || count($registeredEmbedding) !== 128) {
            return response()->json([
                'success' => false,
                'message' => 'Data wajah terdaftar korup/tidak valid.',
            ], 500);
        }

        foreach ($currentEmbedding as $val) {
            if (is_nan($val) || is_infinite($val)) {
                $this->logFailedVerification($user, $verificationType, null);
                return response()->json([
                    'success' => false,
                    'message' => 'Data input wajah tidak valid.',
                ], 422);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | EUCLIDEAN DISTANCE
        |--------------------------------------------------------------------------
        */

        $sum = 0;
        for ($i = 0; $i < 128; $i++) {
            $difference = $currentEmbedding[$i] - $registeredEmbedding[$i];
            $sum += $difference * $difference;
        }

        $distance = sqrt($sum);

        /*
        |--------------------------------------------------------------------------
        | REPLAY ATTACK DETECTION (Distance persis 0.0)
        |--------------------------------------------------------------------------
        | Mustahil bagi model AI untuk menangkap foto 2 kali dari kamera dengan
        | pixel yang menghasilkan descriptor matrix identik secara mikroskopis.
        | Jika distance == 0, pasti Request HTTP dimanipulasi dengan array statis.
        */

        if ($distance == 0.0) {
            $this->logFailedVerification($user, $verificationType, $distance);
            return response()->json([
                'success' => false,
                'message' => 'Pola request mencurigakan (Replay Attack).',
            ], 422);
        }

        /*
        |--------------------------------------------------------------------------
        | THRESHOLD KETAT
        |--------------------------------------------------------------------------
        | Diubah dari 0.60 menjadi 0.45 untuk mencegah False Acceptance (wajah orang lain lolos).
        */

        $threshold = 0.45;

        /*
        |--------------------------------------------------------------------------
        | WAJAH TIDAK COCOK
        |--------------------------------------------------------------------------
        */

        if ($distance > $threshold) {
            $this->logFailedVerification($user, $verificationType, $distance);

            return response()->json([
                'success' => false,
                'message' => 'Wajah tidak cocok dengan identitas terdaftar.',
                'distance' => round($distance, 4),
            ], 422);
        }

        /*
        |--------------------------------------------------------------------------
        | SIMPAN HASIL VERIFIKASI BERHASIL
        |--------------------------------------------------------------------------
        */

        FaceVerification::create([
            'user_id' => $user->id,
            'face_profile_id' => $user->faceProfile->id,
            'verification_type' => $verificationType,
            'liveness_passed' => true,
            'face_matched' => true,
            'distance' => $distance,
            'status' => 'success',
            'verified_at' => now(),
        ]);

        /*
        |--------------------------------------------------------------------------
        | HAPUS RANDOM CHALLENGE
        |--------------------------------------------------------------------------
        */

        session()->forget(['face_liveness_challenge', 'face_liveness_type']);

        /*
        |--------------------------------------------------------------------------
        | LOGIN / TRANSACTION REDIRECT ROUTING
        |--------------------------------------------------------------------------
        */

        if ($verificationType === 'login') {
            session([
                'face_verified' => true,
                'face_verified_at' => now()->timestamp,
            ]);

            $redirect = $user->role === 'admin'
                ? route('admin.dashboard')
                : route('dashboard');
        } else {
            session([
                'transaction_face_verified' => true,
                'transaction_face_verified_at' => now()->timestamp,
            ]);

            $redirectRoute = session('face_verification_redirect', 'transactions.create');
            session()->forget('face_verification_redirect');

            $redirect = route($redirectRoute);
        }

        return response()->json([
            'success' => true,
            'message' => 'Verifikasi wajah berhasil.',
            'redirect' => $redirect,
            'distance' => round($distance, 4),
        ]);
    }

    /**
     * Helper untuk log gagal agar lebih bersih.
     */
    private function logFailedVerification($user, $verificationType, $distance)
    {
        FaceVerification::create([
            'user_id' => $user->id,
            'face_profile_id' => $user->faceProfile->id,
            'verification_type' => $verificationType,
            'liveness_passed' => ($distance !== null), // true jika masuk blok distance > threshold
            'face_matched' => false,
            'distance' => $distance,
            'status' => 'failed',
            'verified_at' => now(),
        ]);
    }
}