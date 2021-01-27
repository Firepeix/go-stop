<?php

namespace Database\Factories\Control;

use App\Models\Control\TrafficLight;
use App\Models\Geographic\Street;
use Illuminate\Database\Eloquent\Factories\Factory;

class TrafficLightFactory extends Factory
{
    protected $model = TrafficLight::class;

    public function definition()
    {
        return [
            'id' => $this->faker->numberBetween(1, 500),
            'default_switch_time' => 3,
            'status' => TrafficLight::CLOSED
        ];
    }
    
    public function open() : static
    {
        return $this->state(fn(array $attributes) => ['status' => TrafficLight::OPEN]);
    }
}
