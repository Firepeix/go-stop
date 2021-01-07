<?php


namespace App\Repositories\Interfaces\Vision;

use App\Models\Vision\Camera;

interface CameraRepositoryInterface
{
    public function findOrFail(int $id) : Camera;
    
    public function saveCamera(Camera $camera) : void;
}