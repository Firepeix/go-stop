<?php


namespace App\Http\Controllers\Geographic;


use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\Geographic\SampleRepositoryInterface;
use App\Services\Interfaces\Geographic\SampleServiceInterface;
use App\Transformers\Geographic\SampleTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class SampleController extends Controller
{
    private SampleServiceInterface $service;
    private SampleRepositoryInterface $repository;
    
    public function __construct(Request $request, Response $response, SampleServiceInterface $service, SampleRepositoryInterface $repository)
    {
        parent::__construct($request, $response);
        $this->service = $service;
        $this->repository = $repository;
    }
    
    public function index(): JsonResponse
    {
        $samples = $this->repository->index();
        return $this->collection($samples, new SampleTransformer());
    }
    
    public function show(int $sample): JsonResponse
    {
        $sample = $this->repository->findOrFail($sample);
        return $this->item($sample, new SampleTransformer());
    }
    
    public function record(int $sampleId) : JsonResponse
    {
        $sample = $this->repository->findOrFail($sampleId);
        $success = $this->service->record($sample, $this->request->get('action'));
        return new JsonResponse(['success' => $success]);
    }
}
