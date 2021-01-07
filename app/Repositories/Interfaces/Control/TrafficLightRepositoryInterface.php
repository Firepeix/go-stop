<?php


namespace App\Repositories\Interfaces\Control;

use App\Models\Control\TrafficLight;
use Illuminate\Support\Collection;

interface TrafficLightRepositoryInterface
{
    public function findOrFail(int $id) : TrafficLight;

    public function getTrafficLights() : Collection;
    
    public function saveTrafficLight(TrafficLight $trafficLight) : void;
}