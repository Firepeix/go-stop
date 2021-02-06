<?php


namespace App\Services\Simulation;


use App\Lists\Queue;
use App\Models\Simulation\Simulation;
use App\Models\Simulation\StreetSample;
use App\Services\Interfaces\Geographic\StreetServiceInterface;
use App\Services\Interfaces\Simulation\SimulationServiceInterface;
use App\Simulation\Sample\TrafficLight;
use App\Simulation\Sample\Vehicle;
use App\Simulation\VehicleQueue;
use Illuminate\Support\Collection;
use JetBrains\PhpStorm\ArrayShape;

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
    
    public function beginSimulation(StreetSample $sample, VehicleQueue $queue) : Simulation
    {
        $lights = $sample->getTrafficLights();
        $quantity = $queue->getTotalVehicles();
        $result = $this->simulate($lights, $queue, $quantity);
        return Simulation::Create($queue, $sample, $result);
    }
    
    #[ArrayShape(['vehicles' => "\Illuminate\Support\Collection", 'trafficLights' => "\Illuminate\Support\Collection"])]
    public function simulate(Collection $trafficLights, VehicleQueue $queue, int $quantity) : array
    {
        $finishedVehicles = new Collection();
        $allVehiclesHistory = new Collection();
        $vehicles = $queue->getVehicles();
    
        while ($finishedVehicles->count() < $quantity) {
            $vehicles = $vehicles->merge($queue->getVehicles());
            foreach ($vehicles as $id => $vehicle) {
                if ($finishedVehicles->search($id) === false) {
                    if ($vehicles[$id]->hasArrived()) {
                        $finishedVehicles->push($id);
                        $allVehiclesHistory->put($id, $vehicles[$id]);
                    } else {
                        $trafficLight = $trafficLights[$vehicle->isOn()][$vehicle->waitingOn()];
                        if ($trafficLight->isOpen()) {
                            $vehicles[$id]->advance();
                        
                        }
                    }
                }
            }
            sleep(0.9);
        }
        
        return [
            'vehicles' =>  $allVehiclesHistory->map(fn (Vehicle $vehicle) => $vehicle->getHistory()),
            'trafficLights' =>  $trafficLights->map(fn (Collection $onStreets) => $onStreets->map(fn (TrafficLight $light) => $light->getHistory()))
        ];
    }
}
