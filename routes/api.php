<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodoController;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\CustomAuthMiddleware;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group([ 'prefix' => 'auth'], function ($router) {

    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
});


Route::group([ 'middleware' => 'custom.auth','prefix' => 'v1'], function ($router) {

    Route::get('/todo', [TodoController::class, 'index']);
    Route::post('/todo', [TodoController::class, 'store']);
    Route::get('/todo/{todo}', [TodoController::class, 'show']);
    Route::put('/todo/{todo}', [TodoController::class, 'update']);
    Route::delete('/todo/{todo}', [TodoController::class, 'destroy']);

     Route::post('/logout/{id}', [AuthController::class, 'logout']);
     Route::post('/refresh-token/{id}', [AuthController::class, 'refreshToken']);

});