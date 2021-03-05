<?php


namespace App\Interfaces\Vision\Fate;


use Illuminate\Support\Collection;

interface FatePredictResponseInterface
{
    public function getObjectsFound() : Collection;
}
