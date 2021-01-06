<?php

namespace App\Models\Geographic;


use App\Models\AbstractModel;

class StreetConnection extends AbstractModel
{
    public static function create(Street $outgoingStreet, Street $incomingStreet) : self
    {
        $connection = new StreetConnection();
        $connection->parent_street_id = $outgoingStreet->getId();
        $connection->child_street_id = $incomingStreet->getId();
        return $connection;
    }
}
