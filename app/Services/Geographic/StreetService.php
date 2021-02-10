<?php


namespace App\Services\Geographic;


use App\Interfaces\Geographic\CreateStreetInterface;
use App\Models\Control\TrafficLight;
use App\Models\Geographic\Street;
use App\Models\Geographic\StreetConnection;
use App\Services\Interfaces\Control\TrafficLightServiceInterface;
use App\Services\Interfaces\Geographic\StreetServiceInterface;
use Illuminate\Support\Collection;

class StreetService implements StreetServiceInterface
{
    private TrafficLightServiceInterface $service;
    
    public function __construct(TrafficLightServiceInterface $service)
    {
        $this->service = $service;
    }
    
    public function createStreet(CreateStreetInterface $createStreet): Street
    {
        return  Street::create($createStreet);
    }
    
    public function createConnections(Street $street, Collection $streets): Collection
    {
        $connections = collect();
        foreach ($streets as $receivingStreet) {
            $connections->push(StreetConnection::create($street, $receivingStreet));
        }
        return $connections;
    }
    
    /**
     * @param Collection|Street[] $streets
     * @return array
     */
    public function constructSample(Collection|array $streets): array
    {
        $sample = [];
        
        foreach ($streets as $street) {
            $sample[$street->getId()] = [
                'info' => $street->toArray(),
                TrafficLight::INCOMING => [
                    'directStreets' => $street->getStreets(TrafficLight::INCOMING)->map(fn(Street $street) => $street->toArray()),
                    'throughTrafficLightsStreets' => $this->service->constructSample($street->getTrafficLights(TrafficLight::INCOMING), TrafficLight::INCOMING)
                ],
                TrafficLight::OUTGOING => [
                    'directStreets' => $street->getStreets(TrafficLight::OUTGOING)->map(fn(Street $street) => $street->toArray()),
                    'throughTrafficLightsStreets' => $this->service->constructSample($street->getTrafficLights(TrafficLight::OUTGOING), TrafficLight::OUTGOING)
                ],
            ];
            
        }
    
        return $sample;
    }
}
