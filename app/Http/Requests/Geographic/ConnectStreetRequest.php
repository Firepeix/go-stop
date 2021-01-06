<?php

namespace App\Http\Requests\Geographic;

use App\Interfaces\Geographic\CreateStreetInterface;
use App\Models\Geographic\Street;
use App\Repositories\Interfaces\Geographic\StreetRepositoryInterface;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Collection;


class ConnectStreetRequest extends FormRequest
{
    private StreetRepositoryInterface $repository;
    
    public function __construct(StreetRepositoryInterface $repository, array $query = [], array $request = [], array $attributes = [], array $cookies = [], array $files = [], array $server = [], $content = null)
    {
        parent::__construct($query, $request, $attributes, $cookies, $files, $server, $content);
        $this->repository = $repository;
    }
    
    public function authorize() : bool
    {
        return true;
    }

    public function rules() : array
    {
        return [
            'streetsId' => ['required', 'array'],
            'streetsId.*' => ['required', 'numeric'],
        ];
    }
    
    /**
     * @return Collection|Street[]
     */
    public function getStreets(): Collection
    {
        return $this->repository->searchForWhereId($this->get('streetsId'));
    }
 
}
