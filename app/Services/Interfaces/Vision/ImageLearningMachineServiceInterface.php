<?php


namespace App\Services\Interfaces\Vision;


use App\Models\Vision\Image;

interface ImageLearningMachineServiceInterface
{
    public function getQuantityOfVehicles(Image $image) : int;
}