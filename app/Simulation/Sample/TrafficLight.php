<?php


namespace App\Simulation\Sample;

use App\Models\Control\TrafficLight as TrafficLightModel;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class TrafficLight
{
    private string $id;
    private int $switchTime;
    private string $status;
    private Carbon $lastSwitchedTime;
    private Collection $history;
    
    public function __construct(string $id, int $defaultSwitchTime)
    {
        $this->lastSwitchedTime = Carbon::now()->subSeconds($defaultSwitchTime);
        $this->id = $id;
        $this->switchTime = $defaultSwitchTime;
        $this->status = TrafficLightModel::CLOSED;
        $this->history     = new Collection();
    }
    
    private function checkTimer() : void
    {
        if ($this->lastSwitchedTime->diffInSeconds(Carbon::now()) >= $this->switchTime) {
            if ($this->status === TrafficLightModel::CLOSED) {
                $this->open();
            } else if ($this->status === TrafficLightModel::OPEN) {
                $this->warn();
            } else {
                $this->close();
            }
            $this->lastSwitchedTime = Carbon::now();
        }
    }
    
    private function warn()
    {
        $this->history->push(['from' => $this->status, 'to' => TrafficLightModel::WARNING, 'time' => Carbon::now()->toDateTimeString()]);
        $this->status = TrafficLightModel::WARNING;
    }
    
    private function close() : void
    {
        $this->history->push(['from' => $this->status, 'to' => TrafficLightModel::CLOSED, 'time' => Carbon::now()->toDateTimeString()]);
        $this->status = TrafficLightModel::CLOSED;
    }
    
    private function open() : void
    {
        $this->history->push(['from' => $this->status, 'to' => TrafficLightModel::OPEN, 'time' => Carbon::now()->toDateTimeString()]);
        $this->status = TrafficLightModel::OPEN;
    }
    
    public function isOpen() : bool
    {
        $this->checkTimer();
        return $this->status === TrafficLightModel::OPEN;
    }
    
    public function isClosed() : bool
    {
        $this->checkTimer();
        return $this->status === TrafficLightModel::CLOSED;
    }
    
    public function getHistory(): array
    {
        return $this->history->toArray();
    }
}
