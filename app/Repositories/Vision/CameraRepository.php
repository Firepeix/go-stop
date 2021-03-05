<?php


namespace App\Repositories\Vision;

use App\Models\Vision\Camera;
use App\Repositories\AbstractRepository;
use App\Repositories\Interfaces\Vision\CameraRepositoryInterface;
use Illuminate\Support\Collection;

class CameraRepository extends AbstractRepository implements CameraRepositoryInterface
{
    public function index(): Collection
    {
        return parent::rawIndex(new Camera());
    }
    
    public function first() : Camera
    {
        return parent::rawFirst(new Camera());
    }
    
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
