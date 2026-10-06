<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    /**
     * Kolom yang boleh diisi melalui mass assignment.
     */
    protected $fillable = [
        'user_id',
        'recipient_user_id',
        'type',
        'amount',
        'description',
        'status',
        'reference',
    ];

    /**
     * Casting tipe data.
     */
    protected $casts = [
        'amount' => 'decimal:2',
    ];

    /**
     * Relasi ke user.
     *
     * Setiap transaksi dimiliki oleh satu user.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function recipient(): BelongsTo
    {
        return $this->belongsTo(User::class, 'recipient_user_id');
    }
}