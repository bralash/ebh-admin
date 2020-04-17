<?php

namespace App\Models\User;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    // Errors
    const ERROR_NOT_FOUND = 2000;
    const ERROR_EXISTS = 2001;

    // Types
    const TYPE_ADMIN = 1;
    const TYPE_DONOR = 2;
    const TYPE_BLOOD_BANK_CONTACT = 3;
    const TYPE_ORGANIZATION_CONTACT = 4;
    const TYPE_GENERAL = 5;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'phone', 'password', 'account_type', 'account_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function access()
    {
        return $this->hasMany('App\Models\User\UserAccessKey');
    }
}
