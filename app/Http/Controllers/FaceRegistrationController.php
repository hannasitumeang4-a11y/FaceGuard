<?php

namespace App\Http\Controllers;

use App\Models\FaceProfile;
use Illuminate\Http\Request;

class FaceRegistrationController extends Controller
{
    public function show()
    {
        $user = auth()->user();


        /*
        |--------------------------------------------------------------------------
        | JIKA WAJAH SUDAH TERDAFTAR
        |--------------------------------------------------------------------------
        */

        if ($user->faceProfile) {

            return redirect()->route(
                'face.verification'
            );
        }


        return view(
            'auth.face-registration'
        );
    }


    public function store(Request $request)
    {
        $request->validate([
            'face_embedding' => [
                'required',
                'array',
                'size:128',
            ],
        ]);


        $user = auth()->user();


        /*
        |--------------------------------------------------------------------------
        | CEK AGAR TIDAK MENDAFTARKAN ULANG
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
        | SIMPAN WAJAH
        |--------------------------------------------------------------------------
        */

        FaceProfile::create([
            'user_id' =>
                $user->id,

            'face_embedding' =>
                json_encode(
                    $request->face_embedding
                ),
        ]);


        /*
        |--------------------------------------------------------------------------
        | FACE REGISTRATION SEKALIGUS
        | MENYELESAIKAN VERIFIKASI PERTAMA
        |--------------------------------------------------------------------------
        */

        session([
            'face_verified' => true,
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
                'Wajah berhasil didaftarkan.',
            'redirect' =>
                $redirect,
        ]);
    }
}