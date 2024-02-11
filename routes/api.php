<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TodoController;
use App\Http\Controllers\FakerController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group([ 'prefix' => 'auth'], function () {

    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
});

Route::apiResource('/v1/fakers',FakerController::class);


Route::group(['prefix' => 'v1', 'middleware' => ['custom.auth']], function(){

    Route::apiResource('/todos',TodoController::class);
    Route::post('/logout/{id}', [AuthController::class, 'logout']);
    Route::post('/refresh-token/{id}', [AuthController::class, 'refreshToken']);
});