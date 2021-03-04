<?php

namespace Database\Seeders;

use App\Models\Vision\Camera;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        // Sample::factory(1)->create();
        Camera::factory(1)->create();
    }
}
