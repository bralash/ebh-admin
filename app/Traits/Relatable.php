<?php

namespace App\Traits;

trait Relatable
{
    /**
     * Checks if resource is owned by user
     * 
     * @param App\Models\User\User $user
     * 
     * @return Boolean
     */
    public function ownedBy($user) {
        return $this->user_id == $user->id;
    }
}
