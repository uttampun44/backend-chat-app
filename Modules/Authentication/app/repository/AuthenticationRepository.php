<?php

namespace Modules\Authentication\app\repository;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;

class AuthenticationRepository
{

    public function postLogin(array $data)
    {
        $check = Auth::attempt([
            'email' => $data['email'],
            'password' => $data['password']
        ]);

        if (!$check) {
            throw new \Exception('Invalid credentials');
        }

        $token = Auth::user()->createToken('token')->plainTextToken;

        if (!$token) {
            throw new \Exception('Unable to generate token');
        }

        return $token;
    }

    public function postLogout()
    {

       $user = Auth::user();
       
        if(!$user){
            throw new \Exception('You are not Authenticated');
        }
       $tokens = $user->tokens()->delete();
       Auth::guard('web')->logout();

       return $tokens;
    }

    public function postRegister(array $data)
    {
        $check = User::where('email', $data['email'])->first();
        if ($check) {
            throw new \Exception('Email already exists');
        }

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
