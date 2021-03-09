<?php

namespace App\Models\Geographic;

use App\Models\AbstractModel;
use App\Models\Control\TrafficLight;
use App\Models\Vision\Camera;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Collection;

class Sample extends AbstractModel
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
    
    public function camera() : HasOne
    {
        return $this->hasOne(Camera::class, 'entity_id')->where('type', Camera::SAMPLE_CAMERA);
    }
    
    public function trafficLights() : HasMany
    {
        return $this->hasMany(TrafficLight::class);
    }
    
    public static function create(array $payload, Collection $entryStreets, Collection $departureStreets) : sample
    {
        $sample = new Sample();
        $sample->entries = json_encode($entryStreets->pluck('id')->toArray());
        $sample->departures = json_encode($departureStreets->pluck('id')->toArray());
        $sample->sample = json_encode($payload);
        return $sample;
    }
    
    /**
     * @return Collection|Street[]
     */
    public function getStreets() : Collection|array
    {
        // if ($this->streets === null) {
        //     // $sample = $this->getDecodedSample();
        //    //  $this->streets = $this->getDecodedSample()->map(fn(array $street) => Street::Sample($street, $sample));
        // }
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
        return $this->trafficLights;
    }
    
    public function getName() : string
    {
        return $this->name;
    }
    
    public function getCameraLink() : string
    {
        return $this->link;
    }
    
    public function getPayload() : string
    {
        return $this->sample;
    }
    
    public function getRawDepartureStreets() : string
    {
        return $this->departure;
    }
    
    public function getRawEntryStreets() : string
    {
        return $this->entry;
    }
    
    public function getCamera() : Camera
    {
        return $this->camera;
    }
}
