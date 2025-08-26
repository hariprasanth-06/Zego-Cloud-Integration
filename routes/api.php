<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ZegoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('/login', [AuthController::class, 'login']);
});

Route::group([
    'middleware' => 'auth:api',
    'prefix' => 'zego'
], function ($router) {
    Route::post('/join_room', [ZegoController::class, 'createRoom'])->name('join_room');
});
