<?php

use App\Http\Controllers\Control\TrafficLightController;
use App\Http\Controllers\Geographic\SampleController;
use App\Http\Controllers\Geographic\StreetController;
use App\Http\Controllers\Vision\CameraController;
use Illuminate\Support\Facades\Route;

Route::apiResources([
    'streets' => StreetController::class,
    'samples' => SampleController::class,
    'traffic-lights' => TrafficLightController::class,
    'cameras' => CameraController::class,
]);

Route::prefix('streets')->group(function () {
    Route::post('{id}/connect', StreetController::class . '@connect');
});

Route::prefix('samples')->group(function () {
    Route::post('{sampleId}/record', SampleController::class . '@record');
    Route::get('{sampleId}/get-rate', SampleController::class . '@getRate');
});
