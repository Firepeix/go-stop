<?php


namespace App\Services\Interfaces\Vision;



use App\Interfaces\Vision\CreateImageInterface;
use App\Models\Vision\Camera;
use App\Models\Vision\Image;
use App\Primitives\File;

interface ImageServiceInterface
{
    public function createImage(Camera $camera, File $file) : Image;
    
    public function storeImage(Image $image) : string;
    
    public function processImage(Image $image) : void;
}