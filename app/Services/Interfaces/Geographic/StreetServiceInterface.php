<?php


namespace App\Services\Interfaces\Geographic;


use App\Interfaces\Geographic\CreateStreetInterface;
use App\Models\Geographic\Street;
use Illuminate\Support\Collection;

interface StreetServiceInterface
{
    public function createStreet(CreateStreetInterface $createStreet) : Street;
    
    public function createConnections(Street $street, Collection $streets) : Collection;
    
    public function constructSample(Collection $streets) : array;
}
