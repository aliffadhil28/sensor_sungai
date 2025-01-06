<?php

use App\Http\Controllers\HomeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DeviceDataController;
use App\Http\Controllers\Api\DeviceController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::prefix('device-data')->group(function () {
    Route::resource('/',DeviceDataController::class);
    Route::post('/attachment', [DeviceDataController::class, 'storeAttachment']);
});
Route::prefix('device')->group(function () {
    Route::resource('/',DeviceController::class);
});

Route::get('/stream-data',[HomeController::class,'getStreamData'])->name('get.stream-data');
Route::put('/stream-data/{id}',[HomeController::class,'updateStreamData'])->name('update.stream-data');
