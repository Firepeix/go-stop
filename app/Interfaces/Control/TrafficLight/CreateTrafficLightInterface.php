<?php


namespace App\Interfaces\Control\TrafficLight;

use App\Models\Geographic\Street;

interface CreateTrafficLightInterface
{
    public function getStreet() : Street;
    
    public function getDefaultSwitchTime() : int;
}