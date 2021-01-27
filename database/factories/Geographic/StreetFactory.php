<?php

namespace Database\Factories\Geographic;

use App\Models\Geographic\Street;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Collection;

class StreetFactory extends Factory
{
    protected $model = Street::class;

    public function definition()
    {
        return [
            'id' => $this->faker->numberBetween(1, 500),
            'name' => $this->faker->streetName,
            'incomingTrafficLights' => new Collection(),
            'outgoingTrafficLights' => new Collection(),
            'incomingStreets' => new Collection(),
            'outgoingStreets' => new Collection(),
        ];
    }
    
}
