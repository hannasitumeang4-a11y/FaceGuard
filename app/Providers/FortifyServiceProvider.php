<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;

use App\Http\Responses\TwoFactorLoginResponse;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

use Laravel\Fortify\Actions\RedirectIfTwoFactorAuthenticatable;
use Laravel\Fortify\Contracts\LoginResponse;
use Laravel\Fortify\Contracts\TwoFactorLoginResponse as TwoFactorLoginResponseContract;
use Laravel\Fortify\Fortify;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        /*
        |--------------------------------------------------------------------------
        | LOGIN RESPONSE
        |--------------------------------------------------------------------------
        |
        | Digunakan setelah email + password berhasil.
        |
        */

        $this->app->singleton(
            LoginResponse::class,
            function () {

                return new class implements LoginResponse {

                    public function toResponse($request)
                    {
                        $user = $request->user();


                        /*
                        |--------------------------------------------------------------------------
                        | MFA BELUM AKTIF
                        |--------------------------------------------------------------------------
                        */

                        if (
                            $user &&
                            ! $user->hasEnabledTwoFactorAuthentication()
                        ) {

                            return redirect()->route(
                                'mfa.setup'
                            );
                        }


                        /*
                        |--------------------------------------------------------------------------
                        | FACE BELUM TERDAFTAR
                        |--------------------------------------------------------------------------
                        */

                        if (
                            $user &&
                            ! $user->faceProfile
                        ) {

                            return redirect()->route(
                                'face.registration'
                            );
                        }


                        /*
                        |--------------------------------------------------------------------------
                        | FACE SUDAH TERDAFTAR
                        |--------------------------------------------------------------------------
                        |
                        | Jangan langsung ke dashboard.
                        | User harus melewati face verification.
                        |
                        */

                        return redirect()->route(
                            'face.verification'
                        );
                    }
                };
            }
        );


        /*
        |--------------------------------------------------------------------------
        | TWO FACTOR LOGIN RESPONSE
        |--------------------------------------------------------------------------
        |
        | Digunakan setelah OTP berhasil.
        |
        */

        $this->app->singleton(
            TwoFactorLoginResponseContract::class,
            TwoFactorLoginResponse::class
        );
    }


    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        /*
        |--------------------------------------------------------------------------
        | CREATE USER
        |--------------------------------------------------------------------------
        */

        Fortify::createUsersUsing(
            CreateNewUser::class
        );


        /*
        |--------------------------------------------------------------------------
        | UPDATE PROFILE
        |--------------------------------------------------------------------------
        */

        Fortify::updateUserProfileInformationUsing(
            UpdateUserProfileInformation::class
        );


        /*
        |--------------------------------------------------------------------------
        | UPDATE PASSWORD
        |--------------------------------------------------------------------------
        */

        Fortify::updateUserPasswordsUsing(
            UpdateUserPassword::class
        );


        /*
        |--------------------------------------------------------------------------
        | RESET PASSWORD
        |--------------------------------------------------------------------------
        */

        Fortify::resetUserPasswordsUsing(
            ResetUserPassword::class
        );


        /*
        |--------------------------------------------------------------------------
        | TWO FACTOR AUTHENTICATION
        |--------------------------------------------------------------------------
        */

        Fortify::redirectUserForTwoFactorAuthenticationUsing(
            RedirectIfTwoFactorAuthenticatable::class
        );


        /*
        |--------------------------------------------------------------------------
        | TWO FACTOR CHALLENGE VIEW
        |--------------------------------------------------------------------------
        */

        Fortify::twoFactorChallengeView(function () {

            return view(
                'auth.two-factor-challenge'
            );

        });


        /*
        |--------------------------------------------------------------------------
        | LOGIN RATE LIMITER
        |--------------------------------------------------------------------------
        */

        RateLimiter::for(
            'login',
            function (Request $request) {

                $throttleKey =
                    Str::transliterate(
                        Str::lower(
                            $request->input(
                                Fortify::username()
                            )
                        )
                        . '|'
                        . $request->ip()
                    );

                return Limit::perMinute(5)
                    ->by($throttleKey);
            }
        );


        /*
        |--------------------------------------------------------------------------
        | TWO FACTOR RATE LIMITER
        |--------------------------------------------------------------------------
        */

        RateLimiter::for(
            'two-factor',
            function (Request $request) {

                return Limit::perMinute(5)
                    ->by(
                        $request
                            ->session()
                            ->get('login.id')
                    );
            }
        );


        /*
        |--------------------------------------------------------------------------
        | PASSKEY RATE LIMITER
        |--------------------------------------------------------------------------
        */

        RateLimiter::for(
            'passkeys',
            function (Request $request) {

                $credentialId =
                    $request->input(
                        'credential.id'
                    );

                return Limit::perMinute(10)
                    ->by(
                        (
                            $credentialId
                            ?:
                            $request
                                ->session()
                                ->getId()
                        )
                        . '|'
                        . $request->ip()
                    );
            }
        );
    }
}