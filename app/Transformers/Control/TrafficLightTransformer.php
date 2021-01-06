<?php


namespace App\Transformers\Control;


use App\Models\Control\TrafficLight;
use App\Transformers\Geographic\StreetTransformer;
use App\Transformers\Transformer;
use League\Fractal\Resource\Collection as ResourceCollection;

class TrafficLightTransformer extends Transformer
{
    protected $availableIncludes = ['street'];
    
    public function transform(TrafficLight $light): array
    {
        return $this->change($light, [
            'status' => $light->getStatus()
        ]);
    }
    
    public function includeStreet(TrafficLight $light) : ResourceCollection
    {
        return $this->collection($light->getStreet(), new StreetTransformer());
    }
}