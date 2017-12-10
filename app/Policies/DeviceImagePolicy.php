<?php

namespace App\Policies;

use App\User;
use App\Deviceimage;
use Illuminate\Auth\Access\HandlesAuthorization;

class DeviceImagePolicy
{
    use HandlesAuthorization;
    
    /**
     * Determine whether the user can view a device.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function show(User $user)
    {
        return $user->isUser();
    }
}
