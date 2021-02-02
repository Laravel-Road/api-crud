<?php

use App\Http\Controllers\TaskController;
use App\Http\Controllers\TokenController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->group(function() {
    Route::get('/user', fn(Request $request) => $request->user());

    Route::apiResource('tasks', TaskController::class);

    Route::apiResource('tokens', TokenController::class)->only(['store', 'destroy']);
});
