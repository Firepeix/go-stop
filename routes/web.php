<?php

use Illuminate\Support\Facades\Route;

Route::get('snapshot/{cameraId}', \App\Http\Controllers\Vision\CameraController::class . '@cameraView');