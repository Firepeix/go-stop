<?php


namespace App\Services\Geographic;


use App\Interfaces\Geographic\CreateStreetInterface;
use App\Models\Geographic\Street;
use App\Models\Geographic\StreetConnection;
use App\Services\Interfaces\Geographic\StreetServiceInterface;
use Illuminate\Support\Collection;

class StreetService implements StreetServiceInterface
{
    public function createStreet(CreateStreetInterface $createStreet): Street
    {
        return  Street::create($createStreet);
    }
    
    public function createConnections(Street $street, Collection $streets): Collection
    {
        $connections = collect();
        foreach ($streets as $receivingStreet) {
            $connections->push(StreetConnection::create($street, $receivingStreet));
        }
        return $connections;
    }
}