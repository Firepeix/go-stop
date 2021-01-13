<?php


namespace App\Services\Vision;


use App\Interfaces\Vision\Camera\Parsers\CameraImageParser;
use App\Interfaces\Vision\CreateCameraInterface;
use App\Models\Vision\Camera;
use App\Primitives\File;
use App\Services\Interfaces\Vision\CameraServiceInterface;
use App\Services\Interfaces\Vision\ImageServiceInterface;
use App\Vision\Camera\Parsers\DiaOnlineParser;
use Illuminate\Support\Collection;

class CameraService implements CameraServiceInterface
{
    private ImageServiceInterface $imageService;
    
    public function __construct(ImageServiceInterface $imageService)
    {
        $this->imageService = $imageService;
    }
    
    public function createCamera(CreateCameraInterface $createCamera): Camera
    {
        return Camera::create($createCamera);
    }
    
    public function captureImages(Camera $camera, int $imagesQuantity, int $secondsPerFrame): Collection
    {
        $parser = $this->findParser($camera);
        $images = $this->createImagesFromBase64Files($camera, $parser->captureFiles($imagesQuantity, $secondsPerFrame));
        $parser->closesSession();
        return $images;
    }
    
    /**
     * @param Camera     $camera
     * @param Collection|File[] $files
     * @return Collection
     */
    private function createImagesFromBase64Files(Camera $camera, Collection $files) : Collection
    {
        $images = new Collection();
        foreach ($files as $file) {
            $images->push($this->imageService->createImage($camera, $file->spawnBase64File()));
        }
        
        return $images;
    }
    
    private function findParser(Camera $camera) : CameraImageParser
    {
        $view = $camera->getCameraView();
        return match($view) {
            'diaonline' => new DiaOnlineParser($camera->getId())
        };
    }
}