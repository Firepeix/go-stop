<?php

namespace Tests\Service\Vision\Image;

use App\Models\Vision\Image;
use App\Primitives\Position;
use App\Repositories\Interfaces\Vision\ImageRepositoryInterface;
use App\Services\Interfaces\Vision\ImageServiceInterface;
use Tests\TestCase;

class ImageServiceTest extends TestCase
{
    private ImageServiceInterface $service;
    private ImageRepositoryInterface $repository;
    
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->createApplication();
        $this->service = app()->make(ImageServiceInterface::class);
        $this->repository = app()->make(ImageRepositoryInterface::class);
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
        $this->assertSame(27, $image->getVehiclesQuantity());
    }
    
    public function testProcessCutImage() : void
    {
        $image = Image::factory()->exists()->make();
        $this->service->cutImage($image, new Position(93, 460), new Position(381, 541), false);
        $this->assertTrue(true);
    }
    
    public function testSortAndSave() : void
    {
        $images = $this->repository->index();
        $this->repository->sortStore($images);
        $this->assertTrue(true);
    }
}
