<?php

namespace Modules\Authentication\app\repository;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthenticationRepository {

    public function postLogin(array $data)
    {
        
    }

    public function postLogout(array $data)
    {

    }

    public function postRegister(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password'])
        ]);
    }

    public function postResetPassword(array $data)
    {
        //
    }
}