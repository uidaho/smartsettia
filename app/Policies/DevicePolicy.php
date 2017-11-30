<?php

namespace App\Policies;

use App\User;
use App\Device;
use Illuminate\Auth\Access\HandlesAuthorization;

class DevicePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the device.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function index(User $user)
    {
        return $user->isManager();
    }

    /**
     * Determine whether the user can create devices.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->isAdmin();
    }
    
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
    
    /**
     * Determine whether the user can view the edit page for a device.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function edit(User $user)
    {
        return $user->isManager();
    }

    /**
     * Determine whether the user can update the device.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function update(User $user)
    {
        return $user->isUser();
    }

    /**
     * Determine whether the user can delete the device.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function destroy(User $user)
    {
        return $user->isAdmin();
    }
    
    /**
     * Determine whether the user can restore the device.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function restore(User $user)
    {
        return $user->isAdmin();
    }
}
