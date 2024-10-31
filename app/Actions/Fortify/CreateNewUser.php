<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'lastname' => ['required', 'string', 'max:255'],
            'document' => ['required', 'string', 'max:255'], // Validación para document
            'document_type' => ['required', 'string', 'max:255'], // Validación para document_type
            'phone_number' => ['required', 'string', 'max:255'], // Validación para phone_number
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        return User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'lastname' => $input['lastname'],
            'document' => $input['document'], // Guardar document
            'document_type' => $input['document_type'], // Guardar document_type
            'phone_number' => $input['phone_number'], // Guardar phone_number
            'password' => Hash::make($input['password']),
        ]);
    }
}
