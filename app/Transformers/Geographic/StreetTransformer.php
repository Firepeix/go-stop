<?php


namespace App\Transformers\Geographic;


use App\Models\Geographic\Street;
use App\Transformers\Transformer;

class StreetTransformer extends Transformer
{
    public function transform(Street $street): array
    {
        return $this->change($street, [
            'name'                       => $street->getName(),
            'uuid'                       => $street->getUUID(),
            'sampleId'                   => $street->getSampleId(),
            'outgoingStreetsUUIDs'       => $street->getOutgoingStreetsUUIDs(),
            'outgoingTrafficLightsUUIDs' => $street->getOutgoingTrafficLightsUUIDs(),
            'graphPosition'              => $street->getGraphPosition()->toArray()
        ]);
    }
}
