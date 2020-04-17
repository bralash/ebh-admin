<?php

namespace App\Models\Donation;

use Illuminate\Database\Eloquent\Model;

class Donor extends Model
{
    const ERROR_ACCESS_DENIED = 3000;
    const ERROR_EXISTS = 3001;

    protected $guarded = ['id'];
}
