<?php


namespace App\Simulation\Sample;


class Street
{
    private int $id;
    private string $name;
    
    private function __construct(int $id, string $name)
    {
        $this->id   = $id;
        $this->name = $name;
    }
    
    public static function Sample(array $sample) : Street
    {
        return new Street($sample['info']['id'], $sample['info']['name']);
    }

    public function getId(): int
    {
        return $this->id;
    }
    
    public function getName(): string
    {
        return $this->name;
    }
}
