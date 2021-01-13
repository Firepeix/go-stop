<?php


namespace App\Services\Interfaces\Vision;


use App\Interfaces\Vision\CreateCameraInterface;
use App\Models\Vision\Camera;
use Illuminate\Support\Collection;

interface CameraServiceInterface
{
    public function createCamera(CreateCameraInterface $createCamera) : Camera;
    
    public function captureImages(Camera $camera, int $imagesQuantity, $secondsPerFrame) : Collection;
}