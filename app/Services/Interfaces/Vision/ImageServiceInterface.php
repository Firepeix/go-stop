<?php


namespace App\Services\Interfaces\Vision;



use App\Models\Vision\Camera;
use App\Models\Vision\Image;
use App\Primitives\File;
use App\Primitives\Position;
use Illuminate\Support\Collection;

interface ImageServiceInterface
{
    public function createImage(Camera $camera, File $file) : Image;
    
    public function storeImage(Image $image) : string;
    
    public function processImage(Image $image, Position $upperBoundLimit = null, Position $lowerBoundLimit = null) : Collection;
    
    public function cutImage(Image $image, Position $upperBoundLimit, Position $lowerBoundLimit, $isInBucket = true) : Image;
}
