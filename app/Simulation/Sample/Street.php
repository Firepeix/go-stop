<?php


namespace App\Simulation\Sample;

use App\Models\Control\TrafficLight as TrafficLightModel;
use Illuminate\Support\Collection;

class Street
{
    private int $id;
    private string $name;
    private Collection $outgoing;
    private Collection $incoming;
    private Collection $outgoingLights;
    private Collection $incomingLights;
    private function __construct(int $id, string $name)
    {
        $this->id   = $id;
        $this->name = $name;
        $this->outgoing = new Collection();
        $this->incoming = new Collection();
        $this->outgoingLights = new Collection();
        $this->incomingLights = new Collection();
    }
    
    public static function Sample(array $sample) : Street
    {
        $sampleStreet =  new Street($sample['info']['id'], $sample['info']['name']);
        foreach (TrafficLightModel::getAvailableDirections() as $availableDirection) {
            $type = $availableDirection === TrafficLightModel::OUTGOING ? 'outgoing' : 'incoming';
            foreach ($sample[$availableDirection] as $lightId => $light) {
                foreach ($light['streets'] as $street) {
                    $sampleStreet->{"{$type}Lights"}->put("{$street['id']}", new TrafficLight($lightId, $light['info']['defaultSwitchTime']));
                    $sampleStreet->{$type}->push($street['id']);
                }
            }
        }
        return $sampleStreet;
    }

    public function getId(): int
    {
        return $this->id;
    }
    
    public function getName(): string
    {
        return $this->name;
    }
    
    public function getOutgoingStreetsId() : Collection
    {
        return $this->outgoing;
    }
    
    public function getTrafficLight(string $goingToId) : TrafficLight
    {
        return $this->outgoingLights[$goingToId];
    }
    
    public function getOutgoingLights() : Collection
    {
        return $this->outgoingLights;
    }
}
