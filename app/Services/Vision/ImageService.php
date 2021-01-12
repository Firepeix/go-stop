<?php


namespace App\Services\Vision;

use App\Interfaces\Vision\CreateImageInterface;
use App\Models\Vision\Camera;
use App\Models\Vision\Image;
use App\Repositories\Interfaces\Vision\ImageRepositoryInterface;
use App\Services\Interfaces\Vision\ImageLearningMachineServiceInterface;
use App\Services\Interfaces\Vision\ImageServiceInterface;
use Carbon\Carbon;

class ImageService implements ImageServiceInterface
{
    private ImageRepositoryInterface $repository;
    private ImageLearningMachineServiceInterface $service;
    
    public function __construct(ImageRepositoryInterface $repository, ImageLearningMachineServiceInterface $service)
    {
        $this->repository = $repository;
        $this->service = $service;
    }
    
    public function storeImage(Image $image) : string
    {
        $date = Carbon::now();
        $path = $this->repository->storeFile($image->getCameraId(), $date->format('Y-m-d'), $date->format('H'),$image->getFile());
        $image->path = $path;
        return $path;
    }
    
    public function createImage(CreateImageInterface $createImage): Image
    {
        return Image::create($createImage);
    }
    
    public function processImage(Image $image): void
    {
        $quantity = $this->service->getQuantityOfVehicles($image);
        $image->process($quantity);
    }
}