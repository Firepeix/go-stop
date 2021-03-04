<?php


namespace App\Transformers\Geographic;

use App\Models\Geographic\Sample;
use App\Transformers\Transformer;
use App\Transformers\Vision\CameraTransformer;
use League\Fractal\Resource\Item;

class SampleTransformer extends Transformer
{
    protected $availableIncludes = ['camera'];
    
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
    
    public function includeCamera(Sample $sample) : Item
    {
        return $this->item($sample->getCamera(), new CameraTransformer());
    }
}
