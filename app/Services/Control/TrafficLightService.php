<?php


namespace App\Services\Control;



use App\Interfaces\Control\CreateTrafficLightInterface;
use App\Models\Control\TrafficLight;
use App\Services\Interfaces\Control\TrafficLightServiceInterface;

class TrafficLightService implements TrafficLightServiceInterface
{
    public function createTrafficLight(CreateTrafficLightInterface $createTrafficLight): TrafficLight
    {
        return TrafficLight::create($createTrafficLight);
    }
}