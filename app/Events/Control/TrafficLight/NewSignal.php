<?php

namespace App\Events\Control\TrafficLight;

use App\Models\Control\TrafficLight;
use App\Services\Interfaces\Control\TrafficLightServiceInterface;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewSignal
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private TrafficLightServiceInterface $service;
    private TrafficLight $light;
    private string $signal;
    
    public function __construct(TrafficLightServiceInterface $service, TrafficLight $light, string $signal)
    {
        $this->service = $service;
        $this->light   = $light;
        $this->signal  = $signal;
    }
    
    public function getService(): TrafficLightServiceInterface
    {
        return $this->service;
    }
    
    public function getLight(): TrafficLight
    {
        return $this->light;
    }
    
    public function getSignal(): string
    {
        return $this->signal;
    }
}
