<?php


namespace App\Repositories\General;


use App\Interfaces\Geographic\CreateStreetInterface;
use App\Models\General\History;
use App\Models\Geographic\Street;
use App\Models\Geographic\StreetConnection;
use App\Repositories\Interfaces\General\HistoryRepositoryInterface;
use App\Repositories\Interfaces\Geographic\StreetRepositoryInterface;
use Illuminate\Support\Collection;

class HistoryRepository implements HistoryRepositoryInterface
{
    public function saveHistory(History $history): void
    {
        $history->save();
    }
    
}