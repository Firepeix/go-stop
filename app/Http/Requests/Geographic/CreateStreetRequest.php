<?php

namespace App\Http\Requests\Geographic;

use App\Interfaces\Geographic\CreateStreetInterface;
use Illuminate\Foundation\Http\FormRequest;

class CreateStreetRequest extends FormRequest implements CreateStreetInterface
{
    public function authorize() : bool
    {
        return true;
    }

    public function rules() : array
    {
        return [
            'name' => ['required', 'min:1', 'max:255']
        ];
    }
    
    public function getName(): string
    {
        return $this->get('name');
    }
}
