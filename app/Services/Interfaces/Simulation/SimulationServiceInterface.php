<?php


namespace App\Services\Interfaces\Simulation;


use App\Interfaces\Geographic\CreateStreetInterface;
use App\Models\Geographic\Street;
use App\Models\Simulation\StreetSample;
use Illuminate\Support\Collection;

interface SimulationServiceInterface
{
    public function createSample(Collection $streets, Collection $entryStreets, Collection $departureStreets) : StreetSample;
}
