<?php

namespace App\Models\Geographic;


use App\Interfaces\Geographic\CreateStreetInterface;
use App\Models\AbstractModel;
use App\Models\Control\TrafficLight;
use App\Primitives\Position;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Support\Collection;

class Street extends AbstractModel
{
    public function outgoingStreets() : HasManyThrough
    {
        return $this->hasManyThrough(Street::class, TrafficLight::class, 'outgoing_street_id', 'id', 'id', 'incoming_street_id');
    }
    
    public function incomingStreets() : HasManyThrough
    {
        return $this->hasManyThrough(Street::class, StreetConnection::class, 'incoming_street_id', 'id', 'id', 'outgoing_street_id');
    }
    
    public function incomingTrafficLights() : HasMany
    {
        return $this->hasMany(TrafficLight::class, 'outgoing_street_id');
    }
    
    public function outgoingTrafficLights() : HasMany
    {
        return $this->hasMany(TrafficLight::class, 'incoming_street_id');
    }
    
    public static function create(CreateStreetInterface $createStreet) : self
    {
        $street = new Street();
        $street->name = $createStreet->getName();
        return $street;
    }
    
    public function getName() : string
    {
        return $this->name;
    }
    
    public function getUUID() : string
    {
        return $this->uuid;
    }
    
    public function getSampleId() : int
    {
        return $this->sample_id;
    }
    
    public function getOutgoingStreetsUUIDs() : array
    {
        return json_decode($this->outgoing_streets);
    }
    
    public function getOutgoingTrafficLightsUUIDs() : array
    {
        return json_decode($this->outgoing_traffic_lights);
    }
    
    public function getGraphPosition(): Position
    {
        return new Position($this->graph_position_x, $this->graph_position_y);
    }
    
    public function getStreets(int $direction) : Collection
    {
        return $direction === TrafficLight::INCOMING ? $this->incomingStreets : $this->outgoingStreets;
    }
    
    public function getTrafficLights(int $direction) : Collection
    {
        return $direction === TrafficLight::INCOMING ? $this->incomingTrafficLights : $this->outgoingTrafficLights;
    }
    
    public function toArray() : array
    {
        return ['id' => $this->id, 'name' => $this->name];
    }
    
    /**
     * @param Collection|Street[] $streets
     * @return Collection|Street[]
     */
    public function getConnectedStreets(Collection|array $streets) : Collection|array
    {
        $streets = $streets->mapWithKeys(fn(Street $street) => [$street->getId() => $street]);
        $adjacentStreets = self::getRelatedStreetsMap($streets);
        $connectedStreets = new Collection();
        $visited = $streets->map(fn() => false);
        $keys = $visited->keys();
        $streetIndex = 0;
        foreach ($keys as $key => $i) {
            $street = $streets[$i];
            if (isset($visited[$i]) && $visited[$i] === false) {
                $streetIndex++;
                $this->findRelatedStreetsUsingBfs($streetIndex, $street, $visited, $adjacentStreets);
            }
            
            return $connectedStreets->merge($streets->intersectByKeys($visited->filter()));
        }
        
        return new Collection();
    }
    
    private function findRelatedStreetsUsingBfs(int $streetIndex, Street $street, Collection $visited, Collection $adjacentStreets) : void
    {
        $queue = new Collection();
        $queue->push($street);
        $visited[$street->getId()] = $streetIndex;
        while ($queue->isNotEmpty()) {
            $node = $queue->pop();
            $connectedStreets = $adjacentStreets[$node->getId()] ?? new Collection();
            foreach ($connectedStreets as $connectedStreet) {
                if (isset($visited[$connectedStreet->getId()]) && $visited[$connectedStreet->getId()] === false) {
                        $visited[$connectedStreet->getId()] = $streetIndex;
                        $queue->push($connectedStreet);
                }
            }
        }
    }
    
    private static function getRelatedStreetsMap(Collection $streets) : Collection
    {
        $map = new Collection();
        foreach ($streets as $street) {
            $map[$street->getId()] = $street->getStreets(TrafficLight::OUTGOING)->merge($street->getStreets(TrafficLight::INCOMING));
        }
        
        return $map;
    }

}
