<?php


namespace App\Repositories\Interfaces\Control;

use App\Models\Control\TrafficLight;

interface TrafficLightRepositoryInterface
{
    public function findOrFail(int $id) : TrafficLight;
    
    public function saveTrafficLight(TrafficLight $trafficLight) : void;
}