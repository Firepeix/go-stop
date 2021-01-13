<?php


namespace App\Services\Vision;


use App\Interfaces\Vision\CreateCameraInterface;
use App\Models\Vision\Camera;
use App\Services\Interfaces\Vision\CameraServiceInterface;
use Carbon\Carbon;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CameraService implements CameraServiceInterface
{
    private Filesystem $rawImagesStorage;
    
    public function __construct()
    {
        $this->rawImagesStorage = Storage::disk('raw-images');
    }
    
    public function createCamera(CreateCameraInterface $createCamera): Camera
    {
        return Camera::create($createCamera);
    }
    
    public function captureImages(Camera $camera, int $imagesQuantity, $secondsPerFrame): Collection
    {
        $images = new Collection();
        $cameraSessionId = $this->createCameraSession();
        dump($cameraSessionId);
        
        return $images;
    }
    
    private function createCameraSession() : string
    {
        $id = hash('md5', Carbon::now()->toDateTimeString() . Str::random(4));
        $this->rawImagesStorage->makeDirectory($id);
        
        return $id;
    }
}