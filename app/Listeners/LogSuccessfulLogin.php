<?php

namespace App\Listeners;

use App\Models\ActivityLog;
use Illuminate\Auth\Events\Login;

class LogSuccessfulLogin
{
    /**
     * Handle the event.
     */
    public function handle(Login $event): void
    {
        ActivityLog::create([
            'user_id' => $event->user->id,
            'activity' => 'Login berhasil',
            'status' => 'success',
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}