<?php

namespace App\Providers;

use App\Device;
use App\Policies\DevicePolicy;
use App\User;
use App\Policies\UserPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        User::class => UserPolicy::class,
        Device::class => DevicePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //Gate::resource('users', 'UserPolicy');
        // Resource automagically defines:
        // Gate::define('users.view', 'UserPolicy@view');
        // Gate::define('users.create', 'UserPolicy@create');
        // Gate::define('users.update', 'UserPolicy@update');
        // Gate::define('users.delete', 'UserPolicy@delete');

    }
}
