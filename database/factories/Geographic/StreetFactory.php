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
            'name' => $this->faker->streetName,
        ];
    }
}
