<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MacroController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\DeviceController;

Route::controller(UserController::class)->group(function () {
    Route::post('/login', 'login')->withoutMiddleware(['token']);
});

Route::controller(MacroController::class)->group(function () {
    Route::get('/macros', 'index');
    Route::post('/macros', 'store');
    Route::get('/macros/{macro}', 'activate')->missing(fn () => response([ 'success' => false ], 404) );
    Route::delete('/macros/{macro}', 'destroy')->missing(fn () => response([ 'success' => false ], 404) );
});

Route::controller(RoomController::class)->group(function () {
    Route::get('/rooms', 'index');
    Route::get('/rooms/{room}', 'show')->missing(fn () => response(['error' => 'We don\'t have a record of this room'], 404));
});

Route::controller(DeviceController::class)->group(function () {
    Route::get('/rooms/{room}/devices', 'index')->missing(fn () => response(['error' => 'We don\'t have a record of this room'], 404));
    Route::get('/devices/{device}', 'show')->missing(fn () => response(['error' => 'We don\'t have a record of this device'], 404));
    Route::patch('/devices/{device}', 'update')->missing(fn () => response(['error' => 'We don\'t have a record of this device'], 404));
});
