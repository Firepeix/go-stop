<?php


namespace App\Repositories\Interfaces\General;

use App\Models\General\History;

interface HistoryRepositoryInterface
{
    public function saveHistory(History $history) : void;
}