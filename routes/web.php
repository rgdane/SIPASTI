<?php
use App\Http\Controllers\UserTypeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
// Route::get('/', [LandingPageController::class, 'index']);

Route::get('/', [WelcomeController::class, 'index']);

// Route Pengguna
Route::group(['prefix' => 'user'], function() {
    Route::get('/', [UserController::class, 'index']);
    Route::post('/list', [UserController::class, 'list']);
    Route::get('/create', [UserController::class, 'create']);
    Route::post('/store', [UserController::class, 'store']);
    Route::get('/{id}/show', [UserController::class, 'show']);
    Route::get('/{id}/edit', [UserController::class, 'edit']);
    Route::put('/{id}/update', [UserController::class, 'update']);
    Route::get('/{id}/delete', [UserController::class, 'confirm']);
    Route::delete('/{id}/delete', [UserController::class, 'delete']);
    Route::get('/import', [UserController::class, 'import']);
    Route::post('/import_excel', [UserController::class, 'import_excel']);
    Route::get('/export_excel', [UserController::class, 'export_excel']);
    Route::get('/export_pdf', [UserController::class, 'export_pdf']);
});

// Route Jenis Pengguna
Route::group(['prefix' => 'user_type'], function() {
    Route::get('/', [UserTypeController::class, 'index']);
    Route::post('/list', [UserTypeController::class, 'list']);
    Route::get('/create', [UserTypeController::class, 'create']);
    Route::post('/store', [UserTypeController::class, 'store']);
    Route::get('/{id}/show', [UserTypeController::class, 'show']);
    Route::get('/{id}/edit', [UserTypeController::class, 'edit']);
    Route::put('/{id}/update', [UserTypeController::class, 'update']);
    Route::get('/{id}/delete', [UserTypeController::class, 'confirm']);
    Route::delete('/{id}/delete', [UserTypeController::class, 'delete']);
    Route::get('/import', [UserTypeController::class, 'import']);
    Route::post('/import_excel', [UserTypeController::class, 'import_excel']);
    Route::get('/export_excel', [UserTypeController::class, 'export_excel']);
    Route::get('/export_pdf', [UserTypeController::class, 'export_pdf']);
});