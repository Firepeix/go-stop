<?php

namespace Database\Factories\Geographic;

use App\Models\Geographic\Sample;
use Illuminate\Database\Eloquent\Factories\Factory;

class SampleFactory extends Factory
{
    protected $model = Sample::class;
    
    public function definition()
    {
        return [
            'name'      => 'AV 85, Setor Marista, Goiânia - GO, Brasil',
            'link'      => 'https://diaonline.ig.com.br/cameras-ao-vivo/',
            'sample'   => '{"ae3d9e0b-e385-4225-8e52-17e08a2af485":{"info":{"id":"ae3d9e0b-e385-4225-8e52-17e08a2af485","name":"A"},"outgoing":{"streets":[],"trafficLights":{"61e143e8-d099-47be-8eb7-899b1c0e8cb8":{"info":{"id":"61e143e8-d099-47be-8eb7-899b1c0e8cb8","name":"D"},"streets":[{"id":"f0dba142-a79f-4c16-b111-4621ed6899d8","name":"A"}]}}}},"48a34dd5-30cb-4afc-a9ee-036a4d57a7cd":{"info":{"id":"48a34dd5-30cb-4afc-a9ee-036a4d57a7cd","name":"B"},"outgoing":{"streets":[],"trafficLights":{"1a6dcae8-387b-4223-b737-0ec1bc936428":{"info":{"id":"1a6dcae8-387b-4223-b737-0ec1bc936428","name":"E"},"streets":[{"id":"de82e17f-e6ec-4ba4-b48f-496182f9ce6c","name":"C"},{"id":"f0dba142-a79f-4c16-b111-4621ed6899d8","name":"A"}]}}}},"de82e17f-e6ec-4ba4-b48f-496182f9ce6c":{"info":{"id":"de82e17f-e6ec-4ba4-b48f-496182f9ce6c","name":"C"},"outgoing":{"streets":[],"trafficLights":{}}},"72eb6263-0ef5-49e5-883a-c1b6ac5a6d8e":{"info":{"id":"72eb6263-0ef5-49e5-883a-c1b6ac5a6d8e","name":"D"},"outgoing":{"streets":[],"trafficLights":{"77965874-9dda-4a9e-8a01-69449d27d033":{"info":{"id":"77965874-9dda-4a9e-8a01-69449d27d033","name":"F"},"streets":[{"id":"f0dba142-a79f-4c16-b111-4621ed6899d8","name":"A"}]}}}},"f0dba142-a79f-4c16-b111-4621ed6899d8":{"info":{"id":"f0dba142-a79f-4c16-b111-4621ed6899d8","name":"A"},"outgoing":{"streets":[],"trafficLights":{}}}}',
            'entry'     => json_encode(['Segunda D', 'Segunda B', 'C']),
            'departure' => json_encode(['A', 'E', 'B'])
        ];
    }
    
}
