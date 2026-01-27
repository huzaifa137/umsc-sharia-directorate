<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'username',
        'email',
        'password',
        'user_role',
        'account_status',
        'registration_status',
        'firstname',
        'lastname',
        'gender',
        'phonenumber',
        'country',
        'temp_otp',
        'email_verified_at',
        'last_login_at',
        'profile_photo',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'temp_otp',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login_at' => 'datetime',
    ];
}
