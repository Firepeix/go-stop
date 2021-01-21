<?php

namespace App\Models\Vision;

use App\Interfaces\Vision\Camera\Parsers\CameraImageParser;
use App\Interfaces\Vision\CreateCameraInterface;
use App\Models\AbstractModel;
use App\Models\Control\TrafficLight;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Camera extends AbstractModel
{
    public function trafficLight() : BelongsTo
    {
        return $this->belongsTo(TrafficLight::class);
    }
    
    public static function create(CreateCameraInterface $createCamera) : Camera
    {
        $camera = new Camera();
        $camera->traffic_light_id = $createCamera->getTrafficLight()->getId();
        $camera->camera_view = $createCamera->getCameraView();
        return $camera;
    }
    
    public function getTrafficLight() : TrafficLight
    {
        return $this->trafficLight;
    }
    
    public function getTrafficLightId() : int
    {
        return $this->traffic_light_id;
    }
    
    public function getCameraView() : string
    {
        return $this->camera_view;
    }
}
