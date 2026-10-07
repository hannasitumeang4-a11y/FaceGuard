<?php

namespace App\Actions\Fortify;

use App\Models\User;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use Laravel\Fortify\Contracts\CreatesNewUsers;

use Illuminate\Validation\Rules;

class CreateNewUser implements CreatesNewUsers
{
    public function create(array $input): User
    {
        Validator::make($input, [

            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users,email',
            ],

            'password' => [
                'required',
                'string',
                'confirmed',
                Rules\Password::defaults(),
            ],

            'recovery_question_1' => [
                'required',
                'string',
                'max:255',
            ],

            'recovery_answer_1' => [
                'required',
                'string',
                'max:255',
            ],

            'recovery_question_2' => [
                'required',
                'string',
                'max:255',
            ],

            'recovery_answer_2' => [
                'required',
                'string',
                'max:255',
            ],

            'recovery_question_3' => [
                'required',
                'string',
                'max:255',
            ],

            'recovery_answer_3' => [
                'required',
                'string',
                'max:255',
            ],

        ])->validate();


        return User::create([

            'name' => $input['name'],

            'email' => strtolower($input['email']),

            'password' => Hash::make(
                $input['password']
            ),

            'role' => 'user',


            /*
            |--------------------------------------------------------------------------
            | Recovery Question 1
            |--------------------------------------------------------------------------
            */

            'recovery_question_1' =>
                $input['recovery_question_1'],

            'recovery_answer_1' =>
                Hash::make(
                    strtolower(
                        trim(
                            $input['recovery_answer_1']
                        )
                    )
                ),


            /*
            |--------------------------------------------------------------------------
            | Recovery Question 2
            |--------------------------------------------------------------------------
            */

            'recovery_question_2' =>
                $input['recovery_question_2'],

            'recovery_answer_2' =>
                Hash::make(
                    strtolower(
                        trim(
                            $input['recovery_answer_2']
                        )
                    )
                ),


            /*
            |--------------------------------------------------------------------------
            | Recovery Question 3
            |--------------------------------------------------------------------------
            */

            'recovery_question_3' =>
                $input['recovery_question_3'],

            'recovery_answer_3' =>
                Hash::make(
                    strtolower(
                        trim(
                            $input['recovery_answer_3']
                        )
                    )
                ),
        ]);
    }
}