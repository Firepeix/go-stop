<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::apiResources([
    'streets' => \App\Http\Controllers\Geographic\StreetController::class,
    'traffic-lights' => \App\Http\Controllers\Control\TrafficLightController::class,
    'cameras' => \App\Http\Controllers\Vision\CameraController::class,
]);

Route::prefix('streets')->group(function () {
    Route::post('{id}/connect', \App\Http\Controllers\Geographic\StreetController::class . '@connect');
});
