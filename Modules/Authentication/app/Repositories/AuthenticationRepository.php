<?php

namespace Modules\Authentication\app\Repositories;

use App\Mail\OtpMessage;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Modules\Authentication\Models\UserOtp;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

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

    public function postConfirmEmail(array $data)
    {
        $user = User::where('email', $data['email'])->first();
        if (!$user) {
            throw new \Exception('User Email not found');
        }
        $user->email_verified_at = now();
        
        return $user->only(['id', 'name', 'email']);
    }

    public function postOtp(array $data)
    {
        $user = User::where('email', $data['email'])->first();
        if (!$user) {
            throw new \Exception('User Email not found');
        }
        $otp = Str::random(4);

        $userOtp = UserOtp::where('user_id', $user->id)->first();
        if(!$userOtp){
            $userOtp = new UserOtp();
            $userOtp->user_id = $user->id;
        }
        Carbon::now()->addMinutes(5);
        $userOtp->otp_code = $otp;
        $userOtp->email = $data['email'];
        Carbon::now()->addMinutes(5);
        Mail::to($user->email)->send(new OtpMessage($otp));
        return $userOtp->save();
    }

    public function postResetPassword(array $data)
    {
        $user = User::where('email', $data['email'])->first();
        if (!$user) {
            throw new \Exception('Email not found');
        }

        $user->password = Hash::make($data['password']);
        $user->save();

        return $user;
    }
}
