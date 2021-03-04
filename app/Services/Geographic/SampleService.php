<?php


namespace App\Services\Geographic;


use App\Models\Geographic\Sample;
use App\Models\Vision\Camera;
use App\Services\Interfaces\Geographic\SampleServiceInterface;
use App\Services\Interfaces\Vision\CameraServiceInterface;

class SampleService implements SampleServiceInterface
{
    private CameraServiceInterface $cameraService;
    
    public function __construct(CameraServiceInterface $cameraService)
    {
        $this->cameraService = $cameraService;
    }
    
    public function record(Sample $sample, int $action): bool
    {
        $camera = $sample->getCamera();
        if ($action === Camera::START_RECORDING && !$camera->isRecording()) {
            $this->cameraService->beginCaptureImages($camera, 1050);
            return true;
        }
        $this->cameraService->stopCaptureImages($camera);
        return true;
    }
}
