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
                'outgoing_streets' => json_encode(['f0dba142-a79f-4c16-b111-4621ed6899d8']),
                'upper_bound_x' => 403.3,
                'upper_bound_y' => 281.1,
                'lower_bound_x' => 564.8,
                'lower_bound_y' => 368.6,
                'graph_position_x' => 392.4299311007878,
                'graph_position_y' => 365.9810126582279,
            ],
            [
                'id' => 2,
                'uuid' => '1a6dcae8-387b-4223-b737-0ec1bc936428',
                'name' => 'E - Direito',
                'outgoing_streets' => json_encode(['de82e17f-e6ec-4ba4-b48f-496182f9ce6c', 'f0dba142-a79f-4c16-b111-4621ed6899d8']),
                'upper_bound_x' => 712,
                'upper_bound_y' => 490,
                'lower_bound_x' => 1047,
                'lower_bound_y' => 712,
                'graph_position_x' => 735.2405063291137,
                'graph_position_y' => 419.93037974683546,
            ]
        ];
        return $this->state(function () use($lights, $index){
            return $lights[$index];
        });
    }
}
