<?php

namespace Modules\Authentication\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Authentication\Database\Factories\UserOtpFactory;

class UserOtp extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $table = 'user_otps';
    
    protected $fillable = [];

    // protected static function newFactory(): UserOtpFactory
    // {
    //     // return UserOtpFactory::new();
    // }
}
