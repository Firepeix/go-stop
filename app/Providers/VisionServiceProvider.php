<?php

namespace App\Providers;

use App\Repositories\Interfaces\Vision\CameraRepositoryInterface;
use App\Repositories\Vision\CameraRepository;
use App\Services\Interfaces\Vision\CameraServiceInterface;
use App\Services\Vision\CameraService;
use Illuminate\Support\ServiceProvider;

class VisionServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(CameraServiceInterface::class, CameraService::class);
        $this->app->bind(CameraRepositoryInterface::class, CameraRepository::class);
    }

    public function boot()
    {
    }
}
