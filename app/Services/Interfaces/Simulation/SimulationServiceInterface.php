<?php


namespace App\Services\Interfaces\Simulation;


use App\Models\Simulation\Simulation;
use App\Models\Simulation\StreetSample;
use App\Simulation\VehicleQueue;
use Illuminate\Support\Collection;

interface SimulationServiceInterface
{
    public function createSample(Collection $streets, Collection $entryStreets, Collection $departureStreets) : StreetSample;
    
    public function createVehicleQueue(StreetSample $sample, int $vehicleQuantity, array $appearInterval, float $durationOfTick = 1) : VehicleQueue;
    
    public function beginSimulation(StreetSample $sample, VehicleQueue $queue) : Simulation;
}
