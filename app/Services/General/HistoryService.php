<?php


namespace App\Services\General;


use App\Interfaces\General\History\RegisterHistory;
use App\Interfaces\General\History\RegisterMetadataInHistory;
use App\Models\General\History;
use App\Services\Interfaces\General\HistoryServiceInterface;

class HistoryService implements HistoryServiceInterface
{
    public function createHistory(RegisterHistory $registerHistory, int $action, RegisterMetadataInHistory $metadataInHistory = null): History
    {
        return History::create($registerHistory->getId(), $action, $metadataInHistory?->getMetadata());
    }
}