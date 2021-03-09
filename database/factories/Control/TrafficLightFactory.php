<?php

namespace Database\Factories\Control;

use App\Models\Control\TrafficLight;
use Illuminate\Database\Eloquent\Factories\Factory;

class TrafficLightFactory extends Factory
{
    protected $model = TrafficLight::class;

    public function definition()
    {
        return [
            'id' => 1,
            'default_switch_time' => 3,
            'status' => TrafficLight::CLOSED
        ];
    }
    
    public function open() : static
    {
        return $this->state(fn(array $attributes) => ['status' => TrafficLight::OPEN]);
    }
    
    public function hasSample(int $sampleId) : static
    {
        return $this->state(function () use($sampleId){
            return [
                'sample_id' => $sampleId,
            ];
        });
    }
    
    public function alreadyExists(int $index) : static
    {
        $lights = [
            [
                'id' => 1,
                'uuid' => '61e143e8-d099-47be-8eb7-899b1c0e8cb8',
                'name' => 'D - Cima',
                'outgoingStreets' => json_encode(['f0dba142-a79f-4c16-b111-4621ed6899d8']),
                'upperBoundX' => 403.3,
                'upperBoundY' => 281.1,
                'lowerBoundX' => 564.8,
                'lowerBoundY' => 368.6,
            ],
            [
                'id' => 2,
                'uuid' => '1a6dcae8-387b-4223-b737-0ec1bc936428',
                'name' => 'E - Direito',
                'outgoingStreets' => json_encode(['de82e17f-e6ec-4ba4-b48f-496182f9ce6c', 'f0dba142-a79f-4c16-b111-4621ed6899d8']),
                'upperBoundX' => 712,
                'upperBoundY' => 490,
                'lowerBoundX' => 1047,
                'lowerBoundY' => 712,
            ],
            [
                'id' => 3,
                'uuid' => '77965874-9dda-4a9e-8a01-69449d27d033',
                'name' => 'F - Esquerdo',
                'outgoingStreets' => json_encode(['f0dba142-a79f-4c16-b111-4621ed6899d8']),
                'upperBoundX' => 93,
                'upperBoundY' => 460,
                'lowerBoundX' => 381,
                'lowerBoundY' => 541,
            ]
        ];
        return $this->state(function () use($lights, $index){
            return $lights[$index];
        });
    }
}
