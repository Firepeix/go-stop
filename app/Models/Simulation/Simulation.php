<?php

namespace App\Models\Simulation;

use App\Models\AbstractModel;
use App\Simulation\VehicleQueue;

class Simulation extends AbstractModel
{
    public static function Create(VehicleQueue $queue, StreetSample $sample, array $result) : self
    {
        $simulation = new Simulation();
        $simulation->vehicle_quantity = $queue->getTotalVehicles();
        $simulation->sample_id = $sample->getId();
        $simulation->min_second_interval = $queue->getMinSecondAppearInterval();
        $simulation->max_second_interval = $queue->getMaxSecondAppearInterval();
        $simulation->result = json_encode($result);
        return $simulation;
    }
    
    public function getVehicleQuantity() : int
    {
        return $this->vehicle_quantity;
    }
    
    public function getSampleId() : int
    {
        return $this->sample_id;
    }
    
    public function getMinSecondInterval() : int
    {
        return $this->min_second_interval;
    }
    
    public function getMaxSecondInterval() : int
    {
        return $this->max_second_interval;
    }
    
    public function getResult() : ? array
    {
        return $this->result !== null ? json_decode($this->result, true) : null;
    }
}
