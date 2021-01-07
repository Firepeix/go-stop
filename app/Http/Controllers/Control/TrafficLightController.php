<?php


namespace App\Http\Controllers\Control;


use App\Http\Controllers\Controller;
use App\Http\Requests\Control\CreateTrafficLightRequest;
use App\Repositories\Interfaces\Control\TrafficLightRepositoryInterface;
use App\Services\Interfaces\Control\TrafficLightServiceInterface;
use App\Transformers\Control\TrafficLightTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class TrafficLightController extends Controller
{
    private TrafficLightServiceInterface $service;
    private TrafficLightRepositoryInterface $repository;
    
    public function __construct(Request $request, Response $response, TrafficLightServiceInterface $service, TrafficLightRepositoryInterface $repository)
    {
        parent::__construct($request, $response);
        $this->service = $service;
        $this->repository = $repository;
    }
    
    public function index() : JsonResponse
    {
        $trafficLights = $this->repository->getTrafficLights();
        return $this->collection($trafficLights, new TrafficLightTransformer());
    }
    
    public function store(CreateTrafficLightRequest $request) : JsonResponse
    {
        $light = $this->service->createTrafficLight($request);
        $this->repository->saveTrafficLight($light);
        return $this->item($light, new TrafficLightTransformer());
    }
}