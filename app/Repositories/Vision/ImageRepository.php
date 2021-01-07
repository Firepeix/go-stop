<?php


namespace App\Repositories\Vision;


use App\Models\Vision\Image;
use App\Primitives\File;
use App\Repositories\Interfaces\Vision\ImageRepositoryInterface;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;

class ImageRepository implements ImageRepositoryInterface
{
    private Filesystem $storage;
    
    public function __construct(Storage $storage)
    {
        $this->storage = $storage::disk('camera-images');
    }
    
    public function findOrFail(int $id): Image
    {
        return Image::findOrFail($id);
    }
    
    public function saveImage(Image $image): void
    {
        $image->save();
    }
    
    public function storeFile(int $cameraId, string $date, string $hour, File $file): string
    {
        return  $this->storage->put("$cameraId/$date/$hour", $file);
    }
}