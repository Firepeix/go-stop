<?php

namespace Database\Seeders;

use App\Models\Geographic\Street;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        // $sample = Sample::factory(1)->create();
        // Camera::factory()->hasSample($sample->getId())->create();
        // TrafficLight::factory()->hasSample($sample->getId())->create();
        // for ($i = 0; $i < 2; $i++) {
        //     TrafficLight::factory()->hasSample(1)->alreadyExists($i)->create();
        // }
        // Street::factory()->hasSample($sample->getId())->create();
    
        for ($i = 0; $i < 5; $i++) {
            Street::factory()->hasSample(1)->alreadyExists($i)->create();
        }
    }
}
