<?php

namespace Tests\Service\Simulation;

use App\Models\Simulation\Simulation;
use App\Models\Simulation\StreetSample;
use App\Services\Interfaces\Simulation\SimulationServiceInterface;
use App\Simulation\Sample\Street;
use App\Simulation\Sample\TrafficLight;
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
        $stub = new StreetStub(3, [0 => [1 => false,2 => false], 1 => [2 => false,0 => false], 2 => [1 => false]], [0], [1]);
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
    
    public function testCreateCrossRoadsSample()
    {
        $stub = new StreetStub(4, [0 => [1 => true, 4 => false], 1 => [], 2 => [3 => true], 3 => [], 4 => []], [0], [1,3,4]);
        $streets = $stub->getStreets();
        $entryStreets = $stub->getEntryStreets();
        $departureStreets = $stub->getDepartureStreets();
        $sample = $this->service->createSample($stub->getStreets(), $entryStreets, $departureStreets);
        $sampleStreets = $sample->getStreets();
        $lights = $sample->getTrafficLights();
        $this->assertSame($lights->last()->getId(), $lights->first()->getOpposedTrafficLight());
        $this->assertSame($lights->first()->getId(), $lights->last()->getOpposedTrafficLight());
        $this->assertTrue($sampleStreets[$streets[0]->getId()]->hasTrafficLight($sampleStreets[$streets[1]->getId()]));
        $this->assertFalse($sampleStreets[$streets[0]->getId()]->hasTrafficLight($sampleStreets[$streets[4]->getId()]));
    }
    
    public function testCreateSimulationVehicleQueue()
    {
        $stub = new StreetStub(3, [0 => [1 => false,2 => false], 1 => [2 => false,0 => false], 2 => [1 => false]], [0], [1]);
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
        $stub = new StreetStub(3, [0 => [1 => false,2 => false], 1 => [2 => false,0 => false], 2 => [1 => false]], [0], [1]);
        $sample = $this->service->createSample($stub->getStreets(), $stub->getEntryStreets(), $stub->getDepartureStreets());
        $sample->id = 1;
        $queue = $this->service->createVehicleQueue($sample, 3, [1, 2, 5]);
        $simulation = $this->service->beginSimulation($sample, $queue);
        $this->assertInstanceOf(Simulation::class, $simulation);
        $this->assertSame(3, $simulation->getVehicleQuantity());
        $this->assertSame(1, $simulation->getSampleId());
        $this->assertSame(1, $simulation->getMinSecondInterval());
        $this->assertSame(5, $simulation->getMaxSecondInterval());
        $this->assertNotNull($simulation->getResult());
    }
}
