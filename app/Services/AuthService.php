<?php

namespace App\Services;

use App\Models\User;

class AuthService
{
    public function register(array $data)
    {
        $data['verification_code'] = rand(100000, 999999);

        $user = User::create($data);

        logger('Verification code for ' . $user->phone_number . ' is ' . $data['verification_code']);

        return $user;
    }

    public function login(array $data)
    {
        $authenticated = auth()->attempt(['phone_number' => $data['phone_number'], 'password' => $data['password']], $data['remember']);
        
        if (! $authenticated) {
            throw new \Exception('Invalid Credentials');
        }

        $user = auth()->user();

        if ($user->verified_at == null) {
            throw new \Exception('Please Verify Account First');
        }

        return $user;
    }

    public function verify(array $data)
    {
        $user = User::where('phone_number', $data['phone_number'])->first();

        if (! $user) {
            throw new \Exception('Invalid Phone Number');
        }

        if ($data['verification_code'] == $user->verification_code) {
            $user->verified_at = now();
            $user->save();
            return true;
        }
       
        throw new \Exception('Invalid Verification Code');
    }
}