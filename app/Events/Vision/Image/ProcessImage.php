<?php

namespace App\Events\Vision\Image;

use App\Models\Vision\Image;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProcessImage
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    
    private Image $image;
    
    public function __construct(Image $image)
    {
        $this->image = $image;
    }
    
    public function getImage(): Image
    {
        return $this->image;
    }
}
