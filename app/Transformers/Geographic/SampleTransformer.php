<?php


namespace App\Transformers\Geographic;

use App\Models\Geographic\Sample;
use App\Transformers\Transformer;

class SampleTransformer extends Transformer
{
    public function transform(Sample $sample): array
    {
        return $this->change($sample, [
            'name' => $sample->getName(),
            'cameraLink' => $sample->getCameraLink(),
            'payload' => $sample->getPayload(),
            'entryStreetsIds' => json_decode($sample->getRawEntryStreets()),
            'departureStreetsIds' => json_decode($sample->getRawDepartureStreets()),
        ]);
    }
}
