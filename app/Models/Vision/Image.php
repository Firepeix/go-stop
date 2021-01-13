<?php

namespace App\Models\Vision;


use App\Interfaces\Vision\CreateImageInterface;
use App\Models\AbstractModel;
use App\Primitives\File;

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
            $localPath = $this->path !== null ? storage_path("app/$this->path") : $this->tmpPath;
            $this->file = new File($localPath);
        }
        
        return $this->file;
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
