<?php

namespace App\Models\Geographic;


use App\Interfaces\Geographic\CreateStreetInterface;
use App\Models\AbstractModel;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Support\Collection;

class Street extends AbstractModel
{
    public function outgoingStreets() : HasManyThrough
    {
        return $this->hasManyThrough(Street::class, StreetConnection::class, 'parent_street_id', 'id', 'id', 'child_street_id');
    }
    
    public function incomingStreets() : HasManyThrough
    {
        return $this->hasManyThrough(Street::class, StreetConnection::class, 'child_street_id', 'id', 'id', 'parent_street_id');
    }
    
    public static function create(CreateStreetInterface $createStreet) : self
    {
        $street = new Street();
        $street->name = $createStreet->getName();
        return $street;
    }
    
    public function getName() : string
    {
        return $this->name;
    }
    
    public function getOutgoingStreets() : Collection
    {
        return $this->outgoingStreets;
    }
    
    public function getIncomingStreets() : Collection
    {
        return $this->incomingStreets;
    }
}
