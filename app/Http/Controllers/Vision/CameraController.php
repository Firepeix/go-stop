<?php


namespace App\Http\Controllers\Vision;


use App\Http\Controllers\Controller;
use App\Http\Requests\Vision\CreateCameraRequest;
use App\Repositories\Interfaces\Vision\CameraRepositoryInterface;
use App\Services\Interfaces\Vision\CameraServiceInterface;
use App\Transformers\Vision\CameraTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class CameraController extends Controller
{
    private CameraServiceInterface $service;
    private CameraRepositoryInterface $repository;
    
    public function __construct(Request $request, Response $response, CameraServiceInterface $service, CameraRepositoryInterface $repository)
    {
        parent::__construct($request, $response);
        $this->service = $service;
        $this->repository = $repository;
    }
    
    public function store(CreateCameraRequest $request) : JsonResponse
    {
        $camera = $this->service->createCamera($request);
        $this->repository->saveCamera($camera);
        return $this->item($camera, new CameraTransformer());
    }
}