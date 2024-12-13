<?php

use App\Http\Controllers\Api\CertificationHistoryController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\LogoutController;
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

Route::post('/login', LoginController::class)->name('login');
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/logout', LogoutController::class)->name('logout');;

//Route Riwayat Pelatihan
Route::get('/training_history/{user}', [TrainingHistoryController::class, 'index']);
Route::get('/training_history/show/{id}', [TrainingHistoryController::class, 'show']);

//Route Riwayat Sertifikasi
Route::get('/certification/{user}', [CertificationHistoryController::class, 'index']);
Route::get('/certification/show/{id}', [CertificationHistoryController::class, 'show']);

