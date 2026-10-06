<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\FaceProfile;

class FaceVerification extends Model
{
    protected $fillable = [
        'user_id',
        'face_profile_id',
        'verification_type',
        'liveness_passed',
        'face_matched',
        'distance',
        'status',
        'verified_at',
    ];


    protected $casts = [
        'liveness_passed' => 'boolean',
        'face_matched' => 'boolean',
        'distance' => 'float',
        'verified_at' => 'datetime',
    ];


    public function user()
    {
        return $this->belongsTo(
            User::class
        );
    }


    public function faceProfile()
    {
        return $this->belongsTo(
            FaceProfile::class
        );
    }
}