<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SensorReadingController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/sensor-readings', [SensorReadingController::class, 'main']); // bütün sensör verilerini görüntüleme
