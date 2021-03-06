<?php


namespace App\Interfaces\Vision\Camera\Parsers;

use Illuminate\Support\Collection;

interface CameraImageParser
{
    public function captureFiles(int $frames) : Collection;
    
    public function closesSession(): void;
}
