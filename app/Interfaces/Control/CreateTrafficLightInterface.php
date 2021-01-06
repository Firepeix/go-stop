<?php


namespace App\Interfaces\Control;


use App\Models\Geographic\Street;

interface CreateTrafficLightInterface
{
    public function getStreet() : Street;
}