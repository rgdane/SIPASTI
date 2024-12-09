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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class TrainingController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Pengajuan Pelatihan',
            'list' => ['Home', 'Pengajuan Pelatihan']
        ];

        $page = (object) [
            'title' => 'Manajemen Pengajuan Pelatihan',
        ];

        $activeMenu = 'training';

        return view('admin.training.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }

    public function list()
    {
        $trainings = DB::select(
            "SELECT
                a.training_id,
                a.training_name,
                d.period_year,
                DATE_FORMAT(a.training_date, '%d-%m-%Y') as training_date,
                CASE
                    WHEN a.training_level = '0' THEN 'Nasional'
                        ELSE 'Internasional'
                END AS training_level,
                CASE
                    WHEN a.training_status = '0' THEN 'Pending'
                    WHEN a.training_status = '1' THEN 'Pengajuan'
                    WHEN a.training_status = '2' THEN 'Ditolak'
                    WHEN a.training_status = '3' THEN 'Disetujui'
                    WHEN a.training_status = '4' THEN 'Selesai'
                END AS training_status
            FROM
                m_training a
                INNER JOIN m_period d ON a.period_id = d.period_id
            WHERE
                a.training_status <> '0'
                ;"
        );
        return DataTables::of($trainings)
        // menambahkan kolom index / no urut (default training_name kolom: DT_RowIndex)
        ->addIndexColumn()
        ->addColumn('aksi', function ($trainings) { // menambahkan kolom aksi
            $btn = '<button onclick="modalAction(\''.url('/training/' . $trainings->training_id . '/show').'\')" class="btn btn-info btn-sm">Detail</button> '; 
            $btn .= '<button onclick="modalAction(\''.url('/training/' . $trainings->training_id . '/edit').'\')" class="btn btn-warning btn-sm">Edit</button> '; 
            $btn .= '<button onclick="modalAction(\''.url('/training/' . $trainings->training_id . '/delete').'\')"  class="btn btn-danger btn-sm">Hapus</button> ';
            return $btn;
        })
        ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
        ->make(true);
    }

    public function create_training(){
        $training_vendor = TrainingVendorModel::select('training_vendor_id', 'training_vendor_name')->get();
        $period = PeriodModel::select('period_id', 'period_year')->get();
        $course = CourseModel::select('course_id', 'course_name')->get();
        $interest = InterestModel::select('interest_id', 'interest_name')->get();
        return view('admin.training.create', [
            'training_vendor' => $training_vendor,
            'period' => $period,
            'course' => $course,
            'interest' => $interest
        ]);
    }

    public function create(){
        $training_vendor = TrainingVendorModel::select('training_vendor_id', 'training_vendor_name')->get();
        $period = PeriodModel::select('period_id', 'period_year')->get();
        $course = CourseModel::select('course_id', 'course_name')->get();
        $interest = InterestModel::select('interest_id', 'interest_name')->get();
        $user = UserModel::select('user_id', 'user_fullname')->get();
        return view('admin.training.create', [
            'training_vendor' => $training_vendor,
            'period' => $period,
            'course' => $course,
            'interest' => $interest,
            'user' => $user
        ]);
    }

    public function store(Request $request)
    {
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
            'training_status' => 'required|integer',
            'course_id' => 'required|array', // Pastikan input adalah array
            'course_id.*' => 'exists:m_course,course_id', // Validasi setiap elemen array
            'interest_id' => 'required|array', // Pastikan input adalah array
            'interest_id.*' => 'exists:m_interest,interest_id', // Validasi setiap elemen array
            'user_id' => 'required|array', // Pastikan input adalah array
            'user_id.*' => 'exists:m_user,user_id', // Validasi setiap elemen array
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
                'training_status' => $request->training_status,
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

            foreach ($request->user_id as $userId) {
                if ($userId) {
                    // Simpan ke database
                    TrainingMemberModel::create([
                        'user_id' => $userId,
                        'training_id' => TrainingModel::latest()->first()->training_id,
                    ]);
                }
            }

            return response()->json([
                'status' => true,
                'message' => 'Data Sertifikasi Berhasil Ditambahkan',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage(),
            ]);
        }
    }


    public function show(string $id)
    {
        $training = DB::selectOne(
            "SELECT
                a.training_id,
                a.training_name,
                d.period_year,
                a.training_date,
                a.training_hours,
                a.training_location,
                a.training_cost,
                a.training_quota,
                b.training_vendor_name,
                CASE
                    WHEN a.training_level = '0' THEN 'Nasional'
                        ELSE 'Internasional'
                END AS training_level,
                CASE
                    WHEN a.training_status = '0' THEN 'Pending'
                    WHEN a.training_status = '1' THEN 'Pengajuan'
                    WHEN a.training_status = '2' THEN 'Ditolak'
                    WHEN a.training_status = '3' THEN 'Disetujui'
                    WHEN a.training_status = '4' THEN 'Selesai'
                END AS training_status
            FROM
                m_training a
                INNER JOIN m_training_vendor b ON a.training_vendor_id = b.training_vendor_id
                INNER JOIN m_period d ON a.period_id = d.period_id
            WHERE
                a.training_id = :id", ['id' => $id]
        );

        $interest = DB::select(
            "SELECT
        b.`interest_name`
        FROM
        `t_interest_training` a
        INNER JOIN `m_interest` b ON a.`interest_id` = b.`interest_id`
        WHERE a.`training_id` = '$id';"
        );

        $course = DB::select(
            "SELECT
        b.`course_name`
        FROM
        `t_course_training` a
        INNER JOIN `m_course` b ON a.`course_id` = b.`course_id`
        WHERE a.`training_id` = '$id';"
        );
        // dd($training->training_id);
        // Kembalikan view dengan data
        return view('admin.training.show', [
            'training' => $training,
            'interest' => $interest,
            'course' => $course,
        ]);
    }

    public function show_member($id){
        $user = DB::select(
            "SELECT
        b.`user_fullname`
        FROM
        `t_training_member` a
        INNER JOIN `m_user` b ON a.`user_id` = b.`user_id`
        WHERE a.`training_id` = '$id';"
        );

        return DataTables::of($user)
            ->addIndexColumn() // Tambahkan kolom indeks
            ->make(true);      // Kembalikan data dalam format JSON
    }

    public function edit(string $id)
    {
        $training = DB::selectOne(
            "SELECT
                a.training_id,
                a.training_name,
                d.period_id,
                a.training_date,
                a.training_hours,
                a.training_location,
                a.training_cost,
                a.training_quota,
                a.training_vendor_id,
                b.training_vendor_name,
                a.training_level,
                a.training_status
            FROM
                m_training a
                INNER JOIN m_training_vendor b ON a.training_vendor_id = b.training_vendor_id
                INNER JOIN m_period d ON a.period_id = d.period_id
            WHERE
                a.training_id = :id", ['id' => $id]
        );
        
        $interestTraining = DB::select(
            "SELECT
                a.*,
                b.`interest_name`
            FROM
                `t_interest_training` a
            INNER JOIN `m_interest` b ON a.`interest_id` = b.`interest_id`
            WHERE a.`training_id` = '$id';"
        );

        $courseTraining = DB::select(
            "SELECT
                a.*,
                b.`course_name`
            FROM
                `t_course_training` a
            INNER JOIN `m_course` b ON a.`course_id` = b.`course_id`
            WHERE a.`training_id` = '$id';"
        );

        $trainingMember = collect(DB::select(
            "SELECT
                a.`user_id`
            FROM
                `t_training_member` a
                INNER JOIN `m_user` b ON a.`user_id` = b.`user_id`
                WHERE a.`training_id` = '$id';"
        ))->toArray();
        $training_vendor = TrainingVendorModel::select('training_vendor_id', 'training_vendor_name')->get();
        $period = PeriodModel::select('period_id', 'period_year')->get();
        $course = CourseModel::select('course_id', 'course_name')->get();
        $interest = InterestModel::select('interest_id', 'interest_name')->get();
        $user = UserModel::select('user_id', 'user_fullname')->get();
        // Mengembalikan view penguna dan level
        return view('admin.training.edit', [
            'training' => $training,
            'course' => $course,
            'interest' => $interest,
            'training_vendor' => $training_vendor,
            'user' => $user,
            'period' => $period,
            'courseTraining' => $courseTraining,
            'interestTraining' => $interestTraining,
            'trainingMember' => $trainingMember,
        ]);
    }


    public function update(Request $request, $id)
    {
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
            'training_status' => 'required|integer',
            'course_id' => 'required|array', // Pastikan input adalah array
            'course_id.*' => 'exists:m_course,course_id', // Validasi setiap elemen array
            'interest_id' => 'required|array', // Pastikan input adalah array
            'interest_id.*' => 'exists:m_interest,interest_id', // Validasi setiap elemen array
            'user_id' => 'required|array', // Pastikan input adalah array
            'user_id.*' => 'exists:m_user,user_id', // Validasi setiap elemen array
        ];
        $validator = Validator::make($request->all(), $rules);
        
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi Gagal. Harap periksa input Anda.',
                'msgField' => $validator->errors(),
            ]);
        }
        
        $check = TrainingModel::find($id);
        if ($check) {
            $check->training_name = $request->training_name;
            $check->period_id = $request->period_id;
            $check->training_date = $request->training_date;
            $check->training_hours = $request->training_hours;
            $check->training_location = $request->training_location;
            $check->training_cost = $request->training_cost;
            $check->training_vendor_id = $request->training_vendor_id;
            $check->training_level = $request->training_level;
            $check->training_quota = $request->training_quota;
            $check->training_status = $request->training_status;
            $check->save(); // Simpan perubahan ke database
            CourseTrainingModel::where('training_id', $id)->delete();
            interestTrainingModel::where('training_id', $id)->delete();
            TrainingMemberModel::where('training_id', $id)->delete();
            

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

            foreach ($request->user_id as $userId) {
                if ($userId) {
                    // Simpan ke database
                    TrainingMemberModel::create([
                        'user_id' => $userId,
                        'training_id' => TrainingModel::latest()->first()->training_id,
                    ]);
                }
            }
            return response()->json([
                'status' => true,
                'message' => 'Data Pelatihan Berhasil Diupdate',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ]);
        }
    }

    public function confirm(string $id)
    {
        $training = DB::selectOne(
            "SELECT
                a.training_id,
                a.training_name,
                d.period_year,
                a.training_date,
                a.training_hours,
                a.training_location,
                a.training_cost,
                a.training_quota,
                b.training_vendor_name,
                CASE
                    WHEN a.training_level = '0' THEN 'Nasional'
                        ELSE 'Internasional'
                END AS training_level,
                CASE
                    WHEN a.training_status = '0' THEN 'Pending'
                    WHEN a.training_status = '1' THEN 'Pengajuan'
                    WHEN a.training_status = '2' THEN 'Ditolak'
                    WHEN a.training_status = '3' THEN 'Disetujui'
                    WHEN a.training_status = '4' THEN 'Selesai'
                END AS training_status
            FROM
                m_training a
                INNER JOIN m_training_vendor b ON a.training_vendor_id = b.training_vendor_id
                INNER JOIN m_period d ON a.period_id = d.period_id
            WHERE
                a.training_id = :id", ['id' => $id]
        );

        $interest = DB::select(
            "SELECT
        b.`interest_name`
        FROM
        `t_interest_training` a
        INNER JOIN `m_interest` b ON a.`interest_id` = b.`interest_id`
        WHERE a.`training_id` = '$id';"
        );

        $course = DB::select(
            "SELECT
        b.`course_name`
        FROM
        `t_course_training` a
        INNER JOIN `m_course` b ON a.`course_id` = b.`course_id`
        WHERE a.`training_id` = '$id';"
        );
        // dd($training->training_id);
        // Kembalikan view dengan data
        return view('admin.training.confirm', [
            'training' => $training,
            'interest' => $interest,
            'course' => $course,
        ]);
    }

    public function delete(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $training = TrainingModel::find($id);
            if ($training) {
                $training->delete();
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil dihapus'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
            return redirect('/training');
        }
    }
}
