<?php

namespace App\Models\User;

use App\Models\Donation\Donor;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes;

    // Errors
    const ERROR_NOT_FOUND = 2000;
    const ERROR_EXISTS = 2001;

    // User Types
    const TYPE_GENERAL = 1;
    const TYPE_DONOR = 2;
    const TYPE_BLOOD_BANK_CONTACT = 3;
    const TYPE_ORGANIZATION_CONTACT = 4;
	const TYPE_ADMIN = 5;

	protected $appends = ['user_type'];

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

    public function getIsAdminAttribute()
    {
        return $this->account_type == self::TYPE_ADMIN;
    }

    public function donor()
    {
        return $this->hasOne(Donor::class, 'phone', 'phone');
	}

	public function getUserTypeAttribute()
	{
		$types = [
			self::TYPE_GENERAL => 'General',
			self::TYPE_DONOR => 'Donor',
			self::TYPE_BLOOD_BANK_CONTACT =>  'Blood Bank Contact',
			self::TYPE_ORGANIZATION_CONTACT => 'Organization Contact',
			self::TYPE_ADMIN => 'Admin'
		];

		return $types[$this->account_type];
	}
}
