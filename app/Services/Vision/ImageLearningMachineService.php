<?php


namespace App\Services\Vision;

use App\Models\Vision\Image;
use App\Services\Interfaces\Vision\ImageLearningMachineServiceInterface;
use App\Vision\Fate;
use Illuminate\Support\Collection;

class ImageLearningMachineService implements ImageLearningMachineServiceInterface
{
    const VEHICLE_LABELS = ['truck', 'motorcycle', 'car'];
    
    private Fate $fate;

    public function __construct()
    {
        $this->fate = new Fate();
    }

    public function getQuantityOfVehicles(Image $image): int
    {
        $response = $this->fate->processFile($image->getFile());
        $objects = new Collection($response->getObjectsFound());
        return $objects->whereIn('label', self::VEHICLE_LABELS)->count();
    }
}