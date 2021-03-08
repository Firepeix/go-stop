<?php


namespace App\Vision;

use App\Interfaces\Vision\Fate\FatePredictResponseInterface;
use App\Primitives\File;
use App\Vision\Fate\PredictResponse;
use Aws\Credentials\Credentials;
use Aws\Rekognition\RekognitionClient;

class AmazonRekognition
{
    public function processFile(File $file) : FatePredictResponseInterface
    {
        $imageName = 'Teste.png';
        $bucketName = 'gostop';
        $credentials = new Credentials(env('AWS_ACCESS_KEY_ID'), env('AWS_SECRET_ACCESS_KEY'));
        $client = new RekognitionClient(['region' => env('AWS_DEFAULT_REGION'), 'credentials' => $credentials, 'version' => 'latest']);
        $request = [
            'Image' => [
                'S3Object' => [
                    'Bucket' => $bucketName,
                    'Name' => $imageName
                ]
            ],
            'MinConfidence' => 30
        ];
        $response = $client->detectLabels($request);
        dd($response);
    }
}
