<?php

namespace App\Models\Simulation;

use App\Models\AbstractModel;
use App\Simulation\Sample\Street;
use Illuminate\Support\Collection;

class StreetSample extends AbstractModel
{
    private ? Collection $decodedSample;
    private ? Collection $streets;
    private ? Collection $entryStreets;
    private ? Collection $departureStreets;
    
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->decodedSample = null;
        $this->streets = null;
        $this->entryStreets = null;
        $this->departureStreets = null;
    }
    
    public static function create(array $streetSample, Collection $entryStreets, Collection $departureStreets) : StreetSample
    {
        $sample = new StreetSample();
        $sample->entries = json_encode($entryStreets->pluck('id')->toArray());
        $sample->departures = json_encode($departureStreets->pluck('id')->toArray());
        $sample->sample = json_encode($streetSample);
        return $sample;
    }
    
    private function getDecodedSample() : Collection
    {
        if ($this->decodedSample === null) {
            $this->decodedSample = new Collection(json_decode($this->sample, true));
        }
        return $this->decodedSample;
    }
    
    public function getStreets() : Collection
    {
        if ($this->streets === null) {
            $this->streets = $this->getDecodedSample()->map(fn(array $street) => Street::Sample($street));
        }
        return $this->streets;
    }
    
    public function getEntryStreets() : Collection
    {
        if ($this->entryStreets === null) {
            $this->entryStreets = $this->findOutsideSystemStreets(json_decode($this->entries));
        }
        return $this->entryStreets;
    }
    
    public function getDepartureStreets() : Collection
    {
        if ($this->departureStreets === null) {
            $this->departureStreets = $this->findOutsideSystemStreets(json_decode($this->departures));
        }
        return $this->departureStreets;
    }
    
    private function findOutsideSystemStreets(array $streets) : Collection
    {
        $sampleStreets = $this->getStreets();
        $outsideStreets = new Collection();
        foreach ($streets as $street) {
            $outsideStreets->put($street, $sampleStreets[$street]);
        }
        
        return $outsideStreets;
    }
}
