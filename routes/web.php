<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

    // Security
    Route::get('/security', function () {
        return view('security');
    })->name('security');

     // Recovery Codes
    Route::get('/recovery-codes', function () {
        return view('auth.recovery-codes', [
            'recoveryCodes' => auth()->user()->recoveryCodes(),
        ]);
    })->name('recovery-codes');

});

require __DIR__.'/auth.php';