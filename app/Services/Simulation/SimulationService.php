<?php


namespace App\Services\Simulation;


use App\Lists\Queue;
use App\Models\Simulation\StreetSample;
use App\Services\Interfaces\Geographic\StreetServiceInterface;
use App\Services\Interfaces\Simulation\SimulationServiceInterface;
use App\Simulation\Sample\Vehicle;
use App\Simulation\VehicleQueue;
use Illuminate\Support\Collection;

class SimulationService implements SimulationServiceInterface
{
    private StreetServiceInterface $service;
    public function __construct(StreetServiceInterface $service)
    {
        $this->service = $service;
    }
    
    public function createSample(Collection $streets, Collection $entryStreets, Collection $departureStreets): StreetSample
    {
        $sample = $this->service->constructSample($streets);
        return StreetSample::create($sample, $entryStreets, $departureStreets);
    }
    
    public function createVehicleQueue(StreetSample $sample, int $vehicleQuantity, array $appearInterval, float $durationOfTick = 1): VehicleQueue
    {
        $vehicles = new Queue();
        $interval = new Queue();
        for($i = 0; $i < $vehicleQuantity; $i++) {
            $route = $sample->findRandomRoute();
            $vehicles->enqueue(new Vehicle($route->first(), $route->last(), $route));
            $interval->enqueue($appearInterval[$i]);
        }
        return new VehicleQueue($vehicles, $interval, $durationOfTick);
    }
}
