<?php

namespace Database\Factories\Vision;

use App\Models\Vision\Image;
use Illuminate\Database\Eloquent\Factories\Factory;

class ImageFactory extends Factory
{
    protected $model = Image::class;
    
    public function definition()
    {
        return [
            'processed' => 0,
            'path'      => 'stubs/vision/image/1.jpeg'
        ];
    }
    
    public function exists(): static
    {
        return $this->state(fn(array $attributes) => ['path' => 'stubs/vision/image/2.png']);
    }
}
