<?php


namespace App\Primitives;


use Illuminate\Contracts\Support\Arrayable;
use JetBrains\PhpStorm\ArrayShape;

class Position implements Arrayable
{
    private float $x;
    private float $y;
    
    public function __construct(float $x, float $y)
    {
        $this->x = $x;
        $this->y = $y;
    }
    
    public function getX(): float
    {
        return $this->x;
    }
    
    public function getY(): float
    {
        return $this->y;
    }
    
    public function isBiggerThan(Position $position): bool
    {
        return $this->x >= $position->x && $this->y >= $position->y;
    }
    
    public function isSmallerThan(Position $position): bool
    {
        return $this->x <= $position->x && $this->y <= $position->y;
    }
    
    #[ArrayShape(['x' => "float", 'y' => "float"])]
    public function toArray(): array
    {
        return [
            'x' => $this->x,
            'y' => $this->y,
        ];
    }
}
