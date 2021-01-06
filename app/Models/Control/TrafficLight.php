<?php

namespace App\Models\Control;

use App\Interfaces\Control\CreateTrafficLightInterface;
use App\Models\AbstractModel;
use App\Models\Geographic\Street;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TrafficLight extends AbstractModel
{
    const CLOSED = '0';
    const WARNING = '1';
    const OPEN = '2';
    
    public function street() : BelongsTo
    {
        return $this->belongsTo(Street::class);
    }
    
    public static function create(CreateTrafficLightInterface $createTrafficLight) : self
    {
        $light = new self();
        $light->street_id = $createTrafficLight->getStreet()->getId();
        $light->status = self::CLOSED;
        return $light;
    }
    
    public function getStatus() : int
    {
        return $this->status;
    }
    
    public function getStreet() : Street
    {
        return $this->street;
    }
    
    public static function getAvailableStatus() : array
    {
        return [self::CLOSED, self::WARNING, self::OPEN];
    }
}
