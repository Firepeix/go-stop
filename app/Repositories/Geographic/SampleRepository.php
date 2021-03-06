<?php


namespace App\Repositories\Geographic;

use App\Models\AbstractModel;
use App\Models\Geographic\Sample;
use App\Repositories\AbstractRepository;
use App\Repositories\Interfaces\Geographic\SampleRepositoryInterface;
use Illuminate\Support\Collection;

class SampleRepository extends AbstractRepository implements SampleRepositoryInterface
{
    protected function getModel(): AbstractModel
    {
        return new Sample();
    }
    
    public function index(): Collection
    {
        return parent::rawIndex(new Sample());
    }
    
    public function findOrFail(int $id) : Sample
    {
        return parent::rawFindOrFail($id, new Sample());
    }
}
