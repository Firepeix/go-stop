<?php


namespace App\Models;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

abstract class AbstractModel extends Model
{
    use HasFactory;
    
    public function getId() : int
    {
        return $this->id;
    }
    
    public function getCreatedAt() : Carbon
    {
        return Carbon::parse($this->created_at);
    }
    
    public function getUpdatedAtAt() : Carbon
    {
        return Carbon::parse($this->updated_at);
    }
    
}