<?php


namespace App\Control\TrafficLight;


use App\Interfaces\General\History\RegisterMetadataInHistory;
use JetBrains\PhpStorm\ArrayShape;

class TrafficLightStatusHasChanged implements RegisterMetadataInHistory
{
    private string $from;
    private string $to;
    
    public function __construct(string $from, string $to)
    {
        $this->from = $from;
        $this->to = $to;
    }
    
    #[ArrayShape(['from' => "string", 'to' => "string"])]
    public function getMetadata(): array
    {
        return [
          'from' => $this->from,
          'to' => $this->to
        ];
    }
}