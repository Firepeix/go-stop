<?php

namespace Tests\Service\Vision\Camera;

use App\Models\Vision\Camera;
use App\Models\Vision\Image;
use App\Primitives\File;
use App\Services\Interfaces\Vision\CameraServiceInterface;
use Tests\TestCase;

class CameraServiceTest extends TestCase
{
    private CameraServiceInterface $service;
    
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->createApplication();
        $this->service = app()->make(CameraServiceInterface::class);
    }
    
    private function getCameraStub() : Camera
    {
        $factory = Camera::factory();
        return $factory->make();
    }
    
    public function testCaptureImages() : void
    {
        $camera = $this->getCameraStub();
        $imagesQuantity = 6;
        $images = $this->service->captureImages($camera, $imagesQuantity, 1050);
        $this->assertNotEmpty($images->toArray());
        $this->assertInstanceOf(Image::class, $images->first());
        $this->assertInstanceOf(File::class, $images->first()->getFile());
        $this->assertSame($imagesQuantity, $images->count());
    }
}
