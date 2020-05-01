<?php

namespace App\Models\Donation;

use App\Models\Donation\Donor;
use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    const ERROR_EXISTS = 5001;

    protected $fillable = ['donation_type', 'event_id', 'donor_id', 'donation_uid', 'volume'];
    protected $with = ['donor'];
    
    public function donor()
    {
        return $this->belongsTo(Donor::class);
    }
}
