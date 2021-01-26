<?php


namespace App\Repositories\Vision;

use App\Models\Vision\Camera;
use App\Repositories\Interfaces\Vision\CameraRepositoryInterface;
use Illuminate\Support\Collection;

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
    
    public function getCameras(): Collection
    {
        return Camera::all();
    }
}
