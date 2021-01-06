<?php


namespace App\Repositories\Control;

use App\Models\Control\TrafficLight;
use App\Repositories\Interfaces\Control\TrafficLightRepositoryInterface;

class TrafficLightRepository implements TrafficLightRepositoryInterface
{
    public function findOrFail(int $id): TrafficLight
    {
        return TrafficLight::findOrFail($id);
    }
    
    public function saveTrafficLight(TrafficLight $trafficLight): void
    {
        $trafficLight->save();
    }
}