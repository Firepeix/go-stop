<?php


namespace App\Vision;

use App\Models\Vision\Image;
use App\Models\Vision\Objects\Vehicle;
use App\Primitives\Position;
use App\Primitives\Transform;
use Aws\Credentials\Credentials;
use Aws\Rekognition\RekognitionClient;
use Illuminate\Support\Collection;

class AmazonRekognition
{
    const VEHICLE_LABELS = ['Transportation' => 0, 'Vehicle' => 1, 'Car' => 2, 'Automobile' => 3];
    
    private RekognitionClient $client;
    public function __construct()
    {
        $credentials = new Credentials(env('AWS_ACCESS_KEY_ID'), env('AWS_SECRET_ACCESS_KEY'));
        $this->client =  new RekognitionClient(['region' => env('AWS_DEFAULT_REGION'), 'credentials' => $credentials, 'version' => 'latest']);
    }
    
    public function processFile(Image $image) : Collection
    {
        $imageName = $image->getPath();
        $bucketName = 'gostop';
        
        $request = [
            'Image' => [
                'S3Object' => [
                    'Bucket' => $bucketName,
                    'Name' => $imageName
                ]
            ],
            'MinConfidence' => 30
        ];
        $response = $this->client->detectLabels($request)->toArray();
        return $this->searchVehicles(new Collection($response), $image);
    }
    
    public function searchVehicles(Collection $response, Image $image) : Collection
    {
        $vehicles = new Collection();
        foreach ($response['Labels'] as $label) {
            $type = self::VEHICLE_LABELS[$label['Name']] ?? null;
            if ($type !== null) {
                foreach ($label['Instances'] as $instance) {
                    $position = new Position($instance['BoundingBox']['Left'], $instance['BoundingBox']['Top']);
                    $transform = new Transform($instance['BoundingBox']['Width'], $instance['BoundingBox']['Height']);
                    $vehicles->push(Vehicle::CreateAmazon($image, $type, $position, $transform));
                }
            }
        }
        return $vehicles;
    }
}
