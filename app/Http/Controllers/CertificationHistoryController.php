<?php

namespace App\Http\Controllers;

use App\Models\CertificationModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class CertificationHistoryController extends Controller
{
    public function index()
    {
        // Get the authenticated user's ID
        $userId = auth()->user()->user_id;
        $certifications = CertificationModel::where('user_id', $userId)->get();

        // Prepare breadcrumb and page information
        $breadcrumb = (object) [
            'title' => 'Riwayat Sertifikasi',
            'list' => ['Home', 'Riwayat Sertifikasi']
        ];

        $page = (object) [
            'title' => 'Riwayat Sertifikasi'
        ];

        $activeMenu = 'certification_history';

        return view('lecturer.certification_history.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu,
            'certifications' => $certifications,
            'userId' => $userId
        ]);
    }

    public function list()
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
        
        // $certifications = DB::select(
        //     "SELECT
        //         a.certification_id,
        //         a.certification_name,
        //         a.certification_number,
        //         a.certification_date_expired,
        //         d.period_year,
        //         CASE
        //             WHEN a.certification_level = '0' THEN 'Nasional'
        //                 ELSE 'Internasional'
        //         END AS certification_level,
        //         CASE
        //             WHEN a.certification_type = '0' THEN 'Profesi'
        //                 ELSE 'Keahlian'
        //         END AS certification_type,
        //         c.user_fullname
        //     FROM
        //         m_certification a
        //         INNER JOIN m_certification_vendor b ON a.certification_vendor_id = b.certification_vendor_id
        //         INNER JOIN m_user c ON a.user_id = c.user_id
        //         INNER JOIN m_period d ON a.period_id = d.period_id
        //     WHERE
        //         a.user_id = ?", [$userId]
        // );

        $certifications = DB::table('m_certification as a')
        ->select([
            'a.certification_id',
            'a.certification_name',
            'a.certification_number',
            'a.certification_date_expired',
            'd.period_year',
            DB::raw("CASE WHEN a.certification_level = '0' THEN 'Nasional' ELSE 'Internasional' END AS certification_level"),
            DB::raw("CASE WHEN a.certification_type = '0' THEN 'Profesi' ELSE 'Keahlian' END AS certification_type"),
            'c.user_fullname'
        ])
        ->join('m_certification_vendor as b', 'a.certification_vendor_id', '=', 'b.certification_vendor_id')
        ->join('m_user as c', 'a.user_id', '=', 'c.user_id')
        ->join('m_period as d', 'a.period_id', '=', 'd.period_id')
        ->where('a.user_id', [$userId]);

        return DataTables::of($certifications)
            ->addIndexColumn()
            ->addColumn('status', function ($certification) {
                $now = now();
                $expired = \Carbon\Carbon::parse($certification->certification_date_expired);
    
                if ($now > $expired) {
                    return json_encode([
                        'text' => 'Kadaluarsa',
                        'class' => 'bg-danger-light text-danger'
                    ]);
                }
    
                return json_encode([
                    'text' => 'Aktif',
                    'class' => 'bg-success-light text-success'
                ]);
            })
            ->addColumn('aksi', function ($certifications) {
                $btn = '<button onclick="modalAction(\'' . url('/certification_history/' . $certifications->certification_id . '/show') . '\')" class="btn btn-info btn-sm">Detail</button>';
                return $btn;
            })
            ->filter(function($query){
                if(request()->has('status')){
                    $status = request('status');
                    $now = now();

                    if($status === 'Aktif'){
                        $query->whereDate('a.certification_date_expired', '>', $now);
                    } 
                    else if($status === 'Kadaluarsa'){
                        $query->whereDate('a.certification_date_expired', '<=', $now);
                    }
                }
            })
            ->rawColumns(['aksi', 'status'])
            ->make(true);
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
        return view('lecturer.certification_history.show', ['certification' => $certification, 'interest' => $interest, 'course' => $course]);
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
}
