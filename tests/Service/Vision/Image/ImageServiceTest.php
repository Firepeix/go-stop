<?php

namespace Tests\Service\Vision\Image;

use App\Models\Vision\Image;
use App\Services\Interfaces\Vision\ImageServiceInterface;
use Tests\TestCase;

class ImageServiceTest extends TestCase
{
    private ImageServiceInterface $service;
    
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->createApplication();
        $this->service = app()->make(ImageServiceInterface::class);
    }
    
    private function getImageStub() : Image
    {
        $factory = Image::factory();
        return $factory->make();
    }
    
    public function testProcessImage() : void
    {
        $image = $this->getImageStub();
        $this->service->processImage($image);
        $this->assertSame(true, $image->hasProcessed());
        $this->assertSame(11, $image->getVehiclesQuantity());
    }
}
