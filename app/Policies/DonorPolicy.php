<?php

namespace App\Policies;

use App\Models\User\User;
use Illuminate\Http\Request;
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

    public function manage($user, Request $request)
    {
        dd($request->user->account_type);
        
        return $request->user->account_type == 1;
    }
}
