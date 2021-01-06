<?php


namespace App\Services\Interfaces\Control;


use App\Interfaces\Control\CreateTrafficLightInterface;
use App\Models\Control\TrafficLight;

interface TrafficLightServiceInterface
{
    public function createTrafficLight(CreateTrafficLightInterface $createTrafficLight) : TrafficLight;
}