<?php


namespace App\Services\Vision;

use App\Models\Vision\Image;
use App\Services\Interfaces\Vision\ImageLearningMachineServiceInterface;
use App\Vision\Fate;
use App\Vision\Fate\PredictObject;
use Illuminate\Support\Collection;

class ImageLearningMachineService implements ImageLearningMachineServiceInterface
{
    const VEHICLE_LABELS = ['truck', 'motorcycle', 'car'];
    
    private Fate $fate;
    
    public function __construct()
    {
        $this->fate = new Fate();
    }
    
    public function getQuantityOfVehicles(Image $image): int
    {
        $response = $this->fate->processFile($image->getFile());
        return $this->filterBoxedObjects($this->filterVehicles($response->getObjectsFound()))->count();
    }
    
    private function filterVehicles(Collection $objects): Collection
    {
        return $objects->filter(function (PredictObject $object){
            return in_array($object->getLabel(), self::VEHICLE_LABELS) && $object->isBigEnoughVehicle();
        });
    }
    
    /**
     * @param Collection|PredictObject[] $objects
     * @return Collection
     */
    private function filterBoxedObjects(Collection $objects): Collection
    {
        $vehicles  = new Collection();
        $blacklist = new Collection();
        foreach ($objects as $majorKey => $objectA) {
            if ($blacklist->search($majorKey) === false) {
                foreach ($objects as $key => $objectB) {
                    if ($objectA->isInside($objectB) && $blacklist->search($key) === false) {
                        $object = $objectA->moreAccurate($objectB) ? $objectA : $objectB;
                        $blacklist->push($key);
                        $vehicles->put($object->getId(), $object);
                        $blacklist->push($majorKey);
                    }
                }
                if ($blacklist->search($majorKey) === false) {
                    $vehicles->put($objectA->getId(), $objectA);
                }
            }
        }
        
        return $vehicles;
    }
}
