<?php

namespace App\Http\Controllers;

use App\Models\FaceVerification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


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

        $verificationType =
            $request->query(
                'type',
                'login'
            );


        if (
            !in_array(
                $verificationType,
                ['login', 'transaction']
            )
        ) {

            $verificationType =
                'login';
        }


        /*
        |--------------------------------------------------------------------------
        | VERIFIKASI LOGIN
        |--------------------------------------------------------------------------
        */

        if (
            $verificationType === 'login'
            &&
            session('otp_verified') !== true
        ) {

            return redirect()->route('login');
        }


        /*
        |--------------------------------------------------------------------------
        | LOGIN SUDAH VERIFIED
        |--------------------------------------------------------------------------
        */

        if (
            $verificationType === 'login'
            &&
            session('face_verified') === true
        ) {

            if ($user->role === 'admin') {
                return redirect()->route(
                    'admin.dashboard'
                );
            }

            return redirect()->route(
                'dashboard'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | BUAT RANDOM LIVENESS CHALLENGE
        |--------------------------------------------------------------------------
        */

        $challenge = [
            'blink',
            'left',
            'right',
        ];

        shuffle($challenge);


        /*
        |--------------------------------------------------------------------------
        | SIMPAN CHALLENGE KE SESSION
        |--------------------------------------------------------------------------
        */

        session([
            'face_liveness_challenge' =>
                $challenge,

            'face_liveness_type' =>
                $verificationType,
        ]);


        /*
        |--------------------------------------------------------------------------
        | TAMPILKAN HALAMAN FACE VERIFICATION
        |--------------------------------------------------------------------------
        */

        return view(
            'auth.face-verification'
        );
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
            'face_embedding' => [
                'required',
                'array',
                'size:128',
            ],

            'liveness_passed' => [
                'required',
                'boolean',
            ],

            'liveness_mode' => [
                'nullable',
                'in:active,passive',
            ],

            'liveness_sequence' => [
                'nullable',
                'array',
                'size:3',
            ],

            'spoof_suspected' => [
                'nullable',
                'boolean',
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | CEK LOGIN
        |--------------------------------------------------------------------------
        */

        if (!auth()->check()) {

            return response()->json([
                'success' => false,
                'message' =>
                    'Sesi login tidak ditemukan.',
            ], 401);
        }

        $user = auth()->user();


        /*
        |--------------------------------------------------------------------------
        | AMBIL JENIS VERIFIKASI DARI SESSION
        |--------------------------------------------------------------------------
        */

        $verificationType =
            session(
                'face_liveness_type',
                'login'
            );


        if (
            !in_array(
                $verificationType,
                ['login', 'transaction']
            )
        ) {

            $verificationType =
                'login';
        }


        /*
        |--------------------------------------------------------------------------
        | CEK OTP HANYA UNTUK LOGIN
        |--------------------------------------------------------------------------
        */

        if (
            $verificationType === 'login'
            &&
            session('otp_verified') !== true
        ) {

            return response()->json([
                'success' => false,
                'message' =>
                    'OTP belum diverifikasi.',
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
                'message' =>
                    'Wajah Anda belum terdaftar.',
            ], 422);
        }


        /*
        |--------------------------------------------------------------------------
        | MODE LIVENESS & ANTI SPOOF
        |--------------------------------------------------------------------------
        |
        | Mode pasif (tanpa challenge) hanya untuk transaksi.
        | Jika client melaporkan kemungkinan foto/layar, verifikasi
        | dibatalkan dan kejadiannya dicatat.
        |
        */

        $livenessMode =
            $request->input(
                'liveness_mode',
                'active'
            );


        if (
            $livenessMode === 'passive' &&
            $verificationType !== 'transaction'
        ) {

            return response()->json([
                'success' => false,
                'message' =>
                    'Mode verifikasi tidak valid.',
            ], 422);
        }


        if ($request->boolean('spoof_suspected')) {

            FaceVerification::create([
                'user_id' =>
                    $user->id,

                'face_profile_id' =>
                    $user->faceProfile->id,

                'verification_type' =>
                    $verificationType,

                'liveness_passed' =>
                    false,

                'face_matched' =>
                    false,

                'distance' =>
                    null,

                'status' =>
                    'spoof_suspected',

                'verified_at' =>
                    now(),
            ]);

            Log::warning(
                'Kemungkinan spoofing (foto/layar) pada verifikasi wajah.',
                [
                    'user_id' => $user->id,
                    'type' => $verificationType,
                    'ip' => $request->ip(),
                ]
            );

            return response()->json([
                'success' => false,
                'spoof_suspected' => true,
                'message' =>
                    'Terdeteksi kemungkinan foto atau layar. Verifikasi dibatalkan dan kejadian ini dicatat.',
            ], 422);
        }


        /*
        |--------------------------------------------------------------------------
        | CEK LIVENESS
        |--------------------------------------------------------------------------
        */

        if (!$request->boolean('liveness_passed')) {

            FaceVerification::create([
                'user_id' =>
                    $user->id,

                'face_profile_id' =>
                    $user->faceProfile->id,

                'verification_type' =>
                    $verificationType,

                'liveness_passed' =>
                    false,

                'face_matched' =>
                    false,

                'distance' =>
                    null,

                'status' =>
                    'failed',

                'verified_at' =>
                    now(),
            ]);


            return response()->json([
                'success' => false,
                'message' =>
                    'Liveness detection gagal.',
            ], 422);
        }


        /*
        |--------------------------------------------------------------------------
        | CEK RANDOM CHALLENGE
        |--------------------------------------------------------------------------
        */

        if ($livenessMode === 'active') {

            $sessionChallenge =
                session(
                    'face_liveness_challenge'
                );


            $submittedChallenge =
                $request->input(
                    'liveness_sequence'
                );


            if (
                !is_array($sessionChallenge) ||
                count($sessionChallenge) !== 3
            ) {

                return response()->json([
                    'success' => false,
                    'message' =>
                        'Liveness challenge tidak ditemukan. Silakan ulangi.',
                ], 422);
            }


            if (
                !is_array($submittedChallenge) ||
                count($submittedChallenge) !== 3
            ) {

                return response()->json([
                    'success' => false,
                    'message' =>
                        'Urutan liveness tidak valid.',
                ], 422);
            }


            if (
                $submittedChallenge !==
                $sessionChallenge
            ) {

                FaceVerification::create([
                    'user_id' =>
                        $user->id,

                    'face_profile_id' =>
                        $user->faceProfile->id,

                    'verification_type' =>
                        $verificationType,

                    'liveness_passed' =>
                        false,

                    'face_matched' =>
                        false,

                    'distance' =>
                        null,

                    'status' =>
                        'failed',

                    'verified_at' =>
                        now(),
                ]);


                return response()->json([
                    'success' => false,
                    'message' =>
                        'Urutan liveness tidak sesuai dengan challenge.',
                ], 422);
            }

        }


        /*
        |--------------------------------------------------------------------------
        | AMBIL FACE EMBEDDING TERDAFTAR
        |--------------------------------------------------------------------------
        */

        $registeredEmbedding =
            json_decode(
                $user->faceProfile->face_embedding,
                true
            );


        /*
        |--------------------------------------------------------------------------
        | AMBIL FACE EMBEDDING DARI KAMERA
        |--------------------------------------------------------------------------
        */

        $currentEmbedding =
            $request->face_embedding;


        /*
        |--------------------------------------------------------------------------
        | VALIDASI EMBEDDING TERDAFTAR
        |--------------------------------------------------------------------------
        */

        if (
            !is_array($registeredEmbedding) ||
            count($registeredEmbedding) !== 128
        ) {

            return response()->json([
                'success' => false,
                'message' =>
                    'Data wajah terdaftar tidak valid.',
            ], 500);
        }


        /*
        |--------------------------------------------------------------------------
        | VALIDASI EMBEDDING KAMERA
        |--------------------------------------------------------------------------
        */

        if (
            !is_array($currentEmbedding) ||
            count($currentEmbedding) !== 128
        ) {

            return response()->json([
                'success' => false,
                'message' =>
                    'Data wajah dari kamera tidak valid.',
            ], 422);
        }


        /*
        |--------------------------------------------------------------------------
        | EUCLIDEAN DISTANCE
        |--------------------------------------------------------------------------
        */

        $sum = 0;


        for (
            $i = 0;
            $i < 128;
            $i++
        ) {

            $difference =
                $currentEmbedding[$i]
                -
                $registeredEmbedding[$i];


            $sum +=
                $difference *
                $difference;
        }


        $distance =
            sqrt($sum);


        /*
        |--------------------------------------------------------------------------
        | THRESHOLD
        |--------------------------------------------------------------------------
        */

        $threshold =
            0.50;


        /*
        |--------------------------------------------------------------------------
        | WAJAH TIDAK COCOK
        |--------------------------------------------------------------------------
        */

        if (
            $distance > $threshold
        ) {

            FaceVerification::create([
                'user_id' =>
                    $user->id,

                'face_profile_id' =>
                    $user->faceProfile->id,

                'verification_type' =>
                    $verificationType,

                'liveness_passed' =>
                    true,

                'face_matched' =>
                    false,

                'distance' =>
                    $distance,

                'status' =>
                    'failed',

                'verified_at' =>
                    now(),
            ]);


            return response()->json([
                'success' => false,
                'message' =>
                    'Wajah tidak cocok dengan wajah yang terdaftar.',
                'distance' =>
                    round(
                        $distance,
                        4
                    ),
            ], 422);
        }


        /*
        |--------------------------------------------------------------------------
        | SIMPAN HASIL VERIFIKASI BERHASIL
        |--------------------------------------------------------------------------
        */

        FaceVerification::create([
            'user_id' =>
                $user->id,

            'face_profile_id' =>
                $user->faceProfile->id,

            'verification_type' =>
                $verificationType,

            'liveness_passed' =>
                true,

            'face_matched' =>
                true,

            'distance' =>
                $distance,

            'status' =>
                'success',

            'verified_at' =>
                now(),
        ]);


        /*
        |--------------------------------------------------------------------------
        | HAPUS RANDOM CHALLENGE
        |--------------------------------------------------------------------------
        */

        session()->forget([
            'face_liveness_challenge',
            'face_liveness_type',
        ]);


        /*
        |--------------------------------------------------------------------------
        | LOGIN
        |--------------------------------------------------------------------------
        */

        if (
            $verificationType === 'login'
        ) {

            session([
                'face_verified' =>
                    true,

                'face_verified_at' =>
                    now()->timestamp,
            ]);


            if (
                $user->role === 'admin'
            ) {

                $redirect =
                    route(
                        'admin.dashboard'
                    );

            } else {

                $redirect =
                    route(
                        'dashboard'
                    );
            }

        }


       /*
        |--------------------------------------------------------------------------
        | TRANSACTION
        |--------------------------------------------------------------------------
        */

        else {

            session([
                'transaction_face_verified' =>
                    true,

                'transaction_face_verified_at' =>
                    now()->timestamp,
            ]);


            $redirectRoute =
                session(
                    'face_verification_redirect',
                    'transactions.create'
                );


            session()->forget(
                'face_verification_redirect'
            );


            $redirect =
                route(
                    $redirectRoute
                );
        }


        /*
        |--------------------------------------------------------------------------
        | RESPONSE
        |--------------------------------------------------------------------------
        */

        return response()->json([
            'success' =>
                true,

            'message' =>
                'Verifikasi wajah berhasil.',

            'redirect' =>
                $redirect,

            'distance' =>
                round(
                    $distance,
                    4
                ),
        ]);
    }
}