<?php


namespace App\Transformers\Control;


use App\Models\Control\TrafficLight;
use App\Transformers\Geographic\StreetTransformer;
use App\Transformers\Transformer;
use League\Fractal\Resource\Item;

class TrafficLightTransformer extends Transformer
{
    protected $availableIncludes = ['street'];
    
    public function transform(TrafficLight $light): array
    {
        return $this->change($light, [
            'id'                   => $light->getId(),
            'uuid'                 => $light->getUUID(),
            'sampleId'             => $light->getSampleId(),
            'name'                 => $light->getName(),
            'defaultSwitchTime'    => $light->getDefaultSwitchTime(),
            'status'               => $light->getStatus(),
            'upperPosition'        => $light->getUpperPosition()->toArray(),
            'lowerPosition'        => $light->getLowerPosition()->toArray(),
            'outgoingStreetsUUIDs' => $light->getOutgoingStreetsUUIDs(),
            'graphPosition' => $light->getGraphPosition()->toArray()
        ]);
    }
    
    public function includeStreet(TrafficLight $light): Item
    {
        return $this->item($light->getStreet(), new StreetTransformer());
    }
}
