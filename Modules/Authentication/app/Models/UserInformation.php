<?php

namespace Modules\Authentication\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Authentication\Database\Factories\UserInformationFactory;

// use Modules\Authentication\Database\Factories\UserInformationFactory;

class UserInformation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $table = 'user_informations';
    protected $fillable = ['gender', 'date_of_birth', 'address', 'image', 'user_id'];

    // protected static function newFactory(): UserInformationFactory
    // {
    //     // return UserInformationFactory::new();
    // }

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    protected static function newFactory(): UserInformationFactory
    {
        return UserInformationFactory::new();
    }
}
