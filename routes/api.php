<?php

use App\Http\Controllers\HomeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DeviceDataController;
use App\Http\Controllers\Api\DeviceController;
use App\Http\Controllers\TelegramController;
use Telegram\Bot\Laravel\Facades\Telegram;
// use App\Http\Controllers\Api\TelegramWebHookController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::prefix('device-data')->group(function () {
    Route::resource('/',DeviceDataController::class, ['as'=>'device-data']);
    Route::post('/attachment', [DeviceDataController::class, 'storeAttachment']);
});
Route::prefix('device')->group(function () {
    Route::resource('/',DeviceController::class, ['as' => 'device']);
});

Route::get('/stream-data',[HomeController::class,'getStreamData'])->name('get.stream-data');
Route::put('/stream-data/{id}',[HomeController::class,'updateStreamData'])->name('update.stream-data');
Route::post('/send_bot', [HomeController::class, 'sendMessageBot'])->name('sendMessage.post');
Route::post('/telegram/webhook',[TelegramController::class, 'webhook']);
Route::get('/set-webhook',[TelegramController::class, 'setWebHook']);
