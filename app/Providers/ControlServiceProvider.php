<?php

namespace App\Providers;

use App\Repositories\Control\TrafficLightRepository;
use App\Repositories\Interfaces\Control\TrafficLightRepositoryInterface;
use App\Services\Control\TrafficLightService;
use App\Services\Interfaces\Control\TrafficLightServiceInterface;
use Illuminate\Support\ServiceProvider;

class ControlServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(TrafficLightServiceInterface::class, TrafficLightService::class);
        $this->app->bind(TrafficLightRepositoryInterface::class, TrafficLightRepository::class);
    }

    public function boot()
    {
    }
}
