<?php


namespace App\Simulation\Sample;


use App\Models\Control\TrafficLight;
use Illuminate\Support\Collection;

class Street
{
    private int $id;
    private string $name;
    private Collection $outgoing;
    private Collection $incoming;
    private function __construct(int $id, string $name)
    {
        $this->id   = $id;
        $this->name = $name;
        $this->outgoing = new Collection();
        $this->incoming = new Collection();
    }
    
    public static function Sample(array $sample) : Street
    {
        $sampleStreet =  new Street($sample['info']['id'], $sample['info']['name']);
        foreach (TrafficLight::getAvailableDirections() as $availableDirection) {
            $type = $availableDirection === TrafficLight::OUTGOING ? 'outgoing' : 'incoming';
            foreach ($sample[$availableDirection] as $light) {
                foreach ($light['streets'] as $street) {
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
}
