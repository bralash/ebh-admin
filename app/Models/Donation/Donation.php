<?php

namespace App\Models\Donation;

use App\Models\Donation\Donor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Donation extends Model
{
	use SoftDeletes;

	// Model Specific Error Codes
	const ERROR_EXISTS = 5001;

	// Types
	const TYPE_BY_REQUEST = 1;
	const TYPE_BLOOD_BANK = 2;
	const TYPE_BLOOD_DRIVE = 3;

    protected $fillable = ['donation_type', 'event_id', 'donor_id', 'donation_uid', 'volume'];
    protected $with = ['donor'];

    public function donor()
    {
        return $this->belongsTo(Donor::class);
	}

	public function getDonationTypeAttribute($value)
	{
		$types = [
			self::TYPE_BY_REQUEST => 'By Request',
			self::TYPE_BLOOD_DRIVE => 'Blood Drive',
			self::TYPE_BLOOD_BANK =>  'Blood Bank',
		];

		return $types[$value];
	}

	
}
