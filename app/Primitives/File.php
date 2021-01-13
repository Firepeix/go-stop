<?php


namespace App\Primitives;


use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Http\File as LaravelFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class File extends LaravelFile
{
    private Filesystem $tmpStorage;
    public function __construct(string $path, bool $checkPath = true)
    {
        parent::__construct($path, $checkPath);
        $this->tmpStorage = Storage::disk('tmp');
    }
    
    public function spawnBase64File() : File
    {
        [$type, $data] = explode(',', $this->getContent());
        $type      = explode(';', collect(explode('/', $type))->last())[0];
        $path = Str::random(40) . ".$type";
        $this->tmpStorage->put($path, base64_decode($data));
        return new File("/tmp/$path");
    }
}