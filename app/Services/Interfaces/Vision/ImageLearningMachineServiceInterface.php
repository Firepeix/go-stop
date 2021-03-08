<?php


namespace App\Services\Interfaces\Vision;


use App\Models\Vision\Image;
use Illuminate\Support\Collection;

interface ImageLearningMachineServiceInterface
{
    public function getVehicles(Image $image) : Collection;
}
