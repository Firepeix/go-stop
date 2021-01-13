<?php

namespace Database\Factories\Vision;

use App\Models\Control\TrafficLight;
use App\Models\Vision\Camera;
use Illuminate\Database\Eloquent\Factories\Factory;

class CameraFactory extends Factory
{
    protected $model = Camera::class;

    public function definition()
    {
        return [
            'id' => 1,
            'traffic_light_id' => TrafficLight::factory(),
            'camera_view' => 'diaonline'
        ];
    }
}
