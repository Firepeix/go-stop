<?php


namespace App\Services\Interfaces\Geographic;


use App\Models\Control\TrafficLight;
use App\Models\Geographic\Sample;
use Illuminate\Support\Collection;

interface SampleServiceInterface
{
    public function record(Sample $sample, int $action) : bool;
    
    public function getRate(Sample $sample, ? TrafficLight $trafficLight) : Collection;
}
