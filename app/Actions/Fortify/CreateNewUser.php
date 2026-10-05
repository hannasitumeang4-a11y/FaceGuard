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

        ])->validate();


return User::create([
    'name' => $input['name'],
    'email' => strtolower($input['email']),
    'password' => Hash::make($input['password']),
    'role' => 'user',
]);
    }
}