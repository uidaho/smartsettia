<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;
    
    /**
     * Determine whether the user can view the list of users.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function index(User $user)
    {
        return $user->isAdmin();
    }
    
    /**
     * Determine whether the user can view the create users page.
     *
     * @param  \App\User  $user
     * @return boolean
     */
    public function create(User $user)
    {
        return $user->isAdmin();
    }
    
    /**
     * Determine whether the user can create a user.
     *
     * @param  \App\User  $user
     * @return boolean
     */
    public function store(User $user)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can view the user.
     *
     * @param  \App\User  $user the current user
     * @param  \App\User  $user2 the user to be viewed
     * @return boolean
     */
    public function show(User $user, User $user2)
    {
        if ($user->isAdmin())
            return true;
        else
            return $user->id === $user2->id;
    }
    
    /**
     * Determine whether the user can view the edit page for a user.
     *
     * @param  \App\User  $user
     * @param  \App\User  $user2 the user to be edited
     * @return mixed
     */
    public function edit(User $user, User $user2)
    {
        if ($user->isAdmin())
            return true;
        else
            return $user->id === $user2->id;
    }

    /**
     * Determine whether the user can update user2.
     *
     * @param  \App\User  $user
     * @param  \App\User  $user2
     * @return boolean
     */
    public function update(User $user, User $user2)
    {
        if ($user->isAdmin())
            return true;
        else
            return $user->id === $user2->id;
    }
    
    /**
     * Determine whether the user can update a user's role.
     *
     * @param  \App\User  $user
     * @return boolean
     */
    public function updateRole(User $user)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can delete the user.
     *
     * @param  \App\User  $user
     * @return boolean
     */
    public function destroy(User $user)
    {
        return $user->isAdmin();
    }
    
    /**
     * Determine whether the user can restore the user.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function restore(User $user)
    {
        return $user->isAdmin();
    }
}
