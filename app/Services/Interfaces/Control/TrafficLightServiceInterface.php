<?php


namespace App\Services\Interfaces\Control;


use App\Interfaces\Control\TrafficLight\CreateTrafficLightInterface;
use App\Models\Control\TrafficLight;

interface TrafficLightServiceInterface
{
    public function createTrafficLight(CreateTrafficLightInterface $createTrafficLight) : TrafficLight;
    
    public function signalClose(TrafficLight $light) : void;
    
    public function signalOpen(TrafficLight $light) : void;
    
    public function close(TrafficLight $light);
}