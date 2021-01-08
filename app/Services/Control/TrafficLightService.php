<?php


namespace App\Services\Control;

use App\Control\TrafficLight\TrafficLightStatusHasChanged;
use App\Events\Control\TrafficLight\NewSignal;
use App\Interfaces\Control\TrafficLight\CreateTrafficLightInterface;
use App\Models\Control\TrafficLight;
use App\Models\General\History;
use App\Repositories\Interfaces\Control\TrafficLightRepositoryInterface;
use App\Repositories\Interfaces\General\HistoryRepositoryInterface;
use App\Services\Interfaces\Control\TrafficLightServiceInterface;
use App\Services\Interfaces\General\HistoryServiceInterface;

class TrafficLightService implements TrafficLightServiceInterface
{
    private HistoryServiceInterface $historyService;
    private HistoryRepositoryInterface $historyRepository;
    private TrafficLightRepositoryInterface $repository;
    
    public function __construct(HistoryServiceInterface $historyService, HistoryRepositoryInterface $historyRepository, TrafficLightRepositoryInterface $repository)
    {
        $this->historyService = $historyService;
        $this->historyRepository = $historyRepository;
        $this->repository = $repository;
    }
    
    public function createTrafficLight(CreateTrafficLightInterface $createTrafficLight): TrafficLight
    {
        return TrafficLight::create($createTrafficLight->getStreet()->getId(), $createTrafficLight->getDefaultSwitchTime());
    }
    
    public function signalClose(TrafficLight $light): void
    {
        $status = $light->getStatus();
        $light->warn();
        $this->repository->saveTrafficLight($light);
        $this->registerStatusChange($light, $status, TrafficLight::WARNING);
        event(new NewSignal($this, $light, TrafficLight::CLOSED));
    }
    
    public function close(TrafficLight $light)
    {
        $status = $light->getStatus();
        $light->close();
        $this->repository->saveTrafficLight($light);
        $this->registerStatusChange($light, $status, TrafficLight::CLOSED);
    }
    
    private function registerStatusChange(TrafficLight $light, string $from, string $to)
    {
        $history = $this->historyService->createHistory($light, History::UPDATE, new TrafficLightStatusHasChanged($from, $to));
        $this->historyRepository->saveHistory($history);
    }
}