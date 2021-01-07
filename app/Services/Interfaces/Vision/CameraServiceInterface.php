<?php


namespace App\Services\Interfaces\Vision;


use App\Interfaces\Vision\CreateCameraInterface;
use App\Models\Vision\Camera;

interface CameraServiceInterface
{
    public function createCamera(CreateCameraInterface $createCamera) : Camera;
}