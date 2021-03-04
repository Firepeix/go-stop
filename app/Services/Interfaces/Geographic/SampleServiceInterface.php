<?php


namespace App\Services\Interfaces\Geographic;


use App\Models\Geographic\Sample;

interface SampleServiceInterface
{
    public function record(Sample $sample, int $action) : bool;
}
