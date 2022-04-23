<?php

namespace App\Providers;

use App\Models\Device;
use App\Models\Macro;
use App\Models\Room;
use App\Policies\DevicePolicy;
use App\Policies\MacroPolicy;
use App\Policies\RoomPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Device::class => DevicePolicy::class,
        Macro::class => MacroPolicy::class,
        Room::class => RoomPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        //
    }
}
