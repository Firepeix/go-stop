<?php


namespace App\Vision\Camera\Parsers;


use App\Interfaces\Vision\Camera\Parsers\CameraImageParser;
use App\Primitives\File;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DiaOnlineParser implements CameraImageParser
{
    private string $sessionId;
    private int $cameraId;
    private bool $sandbox;
    private Filesystem $rawImagesStorage;
    private Client $client;
    
    
    /**
     * @var Collection|File[]
     */
    private Collection $files;
    
    public function __construct(int $cameraId)
    {
        $this->rawImagesStorage = Storage::disk('raw-images');
        $this->client = new Client(['base_uri' => env('CRAWLER_URL'), 'headers' => [ 'Accept' => 'application/json']]);
        $this->createSession();
        $this->cameraId = $cameraId;
        $this->files = new Collection();
        $this->sandbox = env('APP_ENV') === 'testing';
    }
    
    private function createSession() : void
    {
        $id = hash('md5', Carbon::now()->toDateTimeString() . Str::random(4));
        $this->rawImagesStorage->makeDirectory($id);
        $this->sessionId = $id;
    }
    
    public function captureFiles(int $frames, int $secondsPerFrame): Collection
    {
        $this->openSession($frames, $secondsPerFrame);
        $this->loadFiles();
        return $this->files;
    }
    
    public function closesSession(): void
    {
        $this->rawImagesStorage->deleteDirectory($this->sessionId);
    }
    
    private function openSession(int $frames, int $secondsPerFrame): void
    {
        $this->files = new Collection();
        if (!$this->sandbox) {
            $this->client->post('/get-camera', [
                'json' => [
                    'id' => $this->cameraId,
                    'sessionId' => $this->sessionId,
                    'frames' => $frames - 1,
                    'secondsPerFrame' => $secondsPerFrame
                ]
            ]);
        }
    }
    
    private function loadFiles() : void
    {
        $storage = Storage::disk('local');
        $path = 'stubs/vision/camera/raw-images';
        $rawImages = storage_path('app/stubs/vision/camera/raw-images');
        
        if (!$this->sandbox) {
            $storage = $this->rawImagesStorage;
            $path = $this->sessionId;
            $rawImages = storage_path('app/raw-images/' . $this->sessionId);
        }
        
        $filePaths = $storage->files($path);
        foreach ($filePaths as $filePath) {
            $this->files->push(new File("$rawImages/" . collect(explode('/', $filePath))->last()));
        }
    }
}