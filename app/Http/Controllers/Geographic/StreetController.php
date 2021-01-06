<?php


namespace App\Http\Controllers\Geographic;


use App\Http\Controllers\Controller;
use App\Http\Requests\Geographic\ConnectStreetRequest;
use App\Http\Requests\Geographic\CreateStreetRequest;
use App\Repositories\Interfaces\Geographic\StreetRepositoryInterface;
use App\Services\Interfaces\Geographic\StreetServiceInterface;
use App\Transformers\Geographic\StreetTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class StreetController extends Controller
{
    private StreetServiceInterface $service;
    private StreetRepositoryInterface $repository;
    
    public function __construct(Request $request, Response $response, StreetServiceInterface $service, StreetRepositoryInterface $repository)
    {
        parent::__construct($request, $response);
        $this->service = $service;
        $this->repository = $repository;
    }
    
    public function index()
    {
        $streets = $this->repository->getStreets();
        return $this->collection($streets, new StreetTransformer());
    }
    
    public function store(CreateStreetRequest $request)
    {
        $street = $this->service->createStreet($request);
        $this->repository->saveStreet($street);
        return $this->item($street, new StreetTransformer());
    }
    
    public function connect(int $streetId, ConnectStreetRequest $request)
    {
        $street = $this->repository->findOrFail($streetId);
        $connections = $this->service->createConnections($street, $request->getStreets());
        foreach ($connections as $connection) {
            $this->repository->saveStreetConnection($connection);
        }
    
        return $this->item($street, new StreetTransformer());
    }
}