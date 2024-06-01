<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SensorReadingController;
use App\Http\Controllers\DeviceController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/sensor-readings', [SensorReadingController::class, 'index']); // bütün sensör verilerini görüntüleme
Route::post('/sensor-readings', [SensorReadingController::class, 'store']); // yeni sensor eklenirken create
Route::get('/sensor-readings/{id}', [SensorReadingController::class, 'show']); // sensore özel veri çekilirken
Route::put('/sensor-readings/{id}', [SensorReadingController::class, 'update']); // veri güncellemesi
Route::delete('/sensor-readings/{id}', [SensorReadingController::class, 'destroy']); // sensör silme

Route::get('/devices', [DeviceController::class, 'index']);
Route::post('/devices', [DeviceController::class, 'store']);
Route::get('/devices/{id}', [DeviceController::class, 'show']);
Route::put('/devices/{id}', [DeviceController::class, 'update']);
Route::delete('/devices/{id}', [DeviceController::class, 'destroy']);
