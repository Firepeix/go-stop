<?php


namespace App\Repositories\Control;

use App\Models\AbstractModel;
use App\Models\Control\TrafficLight;
use App\Repositories\AbstractRepository;
use App\Repositories\Interfaces\Control\TrafficLightRepositoryInterface;
use Illuminate\Support\Collection;

class TrafficLightRepository extends AbstractRepository implements TrafficLightRepositoryInterface
{
    public function find(int $id) : ? TrafficLight
    {
        return parent::find($id);
    }
    
    public function findOrFail(int $id): TrafficLight
    {
        return TrafficLight::findOrFail($id);
    }
    
    public function saveTrafficLight(TrafficLight $trafficLight): void
    {
        $trafficLight->save();
    }
    
    public function getTrafficLights(): Collection
    {
        return TrafficLight::all();
    }
    
    protected function getModel(): AbstractModel
    {
        return new TrafficLight();
    }
    
    public function index(): Collection
    {
        return new Collection();
    }
}
