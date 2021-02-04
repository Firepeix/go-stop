<?php

namespace Tests\Service\Simulation;

use App\Models\Simulation\Simulation;
use App\Models\Simulation\StreetSample;
use App\Services\Interfaces\Simulation\SimulationServiceInterface;
use App\Simulation\Sample\Street;
use App\Simulation\Sample\Vehicle;
use App\Simulation\VehicleQueue;
use Tests\Stubs\Geographic\StreetStub;
use Tests\TestCase;

class SimulationServiceTest extends TestCase
{
    private SimulationServiceInterface $service;
    
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->createApplication();
        $this->service = app()->make(SimulationServiceInterface::class);
    }
    
    public function testCreateSample()
    {
        $stub = new StreetStub(3, [0 => [1,2], 1 => [2,0], 2 => [1]], [0], [1]);
        $streets = $stub->getStreets();
        $entryStreets = $stub->getEntryStreets();
        $departureStreets = $stub->getDepartureStreets();
        $sample = $this->service->createSample($stub->getStreets(), $entryStreets, $departureStreets);
        $this->assertInstanceOf(StreetSample::class, $sample);
        $this->assertSame($streets->count(), $sample->getStreets()->count());
        $this->assertSame($entryStreets->count(), $sample->getEntryStreets()->count());
        $this->assertSame($departureStreets->count(), $sample->getDepartureStreets()->count());
        $this->assertSame($streets->count(), $sample->getStreets()->filter(fn(Street $street) => in_array($street->getName(), $streets->pluck('name')->toArray()))->count());
        $this->assertSame($entryStreets->count(), $sample->getEntryStreets()->filter(fn(Street $street) => in_array($street->getName(), $entryStreets->pluck('name')->toArray()))->count());
        $this->assertSame($departureStreets->count(), $sample->getDepartureStreets()->filter(fn(Street $street) => in_array($street->getName(), $departureStreets->pluck('name')->toArray()))->count());
    }
    
    public function testCreateSimulationVehicleQueue()
    {
        $stub = new StreetStub(3, [0 => [1,2], 1 => [2,0], 2 => [1]], [0], [1]);
        $sample = $this->service->createSample($stub->getStreets(), $stub->getEntryStreets(), $stub->getDepartureStreets());
        $queue = $this->service->createVehicleQueue($sample, 2, [1,3]);
        $this->assertInstanceOf(VehicleQueue::class, $queue);
        $this->assertTrue($queue->getVehicles()->isEmpty());
        sleep(2);
        $cars = $queue->getVehicles();
        $this->assertTrue($cars->isNotEmpty());
        $this->assertSame(1, $cars->count());
        $this->assertInstanceOf(Vehicle::class, $cars->first());
        $this->assertTrue($queue->getVehicles()->isEmpty());
        sleep(2);
        $cars = $queue->getVehicles();
        $this->assertTrue($cars->isNotEmpty());
        $this->assertSame(1, $cars->count());
        $this->assertInstanceOf(Vehicle::class, $cars->first());
    }
    
    public function testBeginSimulation()
    {
        $stub = new StreetStub(3, [0 => [1,2], 1 => [2,0], 2 => [1]], [0], [1]);
        dump($stub->getStreets()->pluck('id'));
        $sample = $this->service->createSample($stub->getStreets(), $stub->getEntryStreets(), $stub->getDepartureStreets());
        $queue = $this->service->createVehicleQueue($sample, 3, [1, 2, 5]);
        $simulation = $this->service->beginSimulation($sample, $queue);
        $this->assertInstanceOf(Simulation::class, $simulation);
        
    }
}
