<?php

namespace App\Models\General;

use App\Models\AbstractModel;

class History extends AbstractModel
{
    const CREATE = 1;
    const UPDATE = 2;
    
    public static function create(int $entity_id, int $action, array $metadata = null) : self
    {
        $history = new History();
        $history->entity_id = $entity_id;
        $history->action = $action;
        if ($metadata !== null) {
            $history->metadata = json_encode($metadata);
        }
        
        return $history;
    }
}
