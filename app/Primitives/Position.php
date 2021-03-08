<?php


namespace App\Primitives;


class Position
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
    
    public function isBiggerThan(Position $position) : bool
    {
        return $this->x >= $position->x && $this->y >= $position->y;
    }
    
    public function isSmallerThan(Position $position) : bool
    {
        return $this->x <= $position->x && $this->y <= $position->y;
    }
}
