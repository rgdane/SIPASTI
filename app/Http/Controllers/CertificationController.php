<?php

namespace App\Http\Controllers;

use App\Models\CertificationModel;
use App\Models\CertificationVendorModel;
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
                a.certification_period,
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
                INNER JOIN m_user c ON a.user_id = c.user_id;"
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

    public function course(string $id){
        $course = DB::select(
            "SELECT
        b.`course_name`
        FROM
        `t_course_certification` a
        INNER JOIN `m_course` b ON a.`course_id` = b.`course_id`
        WHERE a.`certification_id` = '$id';"
        );
        return view('admin.certification.course', ['course' => $course]);
    }

    public function interest(string $id){
        $interest = DB::select(
            "SELECT
        b.`interest_name`
        FROM
        `t_interest_certification` a
        INNER JOIN `m_interest` b ON a.`interest_id` = b.`interest_id`
        WHERE a.`certification_id` = '$id';"
        );
        return view('admin.certification.interest', ['interest' => $interest]);
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


    public function create_ajax()
    {
        $certification_vendor = CertificationVendorModel::select('certification_vendor_id', 'certification_vendor_name')->get();
        $user = UserModel::select('user_id','user_fullname')->get();
        return view('admin.certification.create_ajax', ['certification_vendor' => $certification_vendor, 'user' => $user]);
    }

    public function store(Request $request)
{   
    // dd($request);
        $rules = [
            'certification_name' => 'required|string|max:100',
            'certification_number' => 'required|string|max:100',
            'certification_period' => 'required|integer',
            'certification_date_start' => 'required|date|before_or_equal:certification_date_expired',
            'certification_date_expired' => 'required|date|after_or_equal:certification_date_start',
            'certification_vendor_id' => 'required|string',
            'certification_level' => 'required|integer',
            'certification_type' => 'required|integer',
            'certification_file' => 'required|mimes:pdf|max:2048', // Maksimum 2MB
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
                'certification_period' => $request->certification_period,
                'certification_date_start' => $request->certification_date_start,
                'certification_date_expired' => $request->certification_date_expired,
                'certification_vendor_id' => $request->certification_vendor_id,
                'certification_level' => $request->certification_level,
                'certification_type' => $request->certification_type,
                'certification_file' => $filePath,
                'user_id' => $request->user_id,
            ]);

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
        // Gunakan parameter binding untuk mencegah SQL Injection
        $certification = DB::selectOne(
            "SELECT
                a.certification_id,
                a.certification_name,
                a.certification_number,
                a.certification_period,
                a.certification_date_start,
                a.certification_date_expired,
                a.certification_period,
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


    public function edit_ajax(string $id)
    {
        // Static data for simulation
        $certifications = collect([
            [
                'certification_id' => 1,
                'certification_name' => 'Google Data Analytics',
                'certification_number' => '001/GOOGLE/DATA-ANALYTICS/2024',
                'certification_date' => '2024-11-04',
                'certification_expired' => '2027-11-04',
                'certification_vendor_id' => 1,
                'vendor' => [
                    'certification_vendor_name' => 'Google'
                ],
                'certification_type_id' => 1,
                'type' => [
                    'certification_type_name' => 'Sertifikasi Profesi'
                ],
                'certification_level_id' => 1,
                'level' => [
                    'certification_level_name' => 'Internasional',
                ],
                'course_id' => 1,
                'course' => [
                    'course_name' => 'Data Analytics'
                ],
                'interest_id' => 1,
                'interest' => [
                    'interest_name' => 'Big Data'
                ],
            ],
            [
                'certification_id' => 2,
                'certification_name' => 'IBM Data Science',
                'certification_number' => '001/IBM/DATA-SCIENCE/2024',
                'certification_date' => '2024-11-05',
                'certification_expired' => '2027-11-05',
                'certification_vendor_id' => 2,
                'vendor' => [
                    'certification_vendor_name' => 'IBM'
                ],
                'certification_type_id' => 1,
                'type' => [
                    'certification_type_name' => 'Sertifikasi Profesi'
                ],
                'certification_level_id' => 1,
                'level' => [
                    'certification_level_name' => 'Internasional',
                ],
                'course_id' => 2,
                'course' => [
                    'course_name' => 'Data Science'
                ],
                'interest_id' => 1,
                'interest' => [
                    'interest_name' => 'Big Data'
                ],
            ],
            [
                'certification_id' => 3,
                'certification_name' => 'Program Improvement Business',
                'certification_number' => '001/UNIVERSITYOFSYDNEY/BUSINESS/2024',
                'certification_date' => '2024-11-06',
                'certification_expired' => '2027-11-06',
                'certification_vendor_id' => 3,
                'vendor' => [
                    'certification_vendor_name' => 'The University Of Sydney'
                ],
                'certification_type_id' => 1,
                'type' => [
                    'certification_type_name' => 'Sertifikasi Profesi'
                ],
                'certification_level_id' => 1,
                'level' => [
                    'certification_level_name' => 'Internasional',
                ],
                'course_id' => 3,
                'course' => [
                    'course_name' => 'Business Intellegent'
                ],
                'interest_id' => 2,
                'interest' => [
                    'interest_name' => 'Business'
                ],
            ]
        ]);

        $vendor = collect([
            ['certification_vendor_id' => 1, 'certification_vendor_name' => 'Google'],
            ['certification_vendor_id' => 2, 'certification_vendor_name' => 'BNSP'],
            ['certification_vendor_id' => 3, 'certification_vendor_name' => 'IBM'],
        ]);

        $type = collect([
            ['certification_type_id' => 1, 'certification_type_name' => 'Sertifikasi Profesi'],
            ['certification_type_id' => 2, 'certification_type_name' => 'Sertifikasi Profesi'],
        ]);

        // Data statis untuk level
        $level = collect([
            ['certification_level_id' => 1, 'certification_level_name' => 'Internasional'],
            ['certification_level_id' => 2, 'certification_level_name' => 'Nasional'],
            ['certification_level_id' => 3, 'certification_level_name' => 'Regional'],
        ]);

        $course = collect([
            ['course_id' => 1, 'course_name' => 'Big Data'],
            ['course_id' => 2, 'course_name' => 'Data Science'],
            ['course_id' => 3, 'course_name' => 'Business Intellegent'],
        ]);

        $interest = collect([
            ['interest_id' => 1, 'interest_name' => 'Data Analytics'],
            ['interest_id' => 2, 'interest_name' => 'Business'],
            ['interest_id' => 3, 'interest_name' => 'Development'],
        ]);


        // Menemukan pengguna by ID
        $certification = $certifications->firstWhere('certification_id', (int)$id);

        // Mengembalikan view penguna dan level
        return view('admin.certification.edit_ajax', ['certification' => $certification, 'vendor' => $vendor, 'type' => $type, 'level' => $level, 'course' => $course, 'interest' => $interest]);
    }

    public function update_ajax(Request $request, $id)
    {
        // Update data pengguna disini
        return response()->json([
            'status' => true,
            'message' => 'Data Sertifikasi Berhasil Diupdate (Simulasi)',
            'redirect' => url('/certification') // URL tujuan redirect
        ]);
    }

    public function confirm_ajax(string $id)
    {
        // Static data for simulation
        $certifications = collect([
            [
                'certification_id' => 1,
                'certification_name' => 'Google Data Analytics',
                'certification_number' => '001/GOOGLE/DATA-ANALYTICS/2024',
                'certification_date' => '2024-11-04',
                'certification_expired' => '2027-11-04',
                'certification_vendor_id' => 1,
                'vendor' => [
                    'certification_vendor_name' => 'Google'
                ],
                'certification_type_id' => 1,
                'type' => [
                    'certification_type_name' => 'Sertifikasi Profesi'
                ],
                'certification_level_id' => 1,
                'level' => [
                    'certification_level_name' => 'Internasional',
                ],
                'course_id' => 1,
                'course' => [
                    'course_name' => 'Data Analytics'
                ],
                'interest_id' => 1,
                'interest' => [
                    'interest_name' => 'Big Data'
                ],
            ],
            [
                'certification_id' => 2,
                'certification_name' => 'IBM Data Science',
                'certification_number' => '001/IBM/DATA-SCIENCE/2024',
                'certification_date' => '2024-11-05',
                'certification_expired' => '2027-11-05',
                'certification_vendor_id' => 2,
                'vendor' => [
                    'certification_vendor_name' => 'IBM'
                ],
                'certification_type_id' => 1,
                'type' => [
                    'certification_type_name' => 'Sertifikasi Profesi'
                ],
                'certification_level_id' => 1,
                'level' => [
                    'certification_level_name' => 'Internasional',
                ],
                'course_id' => 2,
                'course' => [
                    'course_name' => 'Data Science'
                ],
                'interest_id' => 1,
                'interest' => [
                    'interest_name' => 'Big Data'
                ],
            ],
            [
                'certification_id' => 3,
                'certification_name' => 'Program Improvement Business',
                'certification_number' => '001/UNIVERSITYOFSYDNEY/BUSINESS/2024',
                'certification_date' => '2024-11-06',
                'certification_expired' => '2027-11-06',
                'certification_vendor_id' => 3,
                'vendor' => [
                    'certification_vendor_name' => 'The University Of Sydney'
                ],
                'certification_type_id' => 1,
                'type' => [
                    'certification_type_name' => 'Sertifikasi Profesi'
                ],
                'certification_level_id' => 1,
                'level' => [
                    'certification_level_name' => 'Internasional',
                ],
                'course_id' => 3,
                'course' => [
                    'course_name' => 'Business Intellegent'
                ],
                'interest_id' => 2,
                'interest' => [
                    'interest_name' => 'Business'
                ],
            ]
        ]);

        $certification = $certifications->firstWhere('certification_id', (int)$id);

        // Mengembalikan view penguna dan level
        return view('admin.certification.confirm_ajax', ['certification' => $certification]);
    }

    public function delete_ajax(Request $request, $id)
    {
        // Hapus data pengguna disini
        return response()->json([
            'status' => true,
            'message' => 'Data Sertifikasi Berhasil Dihapus (Simulasi)',
            'redirect' => url('/certification') // URL tujuan redirect
        ]);

    }
}
