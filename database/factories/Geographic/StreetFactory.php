<?php

namespace Database\Factories\Geographic;

use App\Models\Geographic\Street;
use Illuminate\Database\Eloquent\Factories\Factory;

class StreetFactory extends Factory
{
    protected $model = Street::class;

    public function definition()
    {
        return [
            'id' => $this->faker->numberBetween(1, 500),
            'name' => $this->faker->streetName
        ];
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
        $streets = [
            [
                'id' => 1,
                'uuid' => 'ae3d9e0b-e385-4225-8e52-17e08a2af485',
                'name' => 'Av. 85 - Esquerda Cima',
                'outgoing_streets' => json_encode([]),
                'outgoing_traffic_lights' => json_encode(['61e143e8-d099-47be-8eb7-899b1c0e8cb8']),
                'graph_position_x' => 392.4299311007878,
                'graph_position_y' => 246.10759493670886,
            ],
            [
                'id' => 2,
                'uuid' => '48a34dd5-30cb-4afc-a9ee-036a4d57a7cd',
                'name' => 'AV. 85 - Direita Baixo',
                'outgoing_streets' => json_encode([]),
                'outgoing_traffic_lights' => json_encode(['1a6dcae8-387b-4223-b737-0ec1bc936428']),
                'graph_position_x' => 736.2531645569621,
                'graph_position_y' => 522.8417721518988,
            ],
            [
                'id' => 3,
                'uuid' => 'de82e17f-e6ec-4ba4-b48f-496182f9ce6c',
                'name' => 'AV. 85 - Direita Cima',
                'outgoing_streets' => json_encode([]),
                'outgoing_traffic_lights' => json_encode([]),
                'graph_position_x' => 738.2784810126583,
                'graph_position_y' => 249.70253164556965,
            ],
            [
                'id' => 4,
                'uuid' => '72eb6263-0ef5-49e5-883a-c1b6ac5a6d8e',
                'name' => 'R. T-59',
                'outgoing_streets' => json_encode(['f0dba142-a79f-4c16-b111-4621ed6899d8']),
                'outgoing_traffic_lights' => json_encode([]),
                'graph_position_x' => 199.90373337606073,
                'graph_position_y' => 522.3860759493671,
            ],
            [
                'id' => 5,
                'uuid' => 'f0dba142-a79f-4c16-b111-4621ed6899d8',
                'name' => 'Av. 85 - Esquerda Baixo',
                'outgoing_streets' => json_encode([]),
                'outgoing_traffic_lights' => json_encode([]),
                'graph_position_x' => 392.4299311007878,
                'graph_position_y' => 523.6772151898732,
            ]
        ];
        return $this->state(function () use($streets, $index){
            return $streets[$index];
        });
    }
    
}
