<?php

namespace App\Policies;

use App\User;
use App\Location;
use Illuminate\Auth\Access\HandlesAuthorization;

class LocationPolicy
{
    use HandlesAuthorization;
    
    /**
     * Determine whether the user can view the location.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function index(User $user)
    {
        return $user->isManager();
    }
    
    /**
     * Determine whether the user can view the create location page.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->isManager();
    }
    
    /**
     * Determine whether the user can create a location.
     *
     * @param  \App\User  $user
     * @return boolean
     */
    public function store(User $user)
    {
        return $user->isManager();
    }
    
    /**
     * Determine whether the user can view a location.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function show(User $user)
    {
        return $user->isUser();
    }
    
    /**
     * Determine whether the user can view the edit page for a location.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function edit(User $user)
    {
        return $user->isManager();
    }
    
    /**
     * Determine whether the user can update the location.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function update(User $user)
    {
        return $user->isManager();
    }
    
    /**
     * Determine whether the user can delete the location.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function destroy(User $user)
    {
        return $user->isManager();
    }
}
