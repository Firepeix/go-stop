<?php

namespace App\Models\Control;

use App\Models\AbstractModel;

class TrafficLight extends AbstractModel
{
    const CLOSED = 0;
    const WARNING = 1;
    const OPEN = 2;
    
    public static function getAvailableStatus() : array
    {
        return [self::CLOSED, self::WARNING, self::OPEN];
    }
}
