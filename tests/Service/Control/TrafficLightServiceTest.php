<?php

namespace Tests\Service\Control;

use App\Models\Control\TrafficLight;
use App\Models\General\History;
use App\Repositories\Interfaces\Control\TrafficLightRepositoryInterface;
use App\Services\Interfaces\Control\TrafficLightServiceInterface;
use Tests\TestCase;

class TrafficLightServiceTest extends TestCase
{
    private TrafficLightServiceInterface $service;
    private TrafficLightRepositoryInterface $repository;
    
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->createApplication();
        $this->service = app()->make(TrafficLightServiceInterface::class);
    }
    
    private function getTrafficLightStub(bool $open = false) : TrafficLight
    {
        $factory = TrafficLight::factory();
        if ($open) {
            return $factory->open()->create();
        }
        return $factory->create();
    }
    
    public function testSignalClose() : void
    {
        $light = $this->getTrafficLightStub(true);
        $this->service->signalClose($light);
        $this->assertSame(TrafficLight::WARNING, $light->getStatus());
        $this->assertDatabaseHas('histories', [
            'entity_id' => $light->getId(),
            'action' => History::UPDATE,
            'metadata' => json_encode(['from' => TrafficLight::OPEN, 'to' => TrafficLight::WARNING])
        ]);
        $this->assertSame(TrafficLight::CLOSED, $light->refresh()->getStatus());
        $this->assertDatabaseHas('histories', [
            'entity_id' => $light->getId(),
            'action' => History::UPDATE,
            'metadata' => json_encode(['from' => TrafficLight::WARNING, 'to' => TrafficLight::CLOSED])
        ]);
    }
    
    public function testSignalOpen() : void
    {
        $light = $this->getTrafficLightStub();
        $this->service->signalOpen($light);
        $this->assertSame(TrafficLight::OPEN, $light->refresh()->getStatus());
        $this->assertDatabaseHas('histories', [
            'entity_id' => $light->getId(),
            'action' => History::UPDATE,
            'metadata' => json_encode(['from' => TrafficLight::CLOSED, 'to' => TrafficLight::OPEN])
        ]);
    }
}
