<?php

namespace App\Http\Controllers;

use App\Models\CertificationModel;
use App\Models\CertificationVendorModel;
use App\Models\CourseModel;
use App\Models\InterestModel;
use App\Models\PeriodModel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CertificationInputController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Input Sertifikasi',
            'list' => ['Home', 'Input Sertifikasi']
        ];

        $page = (object) [
            'title' => 'Input Sertifikasi'
        ];

        $userId = auth()->user()->user_id;
        $certification_vendor = CertificationVendorModel::all();
        $course = CourseModel::all();
        $interest = InterestModel::all();
        $periode = PeriodModel::all();
        $activeMenu = 'certification_input';

        return view(
            'lecturer.certification_input.index',
            [
                'breadcrumb' => $breadcrumb,
                'page' => $page,
                'activeMenu' => $activeMenu,
                'userId' => $userId,
                'certification_vendor' => $certification_vendor,
                'course' => $course,
                'interest' => $interest,
                'periode' => $periode
            ]
        );
    }

    public function store(Request $request)
    {
        // Ensure the user is authenticated
        if (!Auth::check()) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized access',
                'errors' => ['authentication' => ['User not authenticated']]
            ], 401);
        }

        $userId = Auth::user()->user_id;

        $rules = [
            'certification_name' => 'required|string|max:100',
            'certification_number' => 'required|string|max:100',
            'period_id' => 'required|string',
            'certification_date_start' => 'required|date|before_or_equal:certification_date_expired',
            'certification_date_expired' => 'required|date|after_or_equal:certification_date_start',
            'certification_vendor_id' => 'required|string',
            'certification_level' => 'required|integer',
            'certification_type' => 'required|integer',
            'certification_file' => 'required|mimes:pdf|max:2048',
            'course_id' => 'required|array', 
            'course_id.*' => 'exists:m_course,course_id', 
            'interest_id' => 'required|array', 
            'interest_id.*' => 'exists:m_interest,interest_id', 
        ];

        // Validasi input
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        // Generate a unique filename
        if (!$request->hasFile('certification_file')) {
            return response()->json([
                'status' => false,
                'message' => 'Certification file is required',
                'errors' => ['certification_file' => ['No file uploaded']]
            ], 400);
        }

        $file = $request->file('certification_file');

        // Create a unique filename with userId and timestamp
        $filename = $userId . '_certification_' . time() . '.' . $file->getClientOriginalExtension();

        // Store the file in a user-specific directory
        $filePath = $file->storeAs('uploads/certification/' . $userId, $filename, 'public');

        try {
            // Simpan data ke database
            $certification = CertificationModel::create([
                'certification_name' => $request->certification_name,
                'certification_number' => $request->certification_number,
                'period_id' => $request->period_id,
                'certification_date_start' => $request->certification_date_start,
                'certification_date_expired' => $request->certification_date_expired,
                'certification_vendor_id' => $request->certification_vendor_id,
                'certification_level' => $request->certification_level,
                'certification_type' => $request->certification_type,
                'certification_file' => $filePath,
                'course_id' => json_encode($request->course_id), // Store as JSON
                'interest_id' => json_encode($request->interest_id), // Store as JSON
                'user_id' => $userId, // Use authenticated user's ID
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Sertifikasi berhasil ditambahkan',
                'data' => [
                    'certification_id' => $certification->id,
                    'certification_name' => $certification->certification_name
                ]
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal menyimpan sertifikasi',
                'errors' => ['server' => [$e->getMessage()]]
            ], 500);
        }
    }
}