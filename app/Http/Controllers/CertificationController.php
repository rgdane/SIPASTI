<?php

namespace App\Http\Controllers;

use App\Models\CertificationModel;
use App\Models\CertificationVendorModel;
use App\Models\CourseCertificationModel;
use App\Models\CourseModel;
use App\Models\InterestCertificationModel;
use App\Models\InterestModel;
use App\Models\PeriodModel;
use App\Models\UserModel;
use Barryvdh\DomPDF\Facade\Pdf;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CertificationController extends Controller
{
    public function index(){
        $breadcrumb = (object)[
            'title' => 'Data Sertifikasi',
            'list' => ['Home', 'Data Sertifikasi']
        ];
    
        $page = (object)[
            'title' => 'Daftar sertifikasi yang terdaftar dalam sistem'
        ];
    
        $activeMenu = 'certification'; //set menu yang sedang aktif
    
        return view('admin.certification.index',['breadcrumb'=>$breadcrumb, 'page' => $page, 'activeMenu'=>$activeMenu]);
    }
    
    // Ambil data certification dalam bentuk json untuk datatables
    public function list()
    {
        $certifications = DB::select(
            "SELECT
                a.certification_id,
                a.certification_name,
                a.certification_number,
                d.period_year,
                CASE
                    WHEN a.certification_level = '0' THEN 'Nasional'
                        ELSE 'Internasional'
                END AS certification_level,
                CASE
                    WHEN a.certification_type = '0' THEN 'Profesi'
                        ELSE 'Keahlian'
                END AS certification_type,
                c.user_fullname
            FROM
                m_certification a
                INNER JOIN m_certification_vendor b ON a.certification_vendor_id = b.certification_vendor_id
                INNER JOIN m_user c ON a.user_id = c.user_id
                INNER JOIN m_period d ON a.period_id = d.period_id;"
        );
        return DataTables::of($certifications)
        // menambahkan kolom index / no urut (default certification_name kolom: DT_RowIndex)
        ->addIndexColumn()
        ->addColumn('aksi', function ($certifications) { // menambahkan kolom aksi
            $btn = '<button onclick="modalAction(\''.url('/certification/' . $certifications->certification_id . '/show').'\')" class="btn btn-info btn-sm">Detail</button> '; 
            $btn .= '<button onclick="modalAction(\''.url('/certification/' . $certifications->certification_id . '/edit').'\')" class="btn btn-warning btn-sm">Edit</button> '; 
            $btn .= '<button onclick="modalAction(\''.url('/certification/' . $certifications->certification_id . '/delete').'\')"  class="btn btn-danger btn-sm">Hapus</button> ';
            return $btn;
        })
        ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
        ->make(true);
    }

    public function create()
    {
        $certification_vendor = CertificationVendorModel::select('certification_vendor_id', 'certification_vendor_name')->get();
        $period = PeriodModel::select('period_id', 'period_year')->get();
        $user = UserModel::select('user_id','user_fullname')->get();
        $course = CourseModel::select('course_id', 'course_name')->get();
        $interest = InterestModel::select('interest_id', 'interest_name')->get();
        return view('admin.certification.create', [
            'certification_vendor' => $certification_vendor,
            'user' => $user,
            'period' => $period,
            'course' => $course,
            'interest' => $interest
        ]);
    }

    public function file(String $id)
    {
        try {
            $certification = CertificationModel::find($id);

            if (!$certification) {
                return response()->json(['error' => 'Certification not found'], 404);
            }

            // Bangun path absolut
            $absolutePath = 'storage/'.$certification->certification_file;

            // Cek apakah file ada
            if (!file_exists($absolutePath)) {
                return response()->json(['error' => 'File not found'], 404);
            }

            // Header untuk file PDF
            header('Content-Type: application/pdf');
            header('Content-Disposition: inline; filename="' . basename($absolutePath) . '"');
            header('Content-Length: ' . filesize($absolutePath));

            // Baca dan kirim file
            readfile($absolutePath);
            exit; // Pastikan tidak ada output lain

        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
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
            // Proses penyimpanan file
            $file = $request->file('certification_file');
            $fileName = time() . '_' . $file->getClientOriginalName(); // Gunakan nama unik
            $filePath = $file->storeAs('uploads/certification', $fileName, 'public');

            // Simpan data ke database
            CertificationModel::create([
                'certification_name' => $request->certification_name,
                'certification_number' => $request->certification_number,
                'period_id' => $request->period_id,
                'certification_date_start' => $request->certification_date_start,
                'certification_date_expired' => $request->certification_date_expired,
                'certification_vendor_id' => $request->certification_vendor_id,
                'certification_level' => $request->certification_level,
                'certification_type' => $request->certification_type,
                'certification_file' => $filePath,
                'user_id' => $request->user_id,
            ]);

            foreach ($request->course_id as $courseId) {
                // Simpan ke database
                CourseCertificationModel::create([
                    'course_id' => $courseId,
                    'certification_id' => CertificationModel::latest()->first()->certification_id,
                ]);
            }

            foreach ($request->interest_id as $interestId) {
                // Simpan ke database
                InterestCertificationModel::create([
                    'interest_id' => $interestId,
                    'certification_id' => CertificationModel::latest()->first()->certification_id,
                ]);
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
        $certification = DB::selectOne(
            "SELECT
                a.certification_id,
                a.certification_name,
                a.certification_number,
                d.period_year,
                a.certification_date_start,
                a.certification_date_expired,
                b.certification_vendor_name,
                a.certification_file,
                CASE
                    WHEN certification_level = '0' THEN 'Nasional'
                    ELSE 'Internasional'
                END AS certification_level,
                CASE
                    WHEN certification_type = '0' THEN 'Profesi'
                    ELSE 'Keahlian'
                END AS certification_type,
                c.user_fullname
            FROM
                m_certification a
                INNER JOIN m_certification_vendor b ON a.certification_vendor_id = b.certification_vendor_id
                INNER JOIN m_user c ON a.user_id = c.user_id
                INNER JOIN m_period d ON a.period_id = d.period_id
            WHERE
                a.certification_id = :id", ['id' => $id]
        );

        $interest = DB::select(
            "SELECT
        b.`interest_name`
        FROM
        `t_interest_certification` a
        INNER JOIN `m_interest` b ON a.`interest_id` = b.`interest_id`
        WHERE a.`certification_id` = '$id';"
        );

        $course = DB::select(
            "SELECT
        b.`course_name`
        FROM
        `t_course_certification` a
        INNER JOIN `m_course` b ON a.`course_id` = b.`course_id`
        WHERE a.`certification_id` = '$id';"
        );
        // Kembalikan view dengan data
        return view('admin.certification.show', ['certification' => $certification, 'interest' => $interest, 'course' => $course]);
    }


    public function edit(string $id)
    {
        $certification = DB::selectOne(
            "SELECT
                a.certification_id,
                a.certification_name,
                a.certification_number,
                a.period_id,
                d.period_year,
                a.certification_date_start,
                a.certification_date_expired,
                a.certification_vendor_id,
                b.certification_vendor_name,
                a.certification_file,
                CASE
                    WHEN certification_level = '0' THEN 'Nasional'
                    ELSE 'Internasional'
                END AS certification_level,
                CASE
                    WHEN certification_type = '0' THEN 'Profesi'
                    ELSE 'Keahlian'
                END AS certification_type,
                a.user_id,
                c.user_fullname
            FROM
                m_certification a
                INNER JOIN m_certification_vendor b ON a.certification_vendor_id = b.certification_vendor_id
                INNER JOIN m_user c ON a.user_id = c.user_id
                INNER JOIN m_period d ON a.period_id = d.period_id
            WHERE
                a.certification_id = :id", ['id' => $id]
        );

        $interestCertification = DB::select(
            "SELECT
                a.*,
                b.`interest_name`
            FROM
                `t_interest_certification` a
            INNER JOIN `m_interest` b ON a.`interest_id` = b.`interest_id`
            WHERE a.`certification_id` = '$id';"
        );

        $courseCertification = DB::select(
            "SELECT
                a.*,
                b.`course_name`
            FROM
                `t_course_certification` a
            INNER JOIN `m_course` b ON a.`course_id` = b.`course_id`
            WHERE a.`certification_id` = '$id';"
        );

        $certification_vendor = CertificationVendorModel::select('certification_vendor_id', 'certification_vendor_name')->get();
        $period = PeriodModel::select('period_id', 'period_year')->get();
        $user = UserModel::select('user_id','user_fullname')->get();
        $course = CourseModel::select('course_id', 'course_name')->get();
        $interest = InterestModel::select('interest_id', 'interest_name')->get();
        
        // Mengembalikan view penguna dan level
        return view('admin.certification.edit', [
            'certification' => $certification,
            'course' => $course,
            'interest' => $interest,
            'certification_vendor' => $certification_vendor,
            'user' => $user,
            'period' => $period,
            'courseCertification' => $courseCertification,
            'interestCertification' => $interestCertification,
        ]);
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'certification_name' => 'required|string|max:100',
            'certification_number' => 'required|string|max:100',
            'period_id' => 'required|string',
            'certification_date_start' => 'required|date|before_or_equal:certification_date_expired',
            'certification_date_expired' => 'required|date|after_or_equal:certification_date_start',
            'certification_vendor_id' => 'required|string',
            'certification_level' => 'required|integer',
            'certification_type' => 'required|integer',
            'certification_file' => 'nullable|mimes:pdf|max:2048',
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

        $check = CertificationModel::find($id);
        if ($check) {
            if ($request->hasFile('certification_file')) {
                // Proses penyimpanan file
                $file = $request->file('certification_file');
                $fileName = time() . '_' . $file->getClientOriginalName(); // Gunakan nama unik
                $filePath = $file->storeAs('uploads/certification', $fileName, 'public');

                $check->certification_file = $filePath;
                $check->save();
            }
            
            CourseCertificationModel::where('certification_id', $id)->delete();
            InterestCertificationModel::where('certification_id', $id)->delete();

            $check->update($request->except('certification_file'));
            
            foreach ($request->course_id as $courseId) {
                // Simpan ke database
                CourseCertificationModel::create([
                    'course_id' => $courseId,
                    'certification_id' => $id,
                ]);
            }

            foreach ($request->interest_id as $interestId) {
                // Simpan ke database
                InterestCertificationModel::create([
                    'interest_id' => $interestId,
                    'certification_id' => $id,
                ]);
            }
            return response()->json([
                'status' => true,
                'message' => 'Data berhasil diupdate'
            ]);
        } else{
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ]);
        }
    }

    public function confirm(string $id)
    {
        $certification = DB::selectOne(
            "SELECT
                a.certification_id,
                a.certification_name,
                a.certification_number,
                d.period_year,
                a.certification_date_start,
                a.certification_date_expired,
                b.certification_vendor_name,
                a.certification_file,
                CASE
                    WHEN certification_level = '0' THEN 'Nasional'
                    ELSE 'Internasional'
                END AS certification_level,
                CASE
                    WHEN certification_type = '0' THEN 'Profesi'
                    ELSE 'Keahlian'
                END AS certification_type,
                c.user_fullname
            FROM
                m_certification a
                INNER JOIN m_certification_vendor b ON a.certification_vendor_id = b.certification_vendor_id
                INNER JOIN m_user c ON a.user_id = c.user_id
                INNER JOIN m_period d ON a.period_id = d.period_id
            WHERE
                a.certification_id = :id", ['id' => $id]
        );

        $interest = DB::select(
            "SELECT
        b.`interest_name`
        FROM
        `t_interest_certification` a
        INNER JOIN `m_interest` b ON a.`interest_id` = b.`interest_id`
        WHERE a.`certification_id` = '$id';"
        );

        $course = DB::select(
            "SELECT
        b.`course_name`
        FROM
        `t_course_certification` a
        INNER JOIN `m_course` b ON a.`course_id` = b.`course_id`
        WHERE a.`certification_id` = '$id';"
        );
        // dd($certification);
        // Mengembalikan view penguna dan level
        return view('admin.certification.confirm', ['certification' => $certification, 'interest' => $interest, 'course' => $course]);
    }

    public function delete(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $certification = CertificationModel::find($id);
            if ($certification) {
                $certification->delete();
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
            return redirect('/certification');
        }
    }
}
