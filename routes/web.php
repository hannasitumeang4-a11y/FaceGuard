<?php

use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\MfaSetupController;
use App\Http\Controllers\Auth\PasswordRecoveryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FaceRegistrationController;
use App\Http\Controllers\FaceVerificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransactionController;
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
| DASHBOARD
|--------------------------------------------------------------------------
|
| Untuk masuk dashboard:
|
| Login
|   ↓
| OTP
|   ↓
| Face Verification
|   ↓
| Dashboard
|
*/

Route::get(
    '/dashboard',
    [DashboardController::class, 'index']
)->middleware([
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
    | TRANSACTION FACE VERIFICATION
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/transaction-face-verification',
        function () {
            return redirect()->route('face.verification', [
                'type' => 'transaction'
            ]);
        }
    )->name('transaction.face.verification');

    /*
    |--------------------------------------------------------------------------
    | TRANSACTIONS
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/transactions',
        [TransactionController::class, 'index']
    )->name('transactions.index');

    Route::get(
        '/transactions/create',
        [TransactionController::class, 'create']
    )->name('transactions.create');

    Route::post(
        '/transactions',
        [TransactionController::class, 'store']
    )->name('transactions.store');

    Route::get(
        '/transactions/{transaction}',
        [TransactionController::class, 'show']
    )->name('transactions.show');

    Route::delete(
        '/transactions/{transaction}',
        [TransactionController::class, 'destroy']
    )->name('transactions.destroy');

    Route::get(
        '/transfer', 
        [TransactionController::class, 'transfer']
    )->name('transfer.create');

    Route::post(
        '/transfer', 
        [TransactionController::class, 'processTransfer']
    )->name('transfer.store');

    Route::get(
        '/withdraw',
        [TransactionController::class, 'withdraw']
    )->name('withdraw.create');

    Route::post(
        '/withdraw',
        [TransactionController::class, 'processWithdraw']
    )->name('withdraw.store');


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
    */

    Route::middleware('admin')->group(function () {

        /*
        |--------------------------------------------------------------------------
        | ADMIN DASHBOARD
        |--------------------------------------------------------------------------
        */

        Route::get('/admin', function () {

            return view(
                'admin.dashboard'
            );

        })->name('admin.dashboard');


        /*
        |--------------------------------------------------------------------------
        | ADMIN USERS
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/admin/users',
            [UserController::class, 'index']
        )->name('admin.users');


        /*
        |--------------------------------------------------------------------------
        | ADMIN ACTIVITY LOGS
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/admin/activity-logs',
            [ActivityLogController::class, 'index']
        )->name('admin.activity-logs');

    });

});


/*
|--------------------------------------------------------------------------
| PASSWORD RECOVERY
|--------------------------------------------------------------------------
*/

Route::get(
    '/forgot-password',
    [PasswordRecoveryController::class, 'showEmailForm']
)->name('password.request');

Route::post(
    '/forgot-password',
    [PasswordRecoveryController::class, 'showSecurityQuestion']
)->name('password.question');

Route::post(
    '/forgot-password/verify',
    [PasswordRecoveryController::class, 'verifyAnswer']
)->name('password.verify');

Route::post(
    '/forgot-password/reset',
    [PasswordRecoveryController::class, 'resetPassword']
)->name('password.reset');


/*
|--------------------------------------------------------------------------
| AUTH ROUTES
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';