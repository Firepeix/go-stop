<?php


namespace App\Interfaces\Vision\Fate;


use JetBrains\PhpStorm\ArrayShape;

interface FatePredictResponseInterface
{
    #[ArrayShape(['label' => "string", 'probability' => "float"])]
    public function getObjectsFound() : array;
}