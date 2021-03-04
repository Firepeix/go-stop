<?php


namespace App\Services\Vision;


use App\Events\Vision\Camera\StartRecording;
use App\Interfaces\Vision\Camera\Parsers\CameraImageParser;
use App\Interfaces\Vision\CreateCameraInterface;
use App\Models\Vision\Camera;
use App\Primitives\File;
use App\Repositories\Interfaces\Vision\CameraRepositoryInterface;
use App\Services\Interfaces\Vision\CameraServiceInterface;
use App\Services\Interfaces\Vision\ImageServiceInterface;
use App\Vision\Camera\Parsers\DiaOnlineParser;
use Illuminate\Support\Collection;

class CameraService implements CameraServiceInterface
{
    private ImageServiceInterface $imageService;
    private CameraRepositoryInterface $repository;
    
    public function __construct(ImageServiceInterface $imageService, CameraRepositoryInterface $repository)
    {
        $this->imageService = $imageService;
        $this->repository = $repository;
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
    
    public function beginCaptureImages(Camera $camera, int $secondsPerFrame): void
    {
        $camera->recording = true;
        $this->repository->save($camera);
        event(new StartRecording($camera, $secondsPerFrame));
    }
    
    public function stopCaptureImages(Camera $camera): void
    {
        $camera->recording = false;
        $this->repository->save($camera);
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
