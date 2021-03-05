<?php

namespace App\Models\Vision;


use App\Models\AbstractModel;
use App\Primitives\File;
use Illuminate\Support\Collection;

class Image extends AbstractModel
{
    private ?File $file;
    private ?string $tmpPath;
    
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->file = null;
        $this->tmpPath = null;
    }
    
    public static function create(Camera $camera, File $file) : Image
    {
        $image = new Image();
        $image->camera_id = $camera->getId();
        $image->tmpPath = $file->path();
        
        return $image;
    }
    
    public function getCameraId() : int
    {
        return $this->camera_id;
    }
    
    public function getFile() : File
    {
        if ($this->file === null) {
            $localPath = $this->path !== null ? storage_path("app/camera-images/$this->path") : $this->tmpPath;
            $this->file = new File($localPath);
        }
        
        return $this->file;
    }
    
    public function replaceFile(string $path) : File
    {
        $this->file = new File($path);
        $this->path = str_replace('/application/storage/app/camera-images/', '', $path);
        return $this->file;
    }
    
    public function getCroppedFileName() : string
    {
        $path = new Collection(explode("/", storage_path("app/camera-images/$this->path")));
        $name = preg_replace('/\..+/', '', $path->last());
        $name = "cropped-{$name}." . preg_replace('/.+\./', '', $path->last());
        $lastKey = $path->keys()->last();
        $path[$lastKey] = $name;
        return $path->join('/');
    }
    
    public function process(int $quantity) : void
    {
        $this->processed = true;
        $this->vehicles_quantity = $quantity;
    }
    
    public function hasProcessed() : bool
    {
        return $this->processed === true || $this->processed === 1;
    }
    
    public function getVehiclesQuantity() : int
    {
        return $this->vehicles_quantity;
    }
}
