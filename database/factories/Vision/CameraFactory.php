<?php

namespace Database\Factories\Vision;

use App\Models\Vision\Camera;
use Illuminate\Database\Eloquent\Factories\Factory;

class CameraFactory extends Factory
{
    protected $model = Camera::class;

    public function definition()
    {
        return [
            'id' => 1,
            'camera_view' => 'diaonline',
        ];
    }
    
    public function hasSample(int $entityId): CameraFactory
    {
        return $this->state(fn() => ['entity_id' => $entityId, 'type' => Camera::SAMPLE_CAMERA]);
    }
}
