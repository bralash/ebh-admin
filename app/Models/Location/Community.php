<?php

namespace App\Models\Location;

use Illuminate\Database\Eloquent\Model;

class Community extends Model
{
    const ERROR_EXISTS = 6001;

    protected $fillable = ['name', 'region', 'gps_address', 'district'];
    //
}
