<?php

namespace Tests\Service\Simulation;

use App\Models\Simulation\StreetSample;
use App\Services\Interfaces\Simulation\SimulationServiceInterface;
use App\Simulation\Sample\Street;
use Tests\Stubs\Geographic\StreetStub;
use Tests\TestCase;

class SimulationServiceTest extends TestCase
{
    private SimulationServiceInterface $service;
    //private TrafficLightRepositoryInterface $repository;
    
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

}
