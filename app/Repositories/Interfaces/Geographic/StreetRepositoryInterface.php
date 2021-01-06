<?php


namespace App\Repositories\Interfaces\Geographic;


use App\Interfaces\Geographic\CreateStreetInterface;
use App\Models\Geographic\Street;
use App\Models\Geographic\StreetConnection;
use Illuminate\Support\Collection;

interface StreetRepositoryInterface
{
    public function getStreets(): Collection;
    
    public function saveStreet(Street $street) : void;
    
    public function saveStreetConnection(StreetConnection $streetConnection) : void;
    
    public function findOrFail(int $id) : Street;
    
    public function searchForWhereId(array $ids) : Collection;
}