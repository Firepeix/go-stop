<?php


namespace App\Repositories\Interfaces;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface RepositoryInterface
{
    public function index() : Collection;
    
    public function first();
    
    public function save(Model $model) : void;
    
    public function findOrFail(int $id);
}
