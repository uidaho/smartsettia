<?php

namespace App\Policies;

use App\User;
use App\Sensor;
use Illuminate\Auth\Access\HandlesAuthorization;

class SensorPolicy
{
    use HandlesAuthorization;
    
    /**
     * Determine whether the user can view the sensor.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function index(User $user)
    {
        return $user->isAdmin();
    }
    
    /**
     * Determine whether the user can view the create sensors page.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->isAdmin();
    }
    
    /**
     * Determine whether the user can create a sensor.
     *
     * @param  \App\User  $user
     * @return boolean
     */
    public function store(User $user)
    {
        return $user->isAdmin();
    }
    
    /**
     * Determine whether the user can view a sensor.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function show(User $user)
    {
        return $user->isUser();
    }
    
    /**
     * Determine whether the user can view the edit page for a sensor.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function edit(User $user)
    {
        return $user->isAdmin();
    }
    
    /**
     * Determine whether the user can update the sensor.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function update(User $user)
    {
        return $user->isAdmin();
    }
    
    /**
     * Determine whether the user can delete the sensor.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function destroy(User $user)
    {
        return $user->isAdmin();
    }
}
