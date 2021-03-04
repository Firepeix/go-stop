<?php


namespace App\Repositories\Interfaces\Geographic;



use App\Models\Geographic\Sample;
use App\Repositories\Interfaces\RepositoryInterface;

interface SampleRepositoryInterface extends RepositoryInterface
{
    public function findOrFail(int $id) : Sample;
}
