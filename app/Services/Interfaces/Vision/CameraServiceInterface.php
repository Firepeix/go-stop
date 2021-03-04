<?php


namespace App\Services\Interfaces\Vision;


use App\Interfaces\Vision\CreateCameraInterface;
use App\Models\Vision\Camera;
use Illuminate\Support\Collection;

interface CameraServiceInterface
{
    public function createCamera(CreateCameraInterface $createCamera) : Camera;
    
    public function captureImages(Camera $camera, int $imagesQuantity, int $secondsPerFrame) : Collection;
    
    public function beginCaptureImages(Camera $camera, int $secondsPerFrame) : void;
    
    public function stopCaptureImages(Camera $camera) : void;
}
