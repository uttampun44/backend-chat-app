<?php

namespace Modules\Authentication\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Authentication\Database\Factories\UserInformationFactory;

class UserInformation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $table = 'user_informations';
    protected $fillable = [];

    // protected static function newFactory(): UserInformationFactory
    // {
    //     // return UserInformationFactory::new();
    // }
}
