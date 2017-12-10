<?php

namespace App\Providers;

use App\Device;
use App\Deviceimage;
use App\Location;
use App\Policies\DeviceImagePolicy;
use App\Policies\DevicePolicy;
use App\Policies\LocationPolicy;
use App\Policies\SensorDataPolicy;
use App\Policies\SensorPolicy;
use App\Policies\SitePolicy;
use App\Sensor;
use App\SensorData;
use App\Site;
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
        Deviceimage::class => DeviceImagePolicy::class,
        Site::class => SitePolicy::class,
        Location::class => LocationPolicy::class,
        Sensor::class => SensorPolicy::class,
        SensorData::class => SensorDataPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
    
        Gate::define('index-dashboard', function ($user) {
            return $user->isUser();
        });
    }
}
