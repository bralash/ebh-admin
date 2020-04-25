<?php

namespace App\Policies;

use App\Models\User\User;
use Illuminate\Http\Request;
use App\Models\Donation\Donor;
use Illuminate\Auth\Access\HandlesAuthorization;

class DonorPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function owns(User $user, Donor $donor)
    {
        return request()->user->phone == $donor->phone;
    }
}
