<?php

namespace App\Jobs\Control\TrafficLight;

use App\Models\Control\TrafficLight;
use App\Services\Interfaces\Control\TrafficLightServiceInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class StatusStop implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $service;
    private $light;
    
    public function __construct(TrafficLightServiceInterface $service, TrafficLight $light)
    {
        $this->service = $service;
        $this->light = $light;
    }
    
    public function handle()
    {
        $this->service->close($this->light);
    }
}
