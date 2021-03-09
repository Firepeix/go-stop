<?php


namespace App\Repositories\Interfaces;


use App\Models\AbstractModel;
use Illuminate\Support\Collection;

interface RepositoryInterface
{
    public function index() : Collection;
    
    public function first();
    
    public function find(int $id);
    
    public function save(AbstractModel $model) : void;
    
    public function findOrFail(int $id);
}
