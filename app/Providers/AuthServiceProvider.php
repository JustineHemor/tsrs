<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Policies\DriverPolicy;
use App\Policies\VehiclePolicy;
use Domain\TripTickets\Models\Driver;
use Domain\TripTickets\Models\Vehicle;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Driver::class => DriverPolicy::class,
        Vehicle::class => VehiclePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
