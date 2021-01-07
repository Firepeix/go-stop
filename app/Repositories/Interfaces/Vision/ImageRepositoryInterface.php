<?php


namespace App\Repositories\Interfaces\Vision;

use App\Models\Vision\Image;
use App\Primitives\File;

interface ImageRepositoryInterface
{
    public function findOrFail(int $id) : Image;
    
    public function saveImage(Image $image) : void;
    
    public function storeFile(int $cameraId, string $date, string $hour, File $file) : string;
}