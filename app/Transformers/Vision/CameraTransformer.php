<?php


namespace App\Transformers\Vision;


use App\Models\Vision\Camera;
use App\Primitives\NumberPrimitive;
use App\Transformers\Control\TrafficLightTransformer;
use App\Transformers\Transformer;
use League\Fractal\Resource\Item;

class CameraTransformer extends Transformer
{
    protected $availableIncludes = ['trafficLight'];
    
    public function transform(Camera $camera): array
    {
        return $this->change($camera, [
            'protocol' => NumberPrimitive::toProtocol($camera->getId()),
            'view' => $camera->getCameraView(),
            'isRecording' => $camera->isRecording(),
        ]);
    }
    
    public function includeTrafficLight(Camera $camera) : Item
    {
        return $this->item($camera->getTrafficLight(), new TrafficLightTransformer());
    }
}
