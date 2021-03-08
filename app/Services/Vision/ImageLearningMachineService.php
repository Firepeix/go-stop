<?php


namespace App\Services\Vision;

use App\Models\Vision\Image;
use App\Services\Interfaces\Vision\ImageLearningMachineServiceInterface;
use App\Vision\AmazonRekognition;
use Illuminate\Support\Collection;

class ImageLearningMachineService implements ImageLearningMachineServiceInterface
{
    
    private AmazonRekognition $fate;
    
    public function __construct()
    {
        $this->fate = new AmazonRekognition();
    }
    
    public function getVehicles(Image $image): Collection
    {
        return $this->fate->processFile($image);
    }
}
