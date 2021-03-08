<?php


namespace App\Repositories\Vision;


use App\Models\AbstractModel;
use App\Models\Vision\Image;
use App\Models\Vision\Objects\Vehicle;
use App\Primitives\File;
use App\Repositories\AbstractRepository;
use App\Repositories\Interfaces\Vision\ImageRepositoryInterface;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

class ImageRepository extends AbstractRepository implements ImageRepositoryInterface
{
    private Filesystem $storage;
    private Filesystem $bucket;
    
    protected function getModel(): AbstractModel
    {
        return new Image();
    }
    
    public function first() : Image
    {
        return parent::first();
    }
    
    public function index(): Collection
    {
        return parent::rawIndex(new Image());
    }
    
    public function __construct(Storage $storage)
    {
        $this->storage = $storage::disk('camera-images');
        $this->bucket = $storage::disk('s3');
    }
    
    public function findOrFail(int $id): Image
    {
        return Image::findOrFail($id);
    }
    
    public function storeFile(int $cameraId, string $date, string $hour, File $file): string
    {
        return $this->storage->put("$cameraId/$date/$hour", $file);
    }
    
    public function storeFilePermanent(Image $image): void
    {
        $oldPath = $image->getPath();
        $path = new Collection(explode('/', $oldPath));
        $path = $path->slice(0, -1);
        $image->path = $this->bucket->put($path->join('/'), $image->getFile());
        $image->save();
        $this->storage->delete($oldPath);
    }
    
    public function retrieveFile(Image $image): File
    {
        $path = $image->getPath();
        $contents = $this->bucket->get($path);
        $this->storage->put($path, $contents);
        return new File(storage_path("app/camera-images/$path"));
    }
    
    public function sortStore(Collection $images): void
    {
        $storage = $this->storage;
        $images->each(function (Image $image, int $index) use ($storage){
            $storage->put("sorted/$index.{$image->getType()}", $image->getFile()->getContent());
        });
    }
    
    public function saveVehicles(Collection $vehicles): void
    {
        $vehicles->each(function (Vehicle $vehicle) {
            $vehicle->save();
        });
    }
}
