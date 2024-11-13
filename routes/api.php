<?php

use App\Http\Controllers\Api\UserTypeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/user_type', [UserTypeController::class, 'index']);
Route::post('/user_type', [UserTypeController::class, 'store']);
Route::get('/user_type/{user_type}', [UserTypeController::class, 'show']);
Route::put('/user_type/{user_type}', [UserTypeController::class, 'update']);
Route::delete('/user_type/{user_type}', [UserTypeController::class, 'destroy']);
