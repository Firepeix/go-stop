<?php


namespace App\Models\Vision\Objects;


use App\Models\AbstractModel;
use App\Models\Vision\Image;
use App\Primitives\Position;
use App\Primitives\Transform;
use JetBrains\PhpStorm\Pure;

class Vehicle extends AbstractModel
{
    const TRANSPORTATION = 0;
    const VEHICLE = 1;
    const CAR = 2;
    const AUTOMOBILE = 3;
    
    #[Pure]
    public static function CreateAmazon(Image $image, int $type, Position $position, Transform $transform) : self
    {
        $vehicle = new Vehicle();
        $vehicle->image_id = $image->getId();
        $vehicle->type = $type;
        $vehicle->x = $position->getX();
        $vehicle->y = $position->getY();
        $vehicle->width = $transform->getWidth();
        $vehicle->height = $transform->getHeight();
        
        return $vehicle;
    }
    
    public function getPosition(Image $image = null) : Position
    {
        if ($image !== null) {
            $transform = $image->getTransform();
            return new Position($this->x * $transform->getWidth(), $this->y * $transform->getHeight());
        }
        return new Position($this->x * 100, $this->y * 100);
    }
}
