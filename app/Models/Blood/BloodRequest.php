<?php

namespace App\Models\Blood;

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
    //
}
