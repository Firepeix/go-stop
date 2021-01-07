<?php


namespace App\Services\Vision;


use App\Interfaces\Vision\CreateCameraInterface;
use App\Models\Vision\Camera;
use App\Services\Interfaces\Vision\CameraServiceInterface;

class CameraService implements CameraServiceInterface
{
    public function createCamera(CreateCameraInterface $createCamera): Camera
    {
        return Camera::create($createCamera);
    }
}