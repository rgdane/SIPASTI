<?php

use App\Http\Controllers\Api\UserTypeController;
use App\Http\Controllers\Api\TrainingHistoryController;
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

Route::post('/login', App\Http\Controllers\Api\LoginController::class)->name('login');
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/logout', App\Http\Controllers\Api\LogoutController::class)->name('logout');

//Route Riwayat Pelatihan
    Route::get('/training_history', [TrainingHistoryController::class, 'index']);
    Route::post('/training_history/list', [TrainingHistoryController::class, 'list']);
    Route::get('/training_history/{id}/show', [TrainingHistoryController::class, 'show']);

