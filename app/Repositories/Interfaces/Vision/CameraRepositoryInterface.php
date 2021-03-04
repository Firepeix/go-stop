<?php


namespace App\Repositories\Interfaces\Vision;

use App\Models\Vision\Camera;
use App\Repositories\Interfaces\RepositoryInterface;
use Illuminate\Support\Collection;

interface CameraRepositoryInterface extends RepositoryInterface
{
    public function findOrFail(int $id) : Camera;
    
    public function getCameras() : Collection;
    
    public function saveCamera(Camera $camera) : void;
}
