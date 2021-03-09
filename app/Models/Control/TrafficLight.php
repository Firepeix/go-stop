<?php

namespace App\Models\Control;

use App\Interfaces\General\History\RegisterHistory;
use App\Models\AbstractModel;
use App\Models\Geographic\Street;
use App\Primitives\Position;
use Illuminate\Support\Collection;

class TrafficLight extends AbstractModel implements RegisterHistory
{
    const CLOSED  = '0';
    const WARNING = '1';
    const OPEN    = '2';
    
    const INCOMING = 0;
    const OUTGOING = 1;
    
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
    
    public function getStreets(int $direction): Collection
    {
        return $direction === TrafficLight::INCOMING ? $this->incomingStreets : $this->outgoingStreets;
    }
    
    public static function getAvailableDirections(): array
    {
        return [TrafficLight::INCOMING, TrafficLight::OUTGOING];
    }
    
    public function getGroupId(): int
    {
        return $this->group_id;
    }
    
    public function toArray(): array
    {
        return [
            'defaultSwitchTime' => $this->getDefaultSwitchTime(),
            'status'            => $this->getStatus(),
            'groupId'           => $this->getGroupId()
        ];
    }
    
    public function getName() : string
    {
        return $this->name;
    }
    
    public function getUUID() : string
    {
        return $this->uuid;
    }
    
    public function getSampleId() : int
    {
        return $this->sample_id;
    }
    
    public function getUpperPosition() : Position
    {
        return new Position($this->upperBoundX, $this->upperBoundY);
    }
    
    public function getLowerPosition() : Position
    {
        return new Position($this->lowerBoundX, $this->lowerBoundY);
    }
}
