<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * The before method will be executed before any other methods on the policy,
     * giving you an opportunity to authorize the action before the intended
     * policy method is actually called. This feature is most commonly used for
     * authorizing application administrators to perform any action.
     */
    public function before($user, $ability)
    {
        // TODO: Admins...
        // if ($user->isSuperAdmin()) {
        //     return true;
        // }
        return false;
    }

    /**
     * Determine whether the user can view the user.
     *
     * @param  \App\User  $user
     * @param  \App\User  $user
     * @return mixed
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
     * @return mixed
     */
    public function create(User $user)
    {
        // TODO: Check if user role > 1
        return true;
    }

    /**
     * Determine whether the user can update the user.
     *
     * @param  \App\User  $user
     * @param  \App\User  $user
     * @return mixed
     */
    public function update(User $user, User $user)
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
     * @return mixed
     */
    public function delete(User $user, User $user)
    {
        // TODO: Check if user role > 1
        return true;
    }
}
