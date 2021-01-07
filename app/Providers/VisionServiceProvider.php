<?php

namespace App\Providers;

use App\Repositories\Interfaces\Vision\CameraRepositoryInterface;
use App\Repositories\Interfaces\Vision\ImageRepositoryInterface;
use App\Repositories\Vision\CameraRepository;
use App\Repositories\Vision\ImageRepository;
use App\Services\Interfaces\Vision\CameraServiceInterface;
use App\Services\Interfaces\Vision\ImageServiceInterface;
use App\Services\Vision\CameraService;
use App\Services\Vision\ImageService;
use Illuminate\Support\ServiceProvider;

class VisionServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(CameraServiceInterface::class, CameraService::class);
        $this->app->bind(CameraRepositoryInterface::class, CameraRepository::class);
        
        $this->app->bind(ImageServiceInterface::class, ImageService::class);
        $this->app->bind(ImageRepositoryInterface::class, ImageRepository::class);
    }

    public function boot()
    {
    }
}
