<?php

namespace Modules\Authentication\app\Repository;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Response;
use Carbon\Carbon;

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

    public function postVerifyEmail(array $data)
    {
        $user = User::where('email', $data['email'])->first();
        if (!$user) {
            throw new \Exception('Email not found');
        }
        
        return response::json([
            'status' => true,
            'message' => 'Email verified successfully'
        ])
    }

    public function otpVerify(array $data)
    {
        $user = User::where('email', $data['email'])->first();
        if (!$user) {
            throw new \Exception('Email not found');
        }

        $otp = Str::random(4);

        // otpcode is a column in the users table
        $user->otp_code = $otp;

        // otp_expiry is a column in the users table
        $user->otp_expiry = Carbon::now()->addMinutes(5);
        
        // send otp to user in mobile
        $user->save();

        return response::json([
            'status' => true,
            'message' => 'OTP generated successfully',
            'otp' => $otp
        ])
    }

    public function postPasswordResetRequest(array $data)
    {
        $user = User::where('email', $data['email'])->first();
        if (!$user) {
            throw new \Exception('Email not found');
        }

        if ($user->otp_code != $data['otp']) {
            throw new \Exception('Invalid OTP');
        }

        $user->password = Hash::make($data['password']);
        return  $user->save();
      
    }
}
