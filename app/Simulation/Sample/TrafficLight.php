<?php


namespace App\Simulation\Sample;

use App\Models\Control\TrafficLight as TrafficLightModel;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class TrafficLight
{
    private string     $id;
    private int        $switchTime;
    private int        $groupId;
    private string     $status;
    private Carbon     $lastSwitchedTime;
    private Collection $history;
    private Collection $oppositeLightsIds;
    
    private function __construct(string $id, int $defaultSwitchTime, int $groupId, Collection $oppositeLightsIds)
    {
        $this->lastSwitchedTime  = Carbon::now()->subSeconds($defaultSwitchTime);
        $this->id                = $id;
        $this->switchTime        = $defaultSwitchTime;
        $this->status            = TrafficLightModel::CLOSED;
        $this->history           = new Collection();
        $this->groupId           = $groupId;
        $this->oppositeLightsIds = $oppositeLightsIds;
    }
    
    public static function Sample(string $id, array $lightSample, Collection $sample) : TrafficLight
    {
        $oppositeLights = new Collection();
        $groupId = $lightSample['info']['groupId'];
        foreach ($sample as $street) {
            foreach (TrafficLightModel::getAvailableDirections() as $availableDirection) {
                $connections = $street[$availableDirection]['throughTrafficLightsStreets'];
                foreach ($connections as $lightId => $light) {
                    if ($lightId !== $id && $light['info']['groupId'] === $groupId) {
                        $oppositeLights->push($lightId);
                    }
                }
            }
        }
    
        return new TrafficLight($id, $lightSample['info']['defaultSwitchTime'], $groupId, $oppositeLights->unique());
    }
    
    public function getId(): string
    {
        return $this->id;
    }
    
    private function checkTimer(): void
    {
        if ($this->lastSwitchedTime->diffInSeconds(Carbon::now()) >= $this->switchTime) {
            if ($this->status === TrafficLightModel::CLOSED) {
                $this->open();
            } else {
                if ($this->status === TrafficLightModel::OPEN) {
                    $this->warn();
                } else {
                    $this->close();
                }
            }
            $this->lastSwitchedTime = Carbon::now();
        }
    }
    
    private function warn()
    {
        $this->history->push(['from' => $this->status, 'to' => TrafficLightModel::WARNING, 'time' => Carbon::now()->toDateTimeString()]);
        $this->status = TrafficLightModel::WARNING;
    }
    
    private function close(): void
    {
        $this->history->push(['from' => $this->status, 'to' => TrafficLightModel::CLOSED, 'time' => Carbon::now()->toDateTimeString()]);
        $this->status = TrafficLightModel::CLOSED;
    }
    
    private function open(): void
    {
        $this->history->push(['from' => $this->status, 'to' => TrafficLightModel::OPEN, 'time' => Carbon::now()->toDateTimeString()]);
        $this->status = TrafficLightModel::OPEN;
    }
    
    public function isOpen(): bool
    {
        $this->checkTimer();
        return $this->status === TrafficLightModel::OPEN;
    }
    
    public function isClosed(): bool
    {
        $this->checkTimer();
        return $this->status === TrafficLightModel::CLOSED;
    }
    
    public function getHistory(): array
    {
        return $this->history->toArray();
    }
    
    public function getOppositeTrafficLights(): Collection
    {
        return $this->oppositeLightsIds;
    }
}
