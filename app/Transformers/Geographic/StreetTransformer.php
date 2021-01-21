<?php


namespace App\Transformers\Geographic;


use App\Models\Geographic\Street;
use App\Transformers\Transformer;

class StreetTransformer extends Transformer
{
    protected $availableIncludes = ['outgoingStreets', 'incomingStreets'];
    
    public function transform(Street $street): array
    {
        return $this->change($street, [
            'name' => $street->getName()
        ]);
    }
    
    public function includeOutgoingStreets(Street $street)
    {
        return $this->collection($street->getOutgoingStreets(), new StreetTransformer());
    }
    
    public function includeIncomingStreets(Street $street)
    {
        return $this->collection($street->getIncomingStreets(), new StreetTransformer());
    }
}
