<?php

namespace Tests\Unit\Geographic;


use App\Models\Control\TrafficLight;
use Tests\Stubs\Geographic\StreetStub;
use Tests\TestCase;

class StreetTest extends TestCase
{
    public function testGetConnectedStreets()
    {
        $stub = new StreetStub(5, [0 => [1,2], 1 => [2,0], 2 => [1], 3 => [1]], [0], [1], true);
        $streets = $stub->getStreets();
        $notConnectedStreet = $streets[4];
        $streets = $streets[0]->getConnectedStreets($streets);
        $this->assertEquals(4, $streets->count());
        $this->assertNull($streets->firstWhere('id', $notConnectedStreet->getId()));
    }
}
