<?php


namespace App\Repositories\Geographic;


use App\Interfaces\Geographic\CreateStreetInterface;
use App\Models\Geographic\Street;
use App\Models\Geographic\StreetConnection;
use App\Repositories\Interfaces\Geographic\StreetRepositoryInterface;
use Illuminate\Support\Collection;

class StreetRepository implements StreetRepositoryInterface
{
    public function saveStreet(Street $street) : void
    {
        $street->save();
    }
    
    public function saveStreetConnection(StreetConnection $streetConnection): void
    {
        $streetConnection->save();
    }
    
    public function findOrFail(int $id): Street
    {
        return Street::findOrFail($id);
    }
    
    public function searchForWhereId(array $ids): Collection
    {
        return Street::whereIn('id', $ids)->get();
    }
    
    public function getStreets(): Collection
    {
        return Street::all();
    }
}