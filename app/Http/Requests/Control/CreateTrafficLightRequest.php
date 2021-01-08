<?php

namespace App\Http\Requests\Control;

use App\Interfaces\Control\TrafficLight\CreateTrafficLightInterface;
use App\Models\Geographic\Street;
use App\Repositories\Interfaces\Geographic\StreetRepositoryInterface;
use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;

class CreateTrafficLightRequest extends FormRequest implements CreateTrafficLightInterface
{
    private StreetRepositoryInterface $streetRepository;
    
    public function __construct(StreetRepositoryInterface $streetRepository, array $query = [], array $request = [], array $attributes = [], array $cookies = [], array $files = [], array $server = [], $content = null)
    {
        parent::__construct($query, $request, $attributes, $cookies, $files, $server, $content);
        $this->streetRepository = $streetRepository;
    }
    
    public function authorize() : bool
    {
        return true;
    }

    #[ArrayShape(["string"])]
    public function rules() : array
    {
        return [
            'streetId' => ['required', 'numeric'],
            'defaultSwitchTime' => ['required', 'numeric']
        ];
    }
    
    public function getStreet(): Street
    {
        return $this->streetRepository->findOrFail($this->get('streetId'));
    }
    
    public function getDefaultSwitchTime(): int
    {
        return $this->get('defaultSwitchTime');
    }
}
