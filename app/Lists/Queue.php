<?php


namespace App\Lists;


use Illuminate\Support\Collection;
use ArrayAccess;

class Queue implements ArrayAccess
{
    private Collection $items;
    
    public function __construct()
    {
        $this->items = new Collection();
    }
    
    public function enqueue(mixed $item) : void
    {
        $this->items->push($item);
    }
    
    public function dequeue() : mixed
    {
        $item = $this->items->pull(0);
        $this->items = $this->items->values();
        return $item;
    }
    
    public function count() : int
    {
        return $this->items->count();
    }
    
    public function offsetExists($offset)
    {
        return $this->items->offsetExists($offset);
    }
    
    public function offsetGet($offset)
    {
        return $this->items->offsetGet($offset);
    }
    
    public function offsetSet($offset, $value)
    {
        $this->items->offsetSet($offset, $value);
    }
    
    public function offsetUnset($offset)
    {
        $this->items->offsetUnset($offset);
    }
    
    public function isEmpty() : bool
    {
        return $this->items->isEmpty();
    }
    
    public function toList() : Collection
    {
        return clone $this->items;
    }
    
}
