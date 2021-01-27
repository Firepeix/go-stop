<?php


namespace App\Services\Simulation;


use App\Models\Simulation\StreetSample;
use App\Services\Interfaces\Geographic\StreetServiceInterface;
use App\Services\Interfaces\Simulation\SimulationServiceInterface;
use Illuminate\Support\Collection;

class SimulationService implements SimulationServiceInterface
{
    private StreetServiceInterface $service;
    public function __construct(StreetServiceInterface $service)
    {
        $this->service = $service;
    }
    
    public function createSample(Collection $streets, Collection $entryStreets, Collection $departureStreets): StreetSample
    {
        $sample = $this->service->constructSample($streets);
        return StreetSample::create($sample, $entryStreets, $departureStreets);
    }
}
