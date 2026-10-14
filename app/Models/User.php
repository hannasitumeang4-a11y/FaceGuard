<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;

use Laravel\Fortify\TwoFactorAuthenticatable;

class User extends Authenticatable
{
    use HasFactory;
    use Notifiable;
    use TwoFactorAuthenticatable;

    // BARU: daftar pertanyaan yang bisa dipilih saat registrasi
    public const RECOVERY_QUESTIONS = [
        'Siapa nama hewan peliharaan pertama Anda?',
        'Di kota mana Anda dilahirkan?',
        'Apa nama sekolah dasar Anda?',
        'Siapa nama panggilan masa kecil Anda?',
        'Apa nama jalan tempat Anda tumbuh besar?',
        'Siapa nama sahabat masa kecil Anda?',
        'Apa makanan favorit Anda saat kecil?',
        'Apa merek kendaraan pertama Anda?',
    ];

    // DIUBAH: security_question/security_answer diganti recovery_*
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'recovery_question_1',
        'recovery_answer_1',
        'recovery_question_2',
        'recovery_answer_2',
        'recovery_question_3',
        'recovery_answer_3',
    ];

    // DIUBAH: jawaban (hash) disembunyikan dari output
    protected $hidden = [
        'password',
        'remember_token',

        'two_factor_secret',
        'two_factor_recovery_codes',

        'recovery_answer_1',
        'recovery_answer_2',
        'recovery_answer_3',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',

            'password' => 'hashed',

            'two_factor_confirmed_at' => 'datetime',
        ];
    }

    /**
     * Satu user memiliki satu face profile.
     */
    public function faceProfile(): HasOne
    {
        return $this->hasOne(FaceProfile::class);
    }

    /**
     * Activity log milik user.
     */
    public function activityLogs()
    {
        return $this->hasMany(ActivityLog::class);
    }
}