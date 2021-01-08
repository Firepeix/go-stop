<?php

namespace App\Providers;

use App\Repositories\General\HistoryRepository;
use App\Repositories\Interfaces\General\HistoryRepositoryInterface;
use App\Services\General\HistoryService;
use App\Services\Interfaces\General\HistoryServiceInterface;
use Illuminate\Support\ServiceProvider;

class GeneralServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(HistoryServiceInterface::class, HistoryService::class);
        $this->app->bind(HistoryRepositoryInterface::class, HistoryRepository::class);
    }

    public function boot()
    {
    }
}
