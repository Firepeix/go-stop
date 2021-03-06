<?php


namespace App\Repositories;


use App\Models\AbstractModel;
use App\Repositories\Interfaces\RepositoryInterface;
use Illuminate\Support\Collection;

abstract class AbstractRepository implements RepositoryInterface
{
    abstract protected function getModel() : AbstractModel;
    
    public function first()
    {
        return $this->getModel()::first();
    }
    
    protected function rawIndex(AbstractModel $model): Collection
    {
        return $model::all();
    }
    
    protected function rawFindOrFail(int $id, AbstractModel $model)
    {
        return $model::findOrFail($id);
    }
    
    public function rawFirst(AbstractModel $model)
    {
        return $model::first();
    }
    
    public function save(AbstractModel $model) : void
    {
        $model->save();
    }
}
