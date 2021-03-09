<?php


namespace App\Repositories\Interfaces\Control;

use App\Models\Control\TrafficLight;
use App\Repositories\Interfaces\RepositoryInterface;
use Illuminate\Support\Collection;

interface TrafficLightRepositoryInterface extends RepositoryInterface
{
    public function find(int $id): ? TrafficLight;
    
    public function findOrFail(int $id) : TrafficLight;

    public function getTrafficLights() : Collection;
    
    public function saveTrafficLight(TrafficLight $trafficLight) : void;
}
