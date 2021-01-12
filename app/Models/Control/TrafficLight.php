<?php

namespace App\Models\Control;

use App\Interfaces\General\History\RegisterHistory;
use App\Models\AbstractModel;
use App\Models\Geographic\Street;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TrafficLight extends AbstractModel implements RegisterHistory
{
    const CLOSED  = '0';
    const WARNING = '1';
    const OPEN    = '2';
    
    public function street(): BelongsTo
    {
        return $this->belongsTo(Street::class);
    }
    
    public static function create(int $streetId, int $defaultSwitchTime): self
    {
        $light                    = new self();
        $light->street_id         = $streetId;
        $light->status            = self::CLOSED;
        $light->default_switch_time = $defaultSwitchTime;
        return $light;
    }
    
    public function getStatus(): string
    {
        return $this->status;
    }
    
    public function getDefaultSwitchTime(): int
    {
        return $this->default_switch_time;
    }
    
    public function getStreet(): Street
    {
        return $this->street;
    }
    
    public static function getAvailableStatus(): array
    {
        return [self::CLOSED, self::WARNING, self::OPEN];
    }
    
    public function warn(): void
    {
        $this->status = self::WARNING;
    }
    
    public function close(): void
    {
        $this->status = self::CLOSED;
    }
    
    public function open(): void
    {
        $this->status = self::OPEN;
    }
}
