<?php

namespace App\Listeners\Vision\Camera;

use App\Events\Vision\Camera\StartRecording;
use App\Repositories\Interfaces\Vision\ImageRepositoryInterface;
use App\Services\Interfaces\Vision\CameraServiceInterface;
use App\Services\Interfaces\Vision\ImageServiceInterface;
use Illuminate\Contracts\Queue\ShouldQueue;

class Record implements ShouldQueue
{
    private CameraServiceInterface $service;
    private ImageRepositoryInterface $imageRepository;
    private ImageServiceInterface $imageService;
    
    public function __construct(CameraServiceInterface $service, ImageRepositoryInterface $imageRepository, ImageServiceInterface $imageService)
    {
        $this->service = $service;
        $this->imageRepository = $imageRepository;
        $this->imageService = $imageService;
    }
    
    public function handle(StartRecording $event)
    {
        $camera = $event->getCamera();
        $images = $this->service->captureImages($camera, 10, $event->getSecondsPerFrame());
        foreach ($images as $image) {
            $this->imageService->storeImage($image);
            $this->imageRepository->save($image);
        }
        $camera->refresh();
        if ($camera->isRecording()) {
            event($event);
        }
    }
}
