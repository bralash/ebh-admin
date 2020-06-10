<?php

namespace App\Models\Donation;

use App\Models\User\Badge;
use App\Models\Blood\BloodType;
use App\Models\Location\Community;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Donor extends Model
{
	use SoftDeletes;

    const ERROR_ACCESS_DENIED = 3000;
    const ERROR_EXISTS = 3001;

    protected $guarded = ['id'];
    protected $hidden = ['badge_id', 'blood_type_id', 'community_id'];
    protected $with = ['badge', 'blood_type', 'community'];

    // Relation
    public function badge()
    {
        return $this->belongsTo(Badge::class);
    }

    public function blood_type()
    {
        return $this->belongsTo(BloodType::class);
    }

    public function community()
    {
        return $this->belongsTo(Community::class);
	}

	public function donations()
	{
		return $this->hasMany(Donation::class);
	}
}
