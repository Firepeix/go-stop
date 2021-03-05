<?php


namespace App\Vision\Fate;


use App\Primitives\Position;

class PredictObject
{
    private string $id;
    private string $label;
    private float $probability;
    private float $width;
    private float $height;
    private Position $upperBoundLimit;
    private Position $lowerBoundLimit;
    
    public function __construct(string $label, float $probability, Position $upperBoundLimit, Position $lowerBoundLimit)
    {
        $this->label           = $label;
        $this->probability     = $probability;
        $this->upperBoundLimit = $upperBoundLimit;
        $this->lowerBoundLimit = $lowerBoundLimit;
        $this->width = $lowerBoundLimit->getX() - $upperBoundLimit->getX();
        $this->height = $lowerBoundLimit->getY() - $upperBoundLimit->getY();
        $this->id = hash('MD5', json_encode(get_object_vars($this)));
    }
    
    public function getId(): string
    {
        return $this->id;
    }
    
    public function getLabel(): string
    {
        return $this->label;
    }
    
    public function getProbability(): float
    {
        return $this->probability;
    }
    
    public function getUpperBoundLimit(): Position
    {
        return $this->upperBoundLimit;
    }
    
    public function getLowerBoundLimit(): Position
    {
        return $this->lowerBoundLimit;
    }
    
    public function isInside(PredictObject $object): bool
    {
        $upperX = $this->getUpperBoundLimit()->getX() - $object->getUpperBoundLimit()->getX();
        $upperY = $this->getUpperBoundLimit()->getY() - $object->getUpperBoundLimit()->getY();
        $lowerX = $this->getLowerBoundLimit()->getX() - $object->getLowerBoundLimit()->getX();
        $lowerY = $this->getLowerBoundLimit()->getY() - $object->getLowerBoundLimit()->getY();
        $upperDifference = ($upperY > -1 && $upperY < 1) && ($upperX > -1 && $upperX < 1);
        $lowerDifference = ($lowerY > -1 && $lowerY < 1) && ($lowerX > -1 && $lowerX < 1);
        return $upperDifference || $lowerDifference;
    }
    
    public function moreAccurate(PredictObject $object): bool
    {
        return $this->probability > $object->probability;
    }
    
    public function isBigEnoughVehicle() : bool
    {
        return $this->width > 10 && $this->height > 10;
    }
}
