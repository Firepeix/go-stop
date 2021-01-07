<?php


namespace App\Services\Interfaces\Vision;



use App\Interfaces\Vision\CreateImageInterface;
use App\Models\Vision\Image;

interface ImageServiceInterface
{
    public function createImage(CreateImageInterface $createImage) : Image;
    
    public function storeImage(Image $image) : string;
}