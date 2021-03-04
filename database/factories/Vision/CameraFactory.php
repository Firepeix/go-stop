<?php

namespace Database\Factories\Vision;

use App\Models\Geographic\Sample;
use App\Models\Vision\Camera;
use Illuminate\Database\Eloquent\Factories\Factory;

class CameraFactory extends Factory
{
    protected $model = Camera::class;

    public function definition()
    {
        return [
            'id' => 1,
            'entity_id' => Sample::factory(),
            'camera_view' => 'diaonline',
            'type' => Camera::SAMPLE_CAMERA
        ];
    }
}
