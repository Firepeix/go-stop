<?php

namespace Tests\Stubs\Geographic;

use App\Models\Control\TrafficLight;
use App\Models\Geographic\Street;
use Illuminate\Support\Collection;

class StreetStub
{
    /**
     * @var Street[]|Collection
     */
    private Collection|array $streets;
    
    /**
     * @var Street[]
     */
    private array $entryStreets;
    
    /**
     * @var Street[]
     */
    private array $departureStreets;
    
    public function __construct(int $quantity, array $connections, array $entryStreets, array $departureStreets, bool $directConnection = false)
    {
        $this->streets = $this->createStreets($quantity);
        $this->connect($connections, $directConnection);
        $this->setEntryAndDeparture($entryStreets, $departureStreets);
    }
    
    private function createStreets(int $quantity) : Collection
    {
        return Street::factory()->count($quantity)->make();
    }
    
    private function connect(array $connections, bool $directConnection) : void
    {
        foreach ($this->streets as $key => $street) {
           if (isset($connections[$key])) {
               foreach ($connections[$key] as $connection => $lightGroupId) {
                   if ($lightGroupId !== null) {
                       $trafficLight = TrafficLight::factory()->make(['group_id' => $lightGroupId]);
                       $trafficLight->incomingStreets = new Collection([$this->streets[$key]]);
                       $trafficLight->outgoingStreets = new Collection([$this->streets[$connection]]);
                       $this->streets[$connection]->incomingTrafficLights->push($trafficLight);
                       $this->streets[$key]->outgoingTrafficLights->push($trafficLight);
                   }
                  
                   if ($directConnection || $lightGroupId === null) {
                       $this->streets[$connection]->incomingStreets->push($this->streets[$key]);
                       $this->streets[$key]->outgoingStreets->push($this->streets[$connection]);
                   }
               }
           }
        }
        
    }
    
    private function setEntryAndDeparture(array $entryStreets, array $departureStreets)
    {
        $this->entryStreets = [];
        $this->departureStreets = [];
        foreach ($entryStreets as $entryStreet) {
            $this->entryStreets[] = $this->streets[$entryStreet];
        }
    
        
        foreach ($departureStreets as $departureStreet) {
            $this->departureStreets[] = $this->streets[$departureStreet];
        }
    }
    
    /**
     * @return Street[]|Collection
     */
    public function getStreets(): array|Collection
    {
        return $this->streets;
    }
    
    /**
     * @return Street[]|Collection
     */
    public function getEntryStreets(): Collection|array
    {
        return new Collection($this->entryStreets);
    }
    
    /**
     * @return Street[]|Collection
     */
    public function getDepartureStreets(): Collection|array
    {
        return new Collection($this->departureStreets);
    }
    
    
}
