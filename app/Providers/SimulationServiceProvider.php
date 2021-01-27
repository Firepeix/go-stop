<?php

namespace App\Providers;

use App\Services\Interfaces\Simulation\SimulationServiceInterface;
use App\Services\Simulation\SimulationService;
use Illuminate\Support\ServiceProvider;

class SimulationServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(SimulationServiceInterface::class, SimulationService::class);
    }

    public function boot()
    {
    }
}
