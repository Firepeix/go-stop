<?php


namespace App\Simulation\Sample;


use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class Vehicle
{
    private string     $id;
    private int        $entryId;
    private int        $departureId;
    private Collection $route;
    private ?string    $isOn;
    private ?string    $waitingOn;
    private int        $step;
    private Collection $history;
    
    public function __construct(int $entryId, int $departureId, Collection $route)
    {
        $createdDate       = Carbon::now()->toDateTimeString() . Str::random(6);
        $this->id          = hash('MD5', "{$entryId}{$departureId}{$route->implode(',')}$createdDate");
        $this->entryId     = $entryId;
        $this->departureId = $departureId;
        $this->route       = $route;
        $this->isOn        = $entryId;
        $this->step        = 0;
        $this->waitingOn   = $route[0 + 1];
        $this->history     = new Collection();
    }
    
    public function isOn(): ?string
    {
        return $this->isOn;
    }
    
    public function waitingOn(): string
    {
        return $this->waitingOn;
    }
    
    public function hasArrived(): bool
    {
        return $this->waitingOn === null;
    }
    
    public function getId(): string
    {
        return $this->id;
    }
    
    public function advance(): void
    {
        $nextStreet = $this->route[$this->step + 2] ?? null;
        if ($nextStreet !== null) {
            $this->history->push(['from' => $this->isOn, 'to' => $this->waitingOn, 'time' => Carbon::now()->toDateTimeString()]);
            $this->step      = $this->step + 1;
            $this->isOn      = $this->route[$this->step];
            $this->waitingOn = $nextStreet;
            return;
        }
        $this->waitingOn = null;
        $this->history->push(['from' => $this->isOn, 'to' => $this->departureId, 'time' => Carbon::now()->toDateTimeString()]);
    }
    
    public function getHistory(): array
    {
        return $this->history->toArray();
    }
}
