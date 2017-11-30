<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the user.
     *
     * @param  \App\User  $user
     * @param  \App\User  $user
     * @return boolean
     */
    public function view(User $user, User $user2)
    {
        // TODO: Check if user role is > 0
        return $user->role > 1 || $user->id === $user2->id;
    }

    /**
     * Determine whether the user can create users.
     *
     * @param  \App\User  $user
     * @return boolean
     */
    public function create(User $user)
    {
        // TODO: Check if user role > 1
        return true;
    }

    /**
     * Determine whether the user can update the user2.
     *
     * @param  \App\User  $user
     * @param  \App\User  $user
     * @return boolean
     */
    public function update(User $user, User $user2)
    {
        // Users can update themselves
        //return $user->id === $user->id;
        return true;
    }

    /**
     * Determine whether the user can delete the user.
     *
     * @param  \App\User  $user
     * @param  \App\User  $user
     * @return boolean
     */
    public function delete(User $user, User $user2)
    {
        // TODO: Check if user role > 1
        return true;
    }
}
