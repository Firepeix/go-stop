<?php

namespace App\Events\Vision\Camera;

use App\Models\Vision\Camera;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class StartRecording
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private Camera $camera;
    
    public function __construct(Camera $camera)
    {
        $this->camera   = $camera;
    }
    
    public function getCamera(): Camera
    {
        return $this->camera;
    }
}
