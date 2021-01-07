<?php

namespace App\Http\Requests\Vision;

use App\Interfaces\Vision\CreateCameraInterface;
use App\Models\Control\TrafficLight;
use App\Repositories\Interfaces\Control\TrafficLightRepositoryInterface;
use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;

class CreateCameraRequest extends FormRequest implements CreateCameraInterface
{
    private TrafficLightRepositoryInterface $trafficLightRepository;
    
    public function __construct(TrafficLightRepositoryInterface $trafficLightRepository, array $query = [], array $request = [], array $attributes = [], array $cookies = [], array $files = [], array $server = [], $content = null)
    {
        parent::__construct($query, $request, $attributes, $cookies, $files, $server, $content);
        $this->trafficLightRepository = $trafficLightRepository;
    }
    
    public function authorize() : bool
    {
        return true;
    }

    #[ArrayShape(['trafficLightId' => "string[]"])]
    public function rules() : array
    {
        return [
            'trafficLightId' => ['required', 'numeric']
        ];
    }
    
    public function getTrafficLight(): TrafficLight
    {
        return $this->trafficLightRepository->findOrFail($this->get('trafficLightId'));
    }
}
