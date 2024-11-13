<?php

use App\Http\Controllers\CertificationController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\InterestController;
use App\Http\Controllers\TrainingController;
use App\Http\Controllers\TypeCertification;
use App\Http\Controllers\TypeTraining;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserTypeController;
use App\Http\Controllers\VendorCertification;
use App\Http\Controllers\VendorTraining;
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

// Admin
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

// Route Level Pengguna
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
    Route::post('/import', [UserTypeController::class, 'import']);
    Route::get('/export_excel', [UserTypeController::class, 'export_excel']);
    Route::get('/export_pdf', [UserTypeController::class, 'export_pdf']);
});

// Route Data Sertifikasi
Route::group(['prefix' => 'certification'], function() {
    Route::get('/', [CertificationController::class, 'index']);
    Route::post('/list', [CertificationController::class, 'list']);
    Route::get('/create', [CertificationController::class, 'create']);
    Route::post('/ajax', [CertificationController::class, 'store_ajax']);
    Route::get('/{id}/show_ajax', [CertificationController::class, 'show_ajax']);
    Route::get('/{id}/edit_ajax', [CertificationController::class, 'edit_ajax']);
    Route::put('/{id}/update_ajax', [CertificationController::class, 'update_ajax']);
    Route::get('/{id}/delete_ajax', [CertificationController::class, 'confirm_ajax']);
    Route::delete('/{id}/delete_ajax', [CertificationController::class, 'delete_ajax']);
    Route::post('/import_ajax', [CertificationController::class, 'import_ajax']);
    Route::get('/export_excel', [CertificationController::class, 'export_excel']);
    Route::get('/export_pdf', [CertificationController::class, 'export_pdf']);
});

// Route Vendor Sertifikasi
Route::group(['prefix' => 'certificationVendor'], function() {
    Route::get('/', [VendorCertification::class, 'index']);
    Route::post('/list', [VendorCertification::class, 'list']);
    Route::get('/create_ajax', [VendorCertification::class, 'create_ajax']);
    Route::post('/ajax', [VendorCertification::class, 'store_ajax']);
    Route::get('/{id}/show_ajax', [VendorCertification::class, 'show_ajax']);
    Route::get('/{id}/edit_ajax', [VendorCertification::class, 'edit_ajax']);
    Route::put('/{id}/update_ajax', [VendorCertification::class, 'update_ajax']);
    Route::get('/{id}/delete_ajax', [VendorCertification::class, 'confirm_ajax']);
    Route::delete('/{id}/delete_ajax', [VendorCertification::class, 'delete_ajax']);
    Route::post('/import_ajax', [VendorCertification::class, 'import_ajax']);
    Route::get('/export_excel', [VendorCertification::class, 'export_excel']);
    Route::get('/export_pdf', [VendorCertification::class, 'export_pdf']);
});

// Route Jenis Sertifikasi
Route::group(['prefix' => 'certificationType'], function() {
    Route::get('/', [TypeCertification::class, 'index']);
    Route::post('/list', [TypeCertification::class, 'list']);
    Route::get('/create_ajax', [TypeCertification::class, 'create_ajax']);
    Route::post('/ajax', [TypeCertification::class, 'store_ajax']);
    Route::get('/{id}/show_ajax', [TypeCertification::class, 'show_ajax']);
    Route::get('/{id}/edit_ajax', [TypeCertification::class, 'edit_ajax']);
    Route::put('/{id}/update_ajax', [TypeCertification::class, 'update_ajax']);
    Route::get('/{id}/delete_ajax', [TypeCertification::class, 'confirm_ajax']);
    Route::delete('/{id}/delete_ajax', [TypeCertification::class, 'delete_ajax']);
    Route::post('/import_ajax', [TypeCertification::class, 'import_ajax']);
    Route::get('/export_excel', [TypeCertification::class, 'export_excel']);
    Route::get('/export_pdf', [TypeCertification::class, 'export_pdf']);
});

