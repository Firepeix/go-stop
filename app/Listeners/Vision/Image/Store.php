<?php

namespace App\Listeners\Vision\Image;

use App\Events\Vision\Image\StoreImage;
use App\Repositories\Interfaces\Vision\ImageRepositoryInterface;
use App\Services\Interfaces\Vision\ImageServiceInterface;
use Illuminate\Contracts\Queue\ShouldQueue;

class Store implements ShouldQueue
{
    private ImageRepositoryInterface $repository;
    private ImageServiceInterface $service;
    
    public function __construct(ImageRepositoryInterface $repository, ImageServiceInterface $service)
    {
        $this->service = $service;
        $this->repository = $repository;
    }
    
    public function handle(StoreImage $event)
    {
        $image = $event->getImage();
        $this->repository->storeFilePermanent($image);
    }
}
