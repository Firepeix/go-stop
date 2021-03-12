<?php

namespace App\Listeners\Vision\Image;

use App\Events\Vision\Image\ProcessImage;
use App\Events\Vision\Image\StoreImage;
use App\Repositories\Interfaces\Vision\ImageRepositoryInterface;
use App\Services\Interfaces\Vision\ImageLearningMachineServiceInterface;
use App\Services\Interfaces\Vision\ImageServiceInterface;
use Illuminate\Contracts\Queue\ShouldQueue;

class Process implements ShouldQueue
{
    private ImageRepositoryInterface $repository;
    private ImageServiceInterface $service;
    private ImageLearningMachineServiceInterface $learningMachineService;
    
    public function __construct(ImageRepositoryInterface $repository, ImageServiceInterface $service, ImageLearningMachineServiceInterface $learningMachineService)
    {
        $this->service = $service;
        $this->repository = $repository;
        $this->learningMachineService = $learningMachineService;
    }
    
    public function handle(ProcessImage $event)
    {
        $image = $event->getImage();
        $vehicles = $this->learningMachineService->getVehicles($image);
        $this->repository->saveVehicles($vehicles);
        $image->process($vehicles->count());
        $this->repository->save($image);
    }
}
