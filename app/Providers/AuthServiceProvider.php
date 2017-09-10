<?php

namespace App\Providers;

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
        'App\Model' => 'App\Policies\ModelPolicy',
        Users::class => UserPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::resource('users', 'UserPolicy');
        // Resource automagically defines:
        // Gate::define('users.view', 'UserPolicy@view');
        // Gate::define('users.create', 'UserPolicy@create');
        // Gate::define('users.update', 'UserPolicy@update');
        // Gate::define('users.delete', 'UserPolicy@delete');

    }
}
