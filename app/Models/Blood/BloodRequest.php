<?php

namespace App\Models\Blood;

use App\Models\User\User;
use App\Models\Blood\BloodType;
use App\Models\Donation\Donation;
use App\Models\Location\Community;
use Illuminate\Database\Eloquent\Model;

class BloodRequest extends Model
{
    const REQUEST_PENDING = 4001;

    protected $fillable = [
        'requested_by',
        'requester_phone',
        'requester_location_id',
        'blood_type_id',
        'by_donor',
    ];

    public function requester()
    {
		return $this->belongsTo(User::class, 'requested_by')
			->withDefault([
				'name' => 'Unknown User',
				'account_type' => 1,
				'phone' => 'n/a',
			]);
    }

    public function location()
    {
        return $this->belongsTo(Community::class, 'requester_location_id');
    }

    public function blood_type()
    {
        return $this->belongsTo(BloodType::class);
    }

    public function donations()
    {
        return $this->hasMany(Donation::class, 'event_id');
    }
    //
}
