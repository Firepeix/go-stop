<?php

namespace App\Listeners\Control\TrafficLight;

use App\Events\Control\TrafficLight\NewSignal;
use App\Jobs\Control\TrafficLight\StatusStop;
use App\Models\Control\TrafficLight;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ChangeStatus
{
    public function handle(NewSignal $event)
    {
        $service = $event->getService();
        if ($event->getSignal() === TrafficLight::CLOSED) {
            $light = $event->getLight();
            StatusStop::dispatch($service, $event->getLight())->delay(Carbon::now()->addSeconds($light->getDefaultSwitchTime()));
            return;
        }
    }
}
