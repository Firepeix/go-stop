<?php


namespace App\Vision\Fate;


use App\Interfaces\Vision\Fate\FatePredictResponseInterface;
use App\Primitives\Position;
use Illuminate\Support\Collection;

class PredictResponse implements FatePredictResponseInterface
{
    private array $rawResponse;
    
    public function __construct(array $response)
    {
        $this->rawResponse = $response;
    }
    
    public function getObjectsFound(): Collection
    {
        $objects = new Collection();
        foreach ($this->rawResponse['predictions'] as $prediction) {
            $upperLimit = new Position($prediction['box'][0], $prediction['box'][1]);
            $lowerLimit = new Position($prediction['box'][2], $prediction['box'][3]);
            $object = new PredictObject($prediction['label'], $prediction['probability'], $upperLimit, $lowerLimit);
            $objects->push($object);
        }
        return $objects;
    }
}
