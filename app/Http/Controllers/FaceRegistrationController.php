<?php

namespace App\Http\Controllers;

use App\Models\FaceProfile;
use App\Models\FaceVerification;
use Illuminate\Http\Request;

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
        | WAJAH SUDAH ADA
        |--------------------------------------------------------------------------
        |
        | Jangan registrasi ulang.
        |
        */

        if ($user->faceProfile) {

            if (session('face_verified') === true) {

                if ($user->role === 'admin') {
                    return redirect()->route('admin.dashboard');
                }

                return redirect()->route('dashboard');
            }

            return redirect()->route(
                'face.verification'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | BUAT RANDOM LIVENESS CHALLENGE
        |--------------------------------------------------------------------------
        |
        | Setiap registrasi mendapatkan urutan berbeda.
        |
        | Contoh:
        | blink -> left -> right
        | left -> right -> blink
        | right -> blink -> left
        |
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
            'face_liveness_challenge' => $challenge,
            'face_liveness_type' => 'registration',
        ]);


        /*
        |--------------------------------------------------------------------------
        | TAMPILKAN REGISTRASI WAJAH
        |--------------------------------------------------------------------------
        */

        return view(
            'auth.face-registration'
        );
    }


    public function store(Request $request)
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

            'liveness_sequence' => [
                'required',
                'array',
                'size:3',
            ],
        ]);


        $user = auth()->user();


        /*
        |--------------------------------------------------------------------------
        | USER HARUS LOGIN
        |--------------------------------------------------------------------------
        */

        if (!$user) {

            return response()->json([
                'success' => false,
                'message' =>
                    'Sesi login tidak ditemukan.',
            ], 401);
        }


        /*
        |--------------------------------------------------------------------------
        | CEK APAKAH WAJAH SUDAH ADA
        |--------------------------------------------------------------------------
        */

        if ($user->faceProfile) {

            return response()->json([
                'success' => false,
                'message' =>
                    'Wajah Anda sudah terdaftar.',
            ], 422);
        }


        /*
        |--------------------------------------------------------------------------
        | CEK LIVENESS
        |--------------------------------------------------------------------------
        */

        if (!$request->boolean('liveness_passed')) {

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

        $sessionChallenge =
            session('face_liveness_challenge');


        $submittedChallenge =
            $request->input('liveness_sequence');


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

            return response()->json([
                'success' => false,
                'message' =>
                    'Urutan liveness tidak sesuai dengan challenge.',
            ], 422);
        }


        /*
        |--------------------------------------------------------------------------
        | AMBIL FACE EMBEDDING
        |--------------------------------------------------------------------------
        */

        $embedding =
            $request->face_embedding;


        /*
        |--------------------------------------------------------------------------
        | PASTIKAN 128 DATA
        |--------------------------------------------------------------------------
        */

        if (
            !is_array($embedding) ||
            count($embedding) !== 128
        ) {

            return response()->json([
                'success' => false,
                'message' =>
                    'Data wajah tidak valid.',
            ], 422);
        }


        /*
        |--------------------------------------------------------------------------
        | SIMPAN WAJAH
        |--------------------------------------------------------------------------
        |
        | Embedding ini menjadi wajah utama/canonical user.
        |
        */

        $faceProfile =
            FaceProfile::create([
                'user_id' => $user->id,

                'face_embedding' =>
                    json_encode($embedding),
            ]);


        /*
        |--------------------------------------------------------------------------
        | SIMPAN HASIL VERIFIKASI
        |--------------------------------------------------------------------------
        */

        FaceVerification::create([
            'user_id' =>
                $user->id,

            'face_profile_id' =>
                $faceProfile->id,

            'verification_type' =>
                'registration',

            'liveness_passed' =>
                true,

            'face_matched' =>
                true,

            'distance' =>
                null,

            'status' =>
                'success',

            'verified_at' =>
                now(),
        ]);


        /*
        |--------------------------------------------------------------------------
        | HAPUS CHALLENGE SETELAH BERHASIL
        |--------------------------------------------------------------------------
        */

        session()->forget([
            'face_liveness_challenge',
            'face_liveness_type',
        ]);


        /*
        |--------------------------------------------------------------------------
        | REGISTRASI WAJAH BERHASIL
        |--------------------------------------------------------------------------
        |
        | Karena ini adalah login pertama,
        | user dianggap sudah melewati face authentication.
        |
        */

        session([
            'face_verified' => true,
            'face_verified_at' => now()->timestamp,
        ]);


        /*
        |--------------------------------------------------------------------------
        | DASHBOARD
        |--------------------------------------------------------------------------
        */

        $redirect = $user->role === 'admin'
            ? route('admin.dashboard')
            : route('dashboard');


        return response()->json([
            'success' => true,

            'message' =>
                'Wajah berhasil didaftarkan.',

            'redirect' =>
                $redirect,
        ]);
    }
}