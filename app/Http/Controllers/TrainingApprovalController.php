<?php

namespace App\Http\Controllers;

use App\Models\TrainingModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class TrainingApprovalController extends Controller
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

        $activeMenu = 'training_approval';

        return view('head_department.training_approval.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }

    public function list()
    {
        $trainings = DB::select(
            "SELECT
                a.training_id,
                a.training_name,
                d.period_year,
                DATE_FORMAT(a.training_date, '%d-%m-%Y') AS training_date,
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
            $btn = '<button onclick="modalAction(\''.url('/training_approval/' . $trainings->training_id . '/show').'\')" class="btn btn-info btn-sm">Detail</button> '; 
            return $btn;
        })
        ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
        ->make(true);
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
        return view('head_department.training_approval.show', [
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

    public function approve(String $id){
        $check = TrainingModel::find($id);
        if ($check) {
            $check->training_status = '3';
            $check->save();
            return response()->json([
                'status' => true,
                'message' => 'Pengajuan Pelatihan Disetujui',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Pembaruan status berhasil',
            ]);
        }
    }

    public function reject(String $id){
        $check = TrainingModel::find($id);
        if ($check) {
            $check->training_status = '2';
            $check->save();
            return response()->json([
                'status' => true,
                'message' => 'Pembaruan status berhasil',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Data Pengajuan tidak ditemukan',
            ]);
        }
    }
}
