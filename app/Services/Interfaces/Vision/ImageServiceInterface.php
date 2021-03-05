<?php


namespace App\Services\Interfaces\Vision;



use App\Models\Vision\Camera;
use App\Models\Vision\Image;
use App\Primitives\File;
use App\Primitives\Position;

interface ImageServiceInterface
{
    public function createImage(Camera $camera, File $file) : Image;
    
    public function storeImage(Image $image) : string;
    
    public function processImage(Image $image, Position $upperBoundLimit = null, Position $lowerBoundLimit = null) : void;
}
