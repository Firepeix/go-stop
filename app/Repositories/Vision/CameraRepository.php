<?php


namespace App\Repositories\Vision;

use App\Models\Vision\Camera;
use App\Repositories\Interfaces\Vision\CameraRepositoryInterface;

class CameraRepository implements CameraRepositoryInterface
{
    public function findOrFail(int $id): Camera
    {
        return Camera::findOrFail($id);
    }
    
    public function saveCamera(Camera $camera): void
    {
        $camera->save();
    }
}