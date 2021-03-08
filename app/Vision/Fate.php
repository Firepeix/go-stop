<?php


namespace App\Vision;

use App\Primitives\File;
use App\Vision\Fate\PredictObject;
use App\Vision\Fate\PredictResponse;
use GuzzleHttp\Client;
use Illuminate\Support\Collection;

class Fate
{
    const VEHICLE_LABELS = ['truck', 'motorcycle', 'car'];
    
    private Client $client;
    
    public function __construct()
    {
        $this->client = new Client(['base_uri' => env('FATE_URL'), 'headers' => [ 'Accept' => 'application/json']]);
    }
    
    public function processFile(File $file) : Collection
    {
        $response = $this->client->post('/predict', ['multipart' => [['name' => 'image', 'contents' => fopen($file->path(), 'r')]]]);
        $vehicles = new PredictResponse(json_decode($response->getBody(), true));
        return $this->filterBoxedObjects($this->filterVehicles($vehicles->getObjectsFound()));
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
