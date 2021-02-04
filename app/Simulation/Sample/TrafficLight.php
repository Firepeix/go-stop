<?php


namespace App\Simulation\Sample;

use App\Models\Control\TrafficLight as TrafficLightModel;
use Carbon\Carbon;

class TrafficLight
{
    private string $id;
    private int $switchTime;
    private string $status;
    private Carbon $lastSwitchedTime;
    
    public function __construct(string $id, int $defaultSwitchTime)
    {
        $this->lastSwitchedTime = Carbon::now()->subSeconds($defaultSwitchTime);
        $this->id = $id;
        $this->switchTime = $defaultSwitchTime;
        $this->status = TrafficLightModel::CLOSED;
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
        $this->status = TrafficLightModel::WARNING;
    }
    
    private function close() : void
    {
        $this->status = TrafficLightModel::CLOSED;
    }
    
    private function open() : void
    {
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
}
