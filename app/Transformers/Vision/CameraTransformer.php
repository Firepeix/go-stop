<?php


namespace App\Transformers\Vision;


use App\Models\Vision\Camera;
use App\Transformers\Control\TrafficLightTransformer;
use App\Transformers\Transformer;
use League\Fractal\Resource\Collection as ResourceCollection;

class CameraTransformer extends Transformer
{
    protected $availableIncludes = ['trafficLight'];
    
    public function transform(Camera $camera): array
    {
        return $this->change($camera, [
        ]);
    }
    
    public function includeTrafficLight(Camera $camera) : ResourceCollection
    {
        return $this->collection($camera->getTrafficLight(), new TrafficLightTransformer());
    }
}