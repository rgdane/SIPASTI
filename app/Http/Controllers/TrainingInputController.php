<?php

namespace App\Http\Controllers;

use App\Models\CourseModel;
use App\Models\CourseTrainingModel;
use App\Models\InterestModel;
use App\Models\InterestTrainingModel;
use App\Models\PeriodModel;
use App\Models\TrainingMemberModel;
use App\Models\TrainingModel;
use App\Models\TrainingVendorModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TrainingInputController extends Controller
{
    public function index() {
        $breadcrumb = (object) [
            'title' => 'Input Pelatihan',
            'list' => ['Home', 'Input Pelatihan']
        ];

        $page = (object) [
            'title' => 'Input Pelatihan',
        ];

        $userId = auth()->user()->user_id;
        $training_vendor = TrainingVendorModel::all();
        $course = CourseModel::all();
        $interest = InterestModel::all();
        $periode = PeriodModel::all();
        $user = UserModel::all();
        $activeMenu = 'training_input';
        
        return view(
            'lecturer.training_input.index',
            [
                'breadcrumb' => $breadcrumb,
                'page' => $page,
                'activeMenu' => $activeMenu,
                'userId' => $userId,
                'training_vendor' => $training_vendor,
                'course' => $course,
                'interest' => $interest,
                'periode' => $periode,
                'user' => $user
            ]
        );
    }

    public function store(Request $request)
    {
        if (!Auth::check()) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized access',
                'errors' => ['authentication' => ['User not authenticated']]
            ], 401);
        }

        $userId = Auth::user()->user_id;

        $rules = [
            'training_name' => 'required|string|max:100',
            'period_id' => 'required|string',
            'training_date' => 'required|date',
            'training_hours' => 'required|integer',
            'training_location' => 'required|string',
            'training_cost' => 'required|integer',
            'training_vendor_id' => 'required|string',
            'training_level' => 'required|integer',
            'training_quota' => 'required|integer',
            'course_id' => 'required|array', // Pastikan input adalah array
            'course_id.*' => 'exists:m_course,course_id', // Validasi setiap elemen array
            'interest_id' => 'required|array', // Pastikan input adalah array
            'interest_id.*' => 'exists:m_interest,interest_id', // Validasi setiap elemen array
        ];

        $validator = Validator::make($request->all(), $rules);
        
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi Gagal. Harap periksa input Anda.',
                'msgField' => $validator->errors(),
            ]);
        }

        try {
            // Simpan data ke database
            TrainingModel::create([
                'training_name' => $request->training_name,
                'period_id' => $request->period_id,
                'training_date' => $request->training_date,
                'training_hours' => $request->training_hours,
                'training_location' => $request->training_location,
                'training_cost' => $request->training_cost,
                'training_vendor_id' => $request->training_vendor_id,
                'training_level' => $request->training_level,
                'training_quota' => $request->training_quota,
            ]);

            foreach ($request->course_id as $courseId) {
                // Simpan ke database
                CourseTrainingModel::create([
                    'course_id' => $courseId,
                    'training_id' => TrainingModel::latest()->first()->training_id,
                ]);
            }

            foreach ($request->interest_id as $interestId) {
                // Simpan ke database
                InterestTrainingModel::create([
                    'interest_id' => $interestId,
                    'training_id' => TrainingModel::latest()->first()->training_id,
                ]);
            }

            return response()->json([
                'status' => true,
                'message' => 'Data Pelatihan Berhasil Ditambahkan',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage(),
            ]);
        }
    }
}
