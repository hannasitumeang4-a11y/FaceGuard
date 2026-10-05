<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FaceVerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | TAMPILKAN HALAMAN VERIFIKASI
    |--------------------------------------------------------------------------
    */

    public function show()
    {
        $user = auth()->user();


        /*
        | User belum punya wajah
        */

        if (! $user->faceProfile) {

            return redirect()->route(
                'face.registration'
            );
        }


        /*
        | Jika sudah diverifikasi dalam session,
        | tidak perlu verifikasi lagi.
        */

        if (session('face_verified')) {

            if ($user->role === 'admin') {

                return redirect()->route(
                    'admin.dashboard'
                );
            }

            return redirect()->route(
                'dashboard'
            );
        }


        return view(
            'auth.face-verification'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | VERIFIKASI WAJAH
    |--------------------------------------------------------------------------
    */

    public function verify(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | VALIDASI DATA
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
        ]);


        $user = auth()->user();


        /*
        |--------------------------------------------------------------------------
        | CEK FACE PROFILE
        |--------------------------------------------------------------------------
        */

        if (! $user->faceProfile) {

            return response()->json([
                'success' => false,
                'message' =>
                    'Wajah Anda belum terdaftar.',
            ], 422);
        }


        /*
        |--------------------------------------------------------------------------
        | CEK LIVENESS
        |--------------------------------------------------------------------------
        |
        | Untuk tahap ini browser melakukan pengecekan
        | kedipan sebelum mengirim data.
        |
        */

        if (! $request->boolean('liveness_passed')) {

            return response()->json([
                'success' => false,
                'message' =>
                    'Liveness detection gagal.',
            ], 422);
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


        $currentEmbedding =
            $request->face_embedding;


        /*
        |--------------------------------------------------------------------------
        | CEK DATA EMBEDDING
        |--------------------------------------------------------------------------
        */

        if (
            ! is_array($registeredEmbedding) ||
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
        | HITUNG EUCLIDEAN DISTANCE
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
        |
        | Semakin kecil distance,
        | semakin mirip kedua wajah.
        |
        */

        $threshold = 0.50;


        /*
        |--------------------------------------------------------------------------
        | WAJAH TIDAK COCOK
        |--------------------------------------------------------------------------
        */

        if ($distance > $threshold) {

            return response()->json([
                'success' => false,
                'message' =>
                    'Wajah tidak cocok dengan wajah terdaftar.',
                'distance' => round(
                    $distance,
                    4
                ),
            ], 422);
        }


        /*
        |--------------------------------------------------------------------------
        | BERHASIL
        |--------------------------------------------------------------------------
        */

        session([
            'face_verified' => true,
        ]);


        /*
        |--------------------------------------------------------------------------
        | CATAT WAKTU VERIFIKASI
        |--------------------------------------------------------------------------
        */

        session([
            'face_verified_at' => now()->timestamp,
        ]);


        /*
        |--------------------------------------------------------------------------
        | TENTUKAN DASHBOARD
        |--------------------------------------------------------------------------
        */

        if ($user->role === 'admin') {

            $redirect =
                route('admin.dashboard');

        } else {

            $redirect =
                route('dashboard');
        }


        return response()->json([
            'success' => true,
            'message' =>
                'Verifikasi wajah berhasil.',
            'redirect' => $redirect,
            'distance' => round(
                $distance,
                4
            ),
        ]);
    }
}