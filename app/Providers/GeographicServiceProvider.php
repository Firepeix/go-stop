<?php

namespace App\Providers;

use App\Repositories\Geographic\SampleRepository;
use App\Repositories\Geographic\StreetRepository;
use App\Repositories\Interfaces\Geographic\SampleRepositoryInterface;
use App\Repositories\Interfaces\Geographic\StreetRepositoryInterface;
use App\Services\Geographic\SampleService;
use App\Services\Geographic\StreetService;
use App\Services\Interfaces\Geographic\SampleServiceInterface;
use App\Services\Interfaces\Geographic\StreetServiceInterface;
use Illuminate\Support\ServiceProvider;

class GeographicServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(StreetServiceInterface::class, StreetService::class);
        $this->app->bind(StreetRepositoryInterface::class, StreetRepository::class);
        $this->app->bind(SampleServiceInterface::class, SampleService::class);
        $this->app->bind(SampleRepositoryInterface::class, SampleRepository::class);
    }

    public function boot()
    {
    }
}
