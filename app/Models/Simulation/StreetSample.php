<?php

namespace App\Models\Simulation;

use App\Models\AbstractModel;
use App\Simulation\Sample\Street;
use App\Simulation\Sample\TrafficLight;
use Illuminate\Support\Collection;

class StreetSample extends AbstractModel
{
    private ? Collection $decodedSample;
    private ? Collection $streets;
    private ? Collection $entryStreets;
    private ? Collection $departureStreets;
    private Collection $routes;
    
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->decodedSample = null;
        $this->streets = null;
        $this->entryStreets = null;
        $this->departureStreets = null;
        $this->routes = new Collection();
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
    
    /**
     * @return Collection|Street[]
     */
    public function getStreets() : Collection|array
    {
        if ($this->streets === null) {
            $sample = $this->getDecodedSample();
            $this->streets = $this->getDecodedSample()->map(fn(array $street) => Street::Sample($street, $sample));
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
    
    public function findRandomRoute() : Collection
    {
        if ($this->routes->isEmpty()) {
            $entry = $this->getEntryStreets()->random();
            $this->processRoutes(new Collection([$entry->getId()]));
        }
        return $this->routes->random();
    }
    
    public function processRoutes(Collection $visited) : void
    {
        $departure = $this->getDepartureStreets()->random();
        $streets = $this->getStreets()[$visited->last()]->getOutgoingStreetsId();
        foreach ($streets as $street) {
            if ($visited->search($street) !== false) {
                continue;
            }
            if ($street === $departure->getId()) {
                $visited->push($street);
                $this->routes->push(clone $visited);
                $visited->pop();
                break;
            }
        }
        foreach ($streets as $street) {
            if ($visited->search($street) !== false || $street === $departure->getId()) {
                continue;
            }
            
            $visited->push($street);
            $this->processRoutes($visited);
            $visited->pop();
        }
        
    }
    
    public function getTrafficLight(string $isOn, string $goingTo) : TrafficLight
    {
        $actualStreet = $this->getStreets()[$isOn];
        return $actualStreet->getTrafficLight($goingTo);
    }
    
    public function getTrafficLights() : Collection
    {
        $trafficLights = new Collection();
        foreach ($this->getStreets() as $street) {
            if ($street->getOutgoingLights()->isNotEmpty()) {
                $trafficLights->put($street->getId(), $street->getOutgoingLights());
            }
        }
        
        return $trafficLights;
    }
}
