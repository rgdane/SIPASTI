<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CertificationController;
use App\Http\Controllers\CertificationHistoryController;
use App\Http\Controllers\CertificationHeadController;
use App\Http\Controllers\CertificationInputController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\InterestController;
use App\Http\Controllers\TrainingController;
use App\Http\Controllers\EnvelopeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserTypeController;
use App\Http\Controllers\CertificationVendorController;
use App\Http\Controllers\CertificationVendorHeadController;
use App\Http\Controllers\PeriodController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StatisticController;
use App\Http\Controllers\TrainingApprovalController;
use App\Http\Controllers\TrainingHistoryController;
use App\Http\Controllers\TrainingInputController;
use App\Http\Controllers\TrainingVendorController;
use App\Http\Controllers\TrainingVendorHeadController;
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

Route::get('login', [AuthController:: class,'login'])->name('login');
Route::post('login', [AuthController:: class,'postlogin']);
Route::get('logout', [AuthController:: class,'logout'])->middleware ('auth');

Route::middleware (['auth'])->group(function(){ // artinya semua route di dalam group ini harus login dulu

    Route::get('/', [WelcomeController::class, 'index'])->name('welcome');
    Route::get('/training/{id}', [WelcomeController::class, 'show'])->name('training.show');
    Route::get('/training-details/{id}', [WelcomeController::class, 'getTrainingDetails'])->name('training.details');
    
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/profile/update', [ProfileController::class, 'update']);
    Route::put('/profile/update_password', [ProfileController::class, 'update_password']);
    Route::put('/profile/update_image', [ProfileController::class, 'update_image']);
    
    Route::middleware(['authorize:ADM'])->group(function(){
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
        });
        
        // Route Data Sertifikasi
        Route::group(['prefix' => 'certification'], function() {
            Route::get('/', [CertificationController::class, 'index']);
            Route::post('/list', [CertificationController::class, 'list']);
            Route::get('/create', [CertificationController::class, 'create']);
            Route::post('/store', [CertificationController::class, 'store']);
            Route::get('/{id}/course', [CertificationController::class, 'course']);
            Route::get('/{id}/interest', [CertificationController::class, 'interest']);
            Route::get('/{id}/file', [CertificationController::class, 'file']);
            Route::get('/{id}/show', [CertificationController::class, 'show']);
            Route::get('/{id}/edit', [CertificationController::class, 'edit']);
            Route::put('/{id}/update', [CertificationController::class, 'update']);
            Route::get('/{id}/delete', [CertificationController::class, 'confirm']);
            Route::delete('/{id}/delete', [CertificationController::class, 'delete']);
            Route::post('/import', [CertificationController::class, 'import']);
            Route::get('/export_excel', [CertificationController::class, 'export_excel']);
            Route::get('/export_pdf', [CertificationController::class, 'export_pdf']);
        });
        
        // Route Vendor Sertifikasi
        Route::group(['prefix' => 'certification_vendor'], function() {
            Route::get('/', [CertificationVendorController::class, 'index']);
            Route::post('/list', [CertificationVendorController::class, 'list']);
            Route::get('/create', [CertificationVendorController::class, 'create']);
            Route::post('/store', [CertificationVendorController::class, 'store']);
            Route::get('/{id}/show', [CertificationVendorController::class, 'show']);
            Route::get('/{id}/edit', [CertificationVendorController::class, 'edit']);
            Route::put('/{id}/update', [CertificationVendorController::class, 'update']);
            Route::get('/{id}/delete', [CertificationVendorController::class, 'confirm']);
            Route::delete('/{id}/delete', [CertificationVendorController::class, 'delete']);
            Route::get('/import', [CertificationVendorController::class, 'import']);
            Route::post('/import_excel', [CertificationVendorController::class, 'import_excel']);
            Route::get('/export_excel', [CertificationVendorController::class, 'export_excel']);
            Route::get('/export_pdf', [CertificationVendorController::class, 'export_pdf']);
        });

        Route::group(['prefix' => 'training'], function() {
            Route::get('/', [TrainingController::class, 'index']);
            Route::post('/list', [TrainingController::class, 'list']);
            Route::get('/create/true', [TrainingController::class, 'create']);
            Route::get('/create', [TrainingController::class, 'create']);
            Route::post('/store', [TrainingController::class, 'store']);
            Route::get('/{id}/course', [TrainingController::class, 'course']);
            Route::get('/{id}/interest', [TrainingController::class, 'interest']);
            Route::get('/{id}/file', [TrainingController::class, 'file']);
            Route::get('/{id}/show', [TrainingController::class, 'show']);
            Route::post('/{id}/show_member', [TrainingController::class, 'show_member']);
            Route::get('/{id}/edit', [TrainingController::class, 'edit']);
            Route::put('/{id}/update', [TrainingController::class, 'update']);
            Route::get('/{id}/delete', [TrainingController::class, 'confirm']);
            Route::delete('/{id}/delete', [TrainingController::class, 'delete']);
            Route::post('/import', [TrainingController::class, 'import']);
            Route::get('/export_excel', [TrainingController::class, 'export_excel']);
            Route::get('/export_pdf', [TrainingController::class, 'export_pdf']);
        });
        
        // Route Vendor Pelatihan
        Route::group(['prefix' => 'training_vendor'], function(){
            Route::get('/', [TrainingVendorController::class, 'index']);
            Route::post('/list', [TrainingVendorController::class, 'list']);
            Route::get('/create', [TrainingVendorController::class, 'create']);
            Route::post('/store', [TrainingVendorController::class, 'store']);
            Route::get('/{id}/show', [TrainingVendorController::class, 'show']);
            Route::get('/{id}/edit', [TrainingVendorController::class, 'edit']);
            Route::put('/{id}/update', [TrainingVendorController::class, 'update']);
            Route::get('/{id}/delete', [TrainingVendorController::class, 'confirm']);
            Route::delete('/{id}/delete', [TrainingVendorController::class, 'delete']);
            Route::get('/import', [TrainingVendorController::class, 'import']);
            Route::post('/import_excel', [TrainingVendorController::class, 'import_excel']);
            Route::get('/export_excel', [TrainingVendorController::class, 'export_excel']);
            Route::get('/export_pdf', [TrainingVendorController::class, 'export_pdf']);
        });

        // Route Bidang Minat
        Route::group(['prefix' => 'interest'], function() {
            Route::get('/', [InterestController::class, 'index']);
            Route::post('/list', [InterestController::class, 'list']);
            Route::get('/create', [InterestController::class, 'create']);
            Route::post('/store', [InterestController::class, 'store']);
            Route::get('/{id}/show', [InterestController::class, 'show']);
            Route::get('/{id}/edit', [InterestController::class, 'edit']);
            Route::put('/{id}/update', [InterestController::class, 'update']);
            Route::get('/{id}/delete', [InterestController::class, 'confirm']);
            Route::delete('/{id}/delete', [InterestController::class, 'delete']);
            Route::get('/import', [InterestController::class, 'import']);
            Route::post('/import_excel', [InterestController::class, 'import_excel']);
            Route::get('/export_excel', [InterestController::class, 'export_excel']);
            Route::get('/export_pdf', [InterestController::class, 'export_pdf']);
        });
    
        // Route Mata Kuliah
        Route::group(['prefix' => 'course'], function() {
            Route::get('/', [CourseController::class, 'index']);
            Route::post('/list', [CourseController::class, 'list']);
            Route::get('/create', [CourseController::class, 'create']);
            Route::post('/store', [CourseController::class, 'store']);
            Route::get('/{id}/show', [CourseController::class, 'show']);
            Route::get('/{id}/edit', [CourseController::class, 'edit']);
            Route::put('/{id}/update', [CourseController::class, 'update']);
            Route::get('/{id}/delete', [CourseController::class, 'confirm']);
            Route::delete('/{id}/delete', [CourseController::class, 'delete']);
            Route::get('/import', [CourseController::class, 'import']);
            Route::post('/import_excel', [CourseController::class, 'import_excel']);
            Route::get('/export_excel', [CourseController::class, 'export_excel']);
            Route::get('/export_pdf', [CourseController::class, 'export_pdf']);
        });

        // Route Tahun Periode
        Route::group(['prefix' => 'period'], function() {
            Route::get('/', [PeriodController::class, 'index']);
            Route::post('/list', [PeriodController::class, 'list']);
            Route::get('/create', [PeriodController::class, 'create']);
            Route::post('/store', [PeriodController::class, 'store']);
            Route::get('/{id}/show', [PeriodController::class, 'show']);
            Route::get('/{id}/edit', [PeriodController::class, 'edit']);
            Route::put('/{id}/update', [PeriodController::class, 'update']);
            Route::get('/{id}/delete', [PeriodController::class, 'confirm']);
            Route::delete('/{id}/delete', [PeriodController::class, 'delete']);
        });
    }); //middleware admin
    
    Route::middleware(['authorize:DSN,TDK'])->group(function(){
        // Route Input Sertifikasi
        Route::group(['prefix' => 'certification_input'], function() {
            Route::get('/', [CertificationInputController::class, 'index']);
            Route::post('/{id}/store', [CertificationInputController::class, 'store']);
        });

        // Route Riwayat Sertifikasi
        Route::group(['prefix' => 'certification_history'], function() {
            Route::get('/', [CertificationHistoryController::class, 'index'])->name('certification.history');
            Route::get('/list', [CertificationHistoryController::class, 'list']);
            Route::get('/{id}/show', [CertificationHistoryController::class, 'show']);
        });

        // Route Input Pelatihan
        Route::group(['prefix' => 'training_input'], function() {
            Route::get('/', [TrainingInputController::class, 'index']);
            Route::post('/{id}/store', [TrainingInputController::class, 'store']);
        });

        //Route Riwayat Pelatihan
        Route::group(['prefix' => 'training_history'], function() {
            Route::get('/', [TrainingHistoryController::class, 'index']);
            Route::post('/list', [TrainingHistoryController::class, 'list']);
            Route::get('/{id}/show', [TrainingHistoryController::class, 'show']);
        });
    });

    Route::middleware(['authorize:PMP'])->group(function(){
        Route::group(['prefix' => 'training_approval'], function() {
            Route::get('/', [TrainingApprovalController::class, 'index']);
            Route::get('/{id}/show', [TrainingApprovalController::class, 'show']);
            Route::post('/{id}/show_member', [TrainingApprovalController::class, 'show_member']);
            Route::post('/list', [TrainingApprovalController::class, 'list']);
            Route::put('/{id}/approve', [TrainingApprovalController::class, 'approve']);
            Route::put('/{id}/reject', [TrainingApprovalController::class, 'reject']);
        });

        // Route Vendor Pelatihan
        Route::group(['prefix' => 'training_vendor_head'], function(){
            Route::get('/', [TrainingVendorHeadController::class, 'index']);
            Route::post('/list', [TrainingVendorHeadController::class, 'list']);
            Route::get('/{id}/show', [TrainingVendorHeadController::class, 'show']);
            Route::get('/export_excel', [TrainingVendorHeadController::class, 'export_excel']);
            Route::get('/export_pdf', [TrainingVendorHeadController::class, 'export_pdf']);
        });
        
        Route::group(['prefix' => 'certification_vendor_head'], function(){
            Route::get('/', [CertificationVendorHeadController::class, 'index']);
            Route::post('/list', [CertificationVendorHeadController::class, 'list']);
            Route::get('/{id}/show', [CertificationVendorHeadController::class, 'show']);
            Route::get('/export_excel', [CertificationVendorHeadController::class, 'export_excel']);
            Route::get('/export_pdf', [CertificationVendorHeadController::class, 'export_pdf']);
        });
        
        Route::group(['prefix' => 'certification_head'], function(){
            Route::get('/', [CertificationHeadController::class, 'index']);
            Route::post('/list', [CertificationHeadController::class, 'list']);
            Route::get('/{id}/show', [CertificationHeadController::class, 'show']);
            Route::get('/{id}/file', [CertificationHeadController::class, 'file']);
        });
    });
    
    Route::middleware(['authorize:ADM,PMP'])->group(function(){
        // Route Statistik Dosen
        Route::group(['prefix' => 'statistic'], function() {
            Route::get('/', [StatisticController::class, 'index']);
            Route::post('/list', [StatisticController::class, 'list']);
        });
    });
    // Route Permintaan Surat Tugas
    Route::group(['prefix' => 'envelope'], function() {
        Route::get('/', [EnvelopeController::class, 'index']);
        Route::post('/list', [EnvelopeController::class, 'list']);
        Route::get('/create', [EnvelopeController::class, 'create']);
        Route::post('/ajax', [EnvelopeController::class, 'store']);
        Route::get('/{id}/show', [EnvelopeController::class, 'show']);
        Route::get('/{id}/edit', [EnvelopeController::class, 'edit']);
        Route::put('/{id}/update', [EnvelopeController::class, 'update']);
        Route::get('/{id}/delete', [EnvelopeController::class, 'confirm']);
        Route::delete('/{id}/delete', [EnvelopeController::class, 'delete']);
        Route::post('/import', [EnvelopeController::class, 'import']);
        Route::get('/export_excel', [EnvelopeController::class, 'export_excel']);
        Route::get('/export_pdf', [EnvelopeController::class, 'export_pdf']);
    });
    
    
    
    // Route Status Pengajuan Pelatihan
    // Route Riwayat Pelatihan
    // Route Pengajuan Surat Tugas
    
    // Pimpinan
    // Route Statistik Dosen
    // Route Pemetaan Sertifikasi Dosen
    // Route Pemetaan Pelatihan Dosen
    // Route Pemberian Tugas Pelatihan & Sertifikasi Dosen
    
    // Route Jenis Sertifikasi

});