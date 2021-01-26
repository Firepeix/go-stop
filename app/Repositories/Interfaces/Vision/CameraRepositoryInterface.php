<?php


namespace App\Repositories\Interfaces\Vision;

use App\Models\Vision\Camera;
use Illuminate\Support\Collection;

interface CameraRepositoryInterface
{
    public function findOrFail(int $id) : Camera;
    
    public function getCameras() : Collection;
    
    public function saveCamera(Camera $camera) : void;
}
