<?php


namespace App\Simulation;


use App\Lists\Queue;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class VehicleQueue
{
    private Queue  $vehicles;
    private Queue  $interval;
    private Collection  $wholeIntervals;
    private float  $standardTickTime;
    private Carbon $relativeTime;
    private int    $totalVehicles;
    
    public function __construct(Queue $vehicles, Queue $interval, float $standardTickTime)
    {
        $this->vehicles         = $vehicles;
        $this->totalVehicles    = $vehicles->count();
        $this->interval         = $interval;
        $this->wholeIntervals   = $interval->toList();
        $this->standardTickTime = $standardTickTime;
        $this->relativeTime     = Carbon::now();
    }
    
    public function begin(Carbon $carbon): void
    {
        $this->relativeTime = $carbon;
    }
    
    public function getVehicles(): Collection
    {
        $releaseCars = new Collection();
        $now         = Carbon::now();
        $gotAll      = false;
        while (!$gotAll && !$this->interval->isEmpty() && !$this->vehicles->isEmpty()) {
            $time = $this->getReleaseTime($this->interval[0]);
            if ($now->setMilliseconds(0)->isAfter($time->setMilliseconds(0))) {
                $vehicle = $this->vehicles->dequeue();
                $this->interval->dequeue();
                $releaseCars->put($vehicle->getId(), $vehicle);
            } else {
                $gotAll = true;
            }
        }
        
        return $releaseCars;
    }
    
    private function getReleaseTime(int $interval): Carbon
    {
        $time = $this->relativeTime->clone();
        $time->addSeconds(($interval * $this->standardTickTime));
        return $time;
    }
    
    public function getTotalVehicles(): int
    {
        return $this->totalVehicles;
    }
    
    public function getStandardTickTime(): float
    {
        return $this->standardTickTime;
    }
    
    public function getMinSecondAppearInterval() : int
    {
        return $this->wholeIntervals->min();
    }
    
    public function getMaxSecondAppearInterval() : int
    {
        return $this->wholeIntervals->max();
    }
}
