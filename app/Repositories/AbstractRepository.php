<?php


namespace App\Repositories;


use App\Repositories\Interfaces\RepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

abstract class AbstractRepository implements RepositoryInterface
{
    protected function rawIndex(Model $model): Collection
    {
        return $model::all();
    }
    
    protected function rawFindOrFail(int $id, Model $model)
    {
        return $model::findOrFail($id);
    }
    
    public function save(Model $model) : void
    {
        $model->save();
    }
}
