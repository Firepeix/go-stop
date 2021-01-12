<?php

namespace Database\Factories\Vision;

use App\Models\Vision\Image;
use App\Primitives\File;
use Illuminate\Database\Eloquent\Factories\Factory;
use JetBrains\PhpStorm\ArrayShape;

class ImageFactory extends Factory
{
    protected $model = Image::class;

    public function definition()
    {
        return [
            'processed' => 0,
            'path' => 'stubs/vision/image/1.jpeg'
        ];
    }
}
