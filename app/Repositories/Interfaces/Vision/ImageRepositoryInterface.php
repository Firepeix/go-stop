<?php


namespace App\Repositories\Interfaces\Vision;

use App\Models\Vision\Image;
use App\Primitives\File;
use App\Repositories\Interfaces\RepositoryInterface;

interface ImageRepositoryInterface extends RepositoryInterface
{
    public function findOrFail(int $id) : Image;
    
    public function storeFile(int $cameraId, string $date, string $hour, File $file) : string;
}
