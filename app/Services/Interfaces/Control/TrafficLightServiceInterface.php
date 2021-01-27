<?php


namespace App\Services\Interfaces\Control;


use App\Interfaces\Control\TrafficLight\CreateTrafficLightInterface;
use App\Models\Control\TrafficLight;
use Illuminate\Support\Collection;

interface TrafficLightServiceInterface
{
    public function createTrafficLight(CreateTrafficLightInterface $createTrafficLight) : TrafficLight;
    
    public function signalClose(TrafficLight $light) : void;
    
    public function signalOpen(TrafficLight $light) : void;
    
    public function close(TrafficLight $light);
    
    /**
     * @param Collection|TrafficLight[] $lights
     * @param int $direction
     * @return array
     */
    public function constructSample(Collection|array $lights, int $direction) : array;
}
