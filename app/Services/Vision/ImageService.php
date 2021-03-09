<?php


namespace App\Services\Vision;

use App\Models\Vision\Camera;
use App\Models\Vision\Image;
use App\Models\Vision\Objects\Vehicle;
use App\Primitives\File;
use App\Primitives\Position;
use App\Repositories\Interfaces\Vision\ImageRepositoryInterface;
use App\Services\Interfaces\Vision\ImageLearningMachineServiceInterface;
use App\Services\Interfaces\Vision\ImageServiceInterface;
use Carbon\Carbon;
use Illuminate\Support\Collection;

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
        $path = $this->repository->storeFile($image->getCameraId(), $date->format('Y-m-d'), $date->format('H'), $image->getFile());
        $image->path = $path;
        return $path;
    }
    
    public function createImage(Camera $camera, File $file): Image
    {
        return Image::create($camera, $file);
    }
    
    public function processImage(Image $image, Position $upperBoundLimit = null, Position $lowerBoundLimit = null): Collection
    {
        $vehicles = $image->getVehicles();
        if (!$image->hasProcessed()) {
            $vehicles = $this->service->getVehicles($image);
            $this->repository->saveVehicles($vehicles);
            $image->process($vehicles->count());
            $this->repository->save($image);
        }
        
        if ($upperBoundLimit !== null && $lowerBoundLimit !== null) {
            return $this->filterBasedOnPosition($image, $vehicles, $upperBoundLimit, $lowerBoundLimit);
        }
       
        return $vehicles;
    }
    
    private function filterBasedOnPosition(Image $image, Collection $vehicles, Position $upperBoundLimit, Position $lowerBoundLimit) : Collection
    {
        return $vehicles->filter(function (Vehicle $vehicle) use ($image, $upperBoundLimit, $lowerBoundLimit){
            $position = $vehicle->getPosition($image);
            return $position->isBiggerThan($upperBoundLimit) && $position->isSmallerThan($lowerBoundLimit);
        });
    }
    
    public function cutImage(Image $image, Position $upperBoundLimit, Position $lowerBoundLimit, $isInBucket = true) : Image
    {
        $rawImage = imagecreatefrompng(!$isInBucket ? $image->getFile() : $this->repository->retrieveFile($image));
        $width = $lowerBoundLimit->getX() - $upperBoundLimit->getX();
        $height = $lowerBoundLimit->getY() - $upperBoundLimit->getY();
        $croppedImage = imagecrop($rawImage, ['x' => $upperBoundLimit->getX(), 'y' => $upperBoundLimit->getY(), 'width' => $width, 'height' => $height]);
        $path = $image->getCroppedFileName();
        imagepng($croppedImage, $path);
        $image->replaceFile($path);
        
        return $image;
    }
}
