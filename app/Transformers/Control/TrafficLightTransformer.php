<?php


namespace App\Transformers\Control;


use App\Models\Control\TrafficLight;
use App\Primitives\NumberPrimitive;
use App\Transformers\Geographic\StreetTransformer;
use App\Transformers\Transformer;
use League\Fractal\Resource\Item;

class TrafficLightTransformer extends Transformer
{
    protected $availableIncludes = ['street'];
    
    public function transform(TrafficLight $light): array
    {
        return $this->change($light, [
            'protocol' => NumberPrimitive::toProtocol($light->getId()),
            'defaultSwitchTime' => $light->getDefaultSwitchTime(),
            'status' => $light->getStatus()
        ]);
    }
    
    public function includeStreet(TrafficLight $light) : Item
    {
        return $this->item($light->getStreet(), new StreetTransformer());
    }
}