// Route Data Pelatihan
Route::group(['prefix' => 'training'], function() {
    Route::get('/', [TrainingController::class, 'index']);
    Route::post('/list', [TrainingController::class, 'list']);
    Route::get('/create_ajax', [TrainingController::class, 'create_ajax']);
    Route::post('/ajax', [TrainingController::class, 'store_ajax']);
    Route::get('/{id}/show_ajax', [TrainingController::class, 'show_ajax']);
    Route::get('/{id}/edit_ajax', [TrainingController::class, 'edit_ajax']);
    Route::put('/{id}/update_ajax', [TrainingController::class, 'update_ajax']);
    Route::get('/{id}/delete_ajax', [TrainingController::class, 'confirm_ajax']);
    Route::delete('/{id}/delete_ajax', [TrainingController::class, 'delete_ajax']);
    Route::post('/import_ajax', [TrainingController::class, 'import_ajax']);
    Route::get('/export_excel', [TrainingController::class, 'export_excel']);
    Route::get('/export_pdf', [TrainingController::class, 'export_pdf']);
});
// Route Vendor Pelatihan
Route::group(['prefix' => 'trainingVendor'], function(){
    Route::get('/', [VendorTraining::class, 'index']);
    Route::post('/list', [VendorTraining::class, 'list']);
    Route::get('/create_ajax', [VendorTraining::class, 'create_ajax']);
    Route::post('/ajax', [VendorTraining::class, 'store_ajax']);
    Route::get('/{id}/show_ajax', [VendorTraining::class, 'show_ajax']);
    Route::get('/{id}/edit_ajax', [VendorTraining::class, 'edit_ajax']);
    Route::put('/{id}/update_ajax', [VendorTraining::class, 'update_ajax']);
    Route::get('/{id}/delete_ajax', [VendorTraining::class, 'confirm_ajax']);
    Route::delete('/{id}/delete_ajax', [VendorTraining::class, 'delete_ajax']);
    Route::post('/import_ajax', [VendorTraining::class, 'import_ajax']);
    Route::get('/export_excel', [VendorTraining::class, 'export_excel']);
    Route::get('/export_pdf', [VendorTraining::class, 'export_pdf']);
});

// Route Jenis Pelatihan
Route::group(['prefix' => 'trainingType'], function() {
    Route::get('/', [TypeTraining::class, 'index']);
    Route::post('/list', [TypeTraining::class, 'list']);
    Route::get('/create_ajax', [TypeTraining::class, 'create_ajax']);
    Route::post('/ajax', [TypeTraining::class, 'store_ajax']);
    Route::get('/{id}/show_ajax', [TypeTraining::class, 'show_ajax']);
    Route::get('/{id}/edit_ajax', [TypeTraining::class, 'edit_ajax']);
    Route::put('/{id}/update_ajax', [TypeTraining::class, 'update_ajax']);
    Route::get('/{id}/delete_ajax', [TypeTraining::class, 'confirm_ajax']);
    Route::delete('/{id}/delete_ajax', [TypeTraining::class, 'delete_ajax']);
    Route::post('/import_ajax', [TypeTraining::class, 'import_ajax']);
    Route::get('/export_excel', [TypeTraining::class, 'export_excel']);
    Route::get('/export_pdf', [TypeTraining::class, 'export_pdf']);
});

// Route Bidang Minat
Route::group(['prefix' => 'interest'], function() {
    Route::get('/', [InterestController::class, 'index']);
    Route::post('/list', [InterestController::class, 'list']);
    Route::get('/create_ajax', [InterestController::class, 'create_ajax']);
    Route::post('/ajax', [InterestController::class, 'store_ajax']);
    Route::get('/{id}/show_ajax', [InterestController::class, 'show_ajax']);
    Route::get('/{id}/edit_ajax', [InterestController::class, 'edit_ajax']);
    Route::put('/{id}/update_ajax', [InterestController::class, 'update_ajax']);
    Route::get('/{id}/delete_ajax', [InterestController::class, 'confirm_ajax']);
    Route::delete('/{id}/delete_ajax', [InterestController::class, 'delete_ajax']);
    Route::post('/import_ajax', [InterestController::class, 'import_ajax']);
    Route::get('/export_excel', [InterestController::class, 'export_excel']);
    Route::get('/export_pdf', [InterestController::class, 'export_pdf']);
});

// Route Mata Kuliah
Route::group(['prefix' => 'course'], function() {
    Route::get('/', [CourseController::class, 'index']);
    Route::post('/list', [CourseController::class, 'list']);
    Route::get('/create_ajax', [CourseController::class, 'create_ajax']);
    Route::post('/ajax', [CourseController::class, 'store_ajax']);
    Route::get('/{id}/show_ajax', [CourseController::class, 'show_ajax']);
    Route::get('/{id}/edit_ajax', [CourseController::class, 'edit_ajax']);
    Route::put('/{id}/update_ajax', [CourseController::class, 'update_ajax']);
    Route::get('/{id}/delete_ajax', [CourseController::class, 'confirm_ajax']);
    Route::delete('/{id}/delete_ajax', [CourseController::class, 'delete_ajax']);
    Route::post('/import_ajax', [CourseController::class, 'import_ajax']);
    Route::get('/export_excel', [CourseController::class, 'export_excel']);
    Route::get('/export_pdf', [CourseController::class, 'export_pdf']);
});

// Route Permintaan Surat Tugas
// Route Profile

// Dosen
// Route Pengajuan Sertifikasi
// Route Riwayat Sertifikasi
// Route Pengajuan Pelatihan
// Route Status Pengajuan Pelatihan
// Route Riwayat Pelatihan
// Route Pengajuan Surat Tugas

// Pimpinan
// Route Statistik Dosen
// Route Pemetaan Sertifikasi Dosen
// Route Pemetaan Pelatihan Dosen
// Route Pemberian Tugas Pelatihan & Sertifikasi Dosen

