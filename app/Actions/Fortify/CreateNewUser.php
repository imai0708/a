<?php

namespace App\Actions\Fortify;

use App\Models\Advisor;
use App\Models\User;
use Illuminate\Support\Facades\DB;
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
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        DB::beginTransaction();
        try {
            // ユーザーの登録
            $user = User::create([
                'name' => $input['name'],
                'email' => $input['email'],
                'password' => Hash::make($input['password']),
            ]);

            // アドバイザー情報の登録
            if (isset($input['job'])) {
                Advisor::create([
                    'user_id' => $user->id,
                    'job' =>  $input['job'],
                    'price' =>  $input['price'],
                ]);
            }

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
        }
        return $user;
    }
}
