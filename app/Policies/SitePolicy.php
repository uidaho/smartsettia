<?php

namespace App\Policies;

use App\User;
use App\Site;
use Illuminate\Auth\Access\HandlesAuthorization;

class SitePolicy
{
    use HandlesAuthorization;
    
    /**
     * Determine whether the user can view the site.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function index(User $user)
    {
        return $user->isManager();
    }
    
    /**
     * Determine whether the user can view the create site page.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->isManager();
    }
    
    /**
     * Determine whether the user can create a site.
     *
     * @param  \App\User  $user
     * @return boolean
     */
    public function store(User $user)
    {
        return $user->isManager();
    }
    
    /**
     * Determine whether the user can view a site.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function show(User $user)
    {
        return $user->isUser();
    }
    
    /**
     * Determine whether the user can view the edit page for a site.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function edit(User $user)
    {
        return $user->isManager();
    }
    
    /**
     * Determine whether the user can update the site.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function update(User $user)
    {
        return $user->isManager();
    }
    
    /**
     * Determine whether the user can delete the site.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function destroy(User $user)
    {
        return $user->isManager();
    }
}
