<?php

use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\MfaSetupController;
use App\Http\Controllers\FaceRegistrationController;
use App\Http\Controllers\FaceVerificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\FaceVerifiedMiddleware;

use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| LANDING PAGE
|--------------------------------------------------------------------------
*/

Route::get('/', function () {

    return view('welcome');

})->name('home');



/*
|--------------------------------------------------------------------------
| DASHBOARD USER
|--------------------------------------------------------------------------
|
| Dashboard hanya bisa dibuka setelah:
| Login + OTP + Face Verification
|
*/

Route::get('/dashboard', function () {

    return view('dashboard');

})->middleware([
    'auth',
    FaceVerifiedMiddleware::class,
])->name('dashboard');



/*
|--------------------------------------------------------------------------
| AUTHENTICATED USER
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {


    /*
    |--------------------------------------------------------------------------
    | MFA SETUP
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/mfa/setup',
        [MfaSetupController::class, 'show']
    )->name('mfa.setup');


    /*
    |--------------------------------------------------------------------------
    | FACE REGISTRATION
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/face-registration',
        [FaceRegistrationController::class, 'show']
    )->name('face.registration');

    Route::post(
        '/face-registration',
        [FaceRegistrationController::class, 'store']
    )->name('face.registration.store');


    /*
    |--------------------------------------------------------------------------
    | FACE VERIFICATION
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/face-verification',
        [FaceVerificationController::class, 'show']
    )->name('face.verification');

    Route::post(
        '/face-verification',
        [FaceVerificationController::class, 'verify']
    )->name('face.verification.verify');


    /*
    |--------------------------------------------------------------------------
    | PROFILE
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/profile',
        [ProfileController::class, 'edit']
    )->name('profile.edit');

    Route::patch(
        '/profile',
        [ProfileController::class, 'update']
    )->name('profile.update');

    Route::delete(
        '/profile',
        [ProfileController::class, 'destroy']
    )->name('profile.destroy');


    /*
    |--------------------------------------------------------------------------
    | SECURITY
    |--------------------------------------------------------------------------
    */

    Route::get('/security', function () {

        return view('security');

    })->name('security');


    /*
    |--------------------------------------------------------------------------
    | RECOVERY CODES
    |--------------------------------------------------------------------------
    */

    Route::get('/recovery-codes', function () {

        return view(
            'auth.recovery-codes',
            [
                'recoveryCodes' =>
                    auth()->user()->recoveryCodes(),
            ]
        );

    })->name('recovery-codes');


    /*
    |--------------------------------------------------------------------------
    | ADMIN
    |--------------------------------------------------------------------------
    |
    | Admin juga wajib melewati face verification.
    |
    */

    Route::middleware([
        'admin',
        FaceVerifiedMiddleware::class,
    ])->group(function () {


        Route::get('/admin', function () {

            return view(
                'admin.dashboard'
            );

        })->name('admin.dashboard');


        Route::get(
            '/admin/users',
            [UserController::class, 'index']
        )->name('admin.users');


        Route::get(
            '/admin/activity-logs',
            [ActivityLogController::class, 'index']
        )->name('admin.activity-logs');

    });

});


require __DIR__.'/auth.php';