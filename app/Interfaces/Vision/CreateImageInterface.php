<?php


namespace App\Interfaces\Vision;


use App\Models\Vision\Camera;
use App\Primitives\File;

interface CreateImageInterface
{
    public function getCamera() : Camera;
    
    public function getFile() : File;
}