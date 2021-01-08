<?php


namespace App\Services\Interfaces\General;

use App\Interfaces\General\History\RegisterHistory;
use App\Interfaces\General\History\RegisterMetadataInHistory;
use App\Models\General\History;

interface HistoryServiceInterface
{
    public function createHistory(RegisterHistory $registerHistory, int $action, RegisterMetadataInHistory $metadataInHistory = null) : History;
}