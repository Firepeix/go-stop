<?php


namespace App\Simulation\Sample;


use Illuminate\Support\Collection;

class Vehicle
{
    private int $entryId;
    private int $departureId;
    private Collection $route;
    
    public function __construct(int $entryId, int $departureId, Collection $route)
    {
        $this->entryId     = $entryId;
        $this->departureId = $departureId;
        $this->route     = $route;
    }
}
