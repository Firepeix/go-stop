<?php


namespace App\Vision;

use App\Interfaces\Vision\Fate\FatePredictResponseInterface;
use App\Primitives\File;
use App\Vision\Fate\PredictResponse;
use GuzzleHttp\Client;

class Fate
{
    private Client $client;
    
    public function __construct()
    {
        $this->client = new Client(['base_uri' => env('FATE_URL'), 'headers' => [ 'Accept' => 'application/json']]);
    }
    
    public function processFile(File $file) : FatePredictResponseInterface
    {
        $response = $this->client->post('/predict', ['multipart' => [['name' => 'image', 'contents' => fopen($file->path(), 'r')]]]);
        return new PredictResponse(json_decode($response->getBody()));
    }
}