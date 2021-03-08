<?php


namespace App\Primitives;


class Transform
{
    private float $width;
    private float $height;
    
    public function __construct(float $width, float $height)
    {
        $this->width  = $width;
        $this->height = $height;
    }
    
    public function getWidth(): float
    {
        return $this->width;
    }
    
    public function getHeight(): float
    {
        return $this->height;
    }
}
