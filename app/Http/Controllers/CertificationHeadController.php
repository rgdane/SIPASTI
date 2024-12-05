<?php

namespace App\Http\Controllers;

use App\Models\CertificationModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class CertificationHeadController extends Controller
{
    public function index(){
        $breadcrumb = (object)[
            'title' => 'Data Sertifikasi',
            'list' => ['Home', 'Data Sertifikasi']
        ];
    
        $page = (object)[
            'title' => 'Daftar sertifikasi yang terdaftar dalam sistem'
        ];
    
        $activeMenu = 'certification_head'; //set menu yang sedang aktif
    
        return view('head_department.certification.index',['breadcrumb'=>$breadcrumb, 'page' => $page, 'activeMenu'=>$activeMenu]);
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
            $btn = '<button onclick="modalAction(\''.url('/certification_head/' . $certifications->certification_id . '/show').'\')" class="btn btn-info btn-sm">Detail</button> '; 
            //$btn .= '<button onclick="modalAction(\''.url('/certification/' . $certifications->certification_id . '/edit').'\')" class="btn btn-warning btn-sm">Edit</button> '; 
            //$btn .= '<button onclick="modalAction(\''.url('/certification/' . $certifications->certification_id . '/delete').'\')"  class="btn btn-danger btn-sm">Hapus</button> ';
            return $btn;
        })
        ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
        ->make(true);
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
        return view('head_department.certification.show', ['certification' => $certification, 'interest' => $interest, 'course' => $course]);
    }
}
