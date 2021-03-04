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
    private int $secondsPerFrame;
    
    public function __construct(Camera $camera, int $secondsPerFrame)
    {
        $this->camera   = $camera;
        $this->secondsPerFrame  = $secondsPerFrame;
    }
    
    public function getCamera(): Camera
    {
        return $this->camera;
    }
    
    public function getSecondsPerFrame(): int
    {
        return $this->secondsPerFrame;
    }
}
