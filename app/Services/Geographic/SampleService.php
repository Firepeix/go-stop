<?php


namespace App\Services\Geographic;


use App\Models\Geographic\Sample;
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
        $this->cameraService->beginCaptureImages($sample->getCamera(), 1050);
        return true;
    }
}
