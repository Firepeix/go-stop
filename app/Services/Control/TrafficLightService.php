<?php


namespace App\Services\Control;

use App\Control\TrafficLight\TrafficLightStatusHasChanged;
use App\Events\Control\TrafficLight\NewSignal;
use App\Interfaces\Control\TrafficLight\CreateTrafficLightInterface;
use App\Models\Control\TrafficLight;
use App\Models\General\History;
use App\Models\Geographic\Street;
use App\Repositories\Interfaces\Control\TrafficLightRepositoryInterface;
use App\Repositories\Interfaces\General\HistoryRepositoryInterface;
use App\Services\Interfaces\Control\TrafficLightServiceInterface;
use App\Services\Interfaces\General\HistoryServiceInterface;
use Illuminate\Support\Collection;

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
    
    public function signalOpen(TrafficLight $light): void
    {
        $status = $light->getStatus();
        $light->open();
        $this->repository->saveTrafficLight($light);
        $this->registerStatusChange($light, $status, TrafficLight::OPEN);
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
    
    /**
     * @param TrafficLight[]|Collection $lights
     * @param int $direction
     * @return array
     */
    public function constructSample(array|Collection $lights, int $direction): array
    {
        $sample = [];
        foreach ($lights as $light) {
            $sample[$light->getId()] = [
                'info' => $light->toArray(),
                'streets' => $light->getStreets($direction)->map(fn(Street $street) => $street->toArray())
            ];
            
        }
        
        return $sample;
    }
}
