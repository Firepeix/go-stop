<?php


namespace App\Vision\Fate;


use App\Interfaces\Vision\Fate\FatePredictResponseInterface;
use JetBrains\PhpStorm\ArrayShape;
use stdClass;

class PredictResponse implements FatePredictResponseInterface
{
    private stdClass $rawResponse;
    
    public function __construct(stdClass $response)
    {
        $this->rawResponse = $response;
    }
    
    #[ArrayShape(['label' => "string", 'probability' => "float"])] public function getObjectsFound(): array
    {
        return $this->rawResponse->predictions;
    }
}