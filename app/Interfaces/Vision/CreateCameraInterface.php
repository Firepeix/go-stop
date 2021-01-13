<?php


namespace App\Interfaces\Vision;


use App\Models\Control\TrafficLight;

interface CreateCameraInterface
{
    public function getTrafficLight() : TrafficLight;
    
    public function getCameraView() : string;
}