<?php


namespace App\Services\Geographic;


use App\Models\Control\TrafficLight;
use App\Models\Geographic\Sample;
use App\Models\Vision\Camera;
use App\Models\Vision\Image;
use App\Services\Interfaces\Geographic\SampleServiceInterface;
use App\Services\Interfaces\Vision\CameraServiceInterface;
use App\Services\Interfaces\Vision\ImageServiceInterface;
use Illuminate\Support\Collection;

class SampleService implements SampleServiceInterface
{
    private CameraServiceInterface $cameraService;
    private ImageServiceInterface $imageService;
    
    public function __construct(CameraServiceInterface $cameraService, ImageServiceInterface $imageService)
    {
        $this->cameraService = $cameraService;
        $this->imageService = $imageService;
    }
    
    public function record(Sample $sample, int $action): bool
    {
        $camera = $sample->getCamera();
        if ($action === Camera::START_RECORDING && !$camera->isRecording()) {
            $this->cameraService->beginCaptureImages($camera);
            return true;
        }
        $this->cameraService->stopCaptureImages($camera);
        return true;
    }
    
    public function getRate(Sample $sample, ? TrafficLight $trafficLight): Collection
    {
        $camera = $sample->getCamera();
        $images = $camera->getImages();
        $service = $this->imageService;
        $rate = $images->map(function (Image $image)  use ($service, $trafficLight){
            if ($trafficLight !== null) {
                $vehicles = $service->processImage($image, $trafficLight->getUpperPosition(), $trafficLight->getLowerPosition());
                return $vehicles->count();
            }
            return $service->processImage($image)->count();
        });;
        
        
        return $rate;
    }
}
