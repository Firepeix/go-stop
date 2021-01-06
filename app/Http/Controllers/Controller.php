<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Response;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\TransformerAbstract;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    private Manager $manager;
    protected Request  $request;
    protected Response $response;
    
    public function __construct(Request $request, Response $response)
    {
        $this->request  = $request;
        $this->response = $response;
        $this->manager = $this->createManager();
    }
    
    private function createManager() : Manager
    {
        $manager = new Manager();
        $includes = $this->request->get('include');
        if ($includes !== null) {
            $manager->parseIncludes($includes);
        }
        return $manager;
    }
    
    protected function item($item, TransformerAbstract $abstract)
    {
        $resource = new Item($item, $abstract);
        $data = $this->manager->createData($resource);
        return $this->response::json($data->toArray());
    }
    
    protected function collection($collection, TransformerAbstract $abstract)
    {
        $resource = new Collection($collection, $abstract);
        $data = $this->manager->createData($resource);
        return $this->response::json($data->toArray());
    }
}
