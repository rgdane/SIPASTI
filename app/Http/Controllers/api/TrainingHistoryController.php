<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class TrainingHistoryController extends Controller
{
    public function index()
    {
        // Ensure the user is authenticated
        // if (!Auth::check()) {
        //     return response()->json([
        //         'status' => false,
        //         'message' => 'Unauthorized access',
        //         'errors' => ['authentication' => ['User not authenticated']]
        //     ], 401);
        // }
    
        $userId = Auth::user()->user_id;
        
        $trainings = DB::select(
            "SELECT
                a.training_id,
                a.training_name,
                a.training_date,
                d.period_year,
                CASE
                    WHEN a.training_level = '0' THEN 'Nasional'
                        ELSE 'Internasional'
                END AS training_level
                FROM
                m_training a
                INNER JOIN m_training_vendor b ON a.training_vendor_id = b.training_vendor_id
                INNER JOIN t_training_member c ON a.training_id = c.training_id AND c.user_id = ?
                INNER JOIN m_period d ON a.period_id = d.period_id
            WHERE
                a.training_status = '4'", [$userId]
        );

        return response()->json($trainings, 201);
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
        
        $trainings = DB::select(
            "SELECT
                a.training_id,
                a.training_name,
                a.training_date,
                d.period_year,
                CASE
                    WHEN a.training_level = '0' THEN 'Nasional'
                        ELSE 'Internasional'
                END AS training_level
                FROM
                m_training a
                INNER JOIN m_training_vendor b ON a.training_vendor_id = b.training_vendor_id
                INNER JOIN t_training_member c ON a.training_id = c.training_id AND c.user_id = ?
                INNER JOIN m_period d ON a.period_id = d.period_id
            WHERE
                a.training_status = '4'", [$userId]
        );

        // $trainings = DB::table('m_training as a')
        // ->select([
        //     'a.training_id',
        //     'a.training_name',
        //     'a.training_number',
        //     'a.training_date',
        //     'd.period_year',
        //     DB::raw("CASE WHEN a.training_level = '0' THEN 'Nasional' ELSE 'Internasional' END AS training_level"),
        //     'c.user_fullname'
        // ])
        // ->join('m_training_vendor as b', 'a.training_vendor_id', '=', 'b.training_vendor_id')
        // ->join('t_training_member as c', 'a.training_id', '=', 'c.training_id')
        // ->join('m_period as d', 'a.period_id', '=', 'd.period_id')
        // ->where('a.user_id', [$userId]);

        return DataTables::of($trainings)
            ->addIndexColumn()
            // ->addColumn('status', function ($training) {
            //     $now = now();
            //     $expired = \Carbon\Carbon::parse($training->training_date_expired);
    
            //     if ($now > $expired) {
            //         return json_encode([
            //             'text' => 'Kadaluarsa',
            //             'class' => 'bg-danger-light text-danger'
            //         ]);
            //     }
    
            //     return json_encode([
            //         'text' => 'Aktif',
            //         'class' => 'bg-success-light text-success'
            //     ]);
            // })
            ->addColumn('aksi', function ($trainings) {
                $btn = '<button onclick="modalAction(\'' . url('/training_history/' . $trainings->training_id . '/show') . '\')" class="btn btn-info btn-sm">Detail</button>';
                return $btn;
            })
            // ->filter(function($query){
            //     if(request()->has('status')){
            //         $status = request('status');
            //         $now = now();

            //         if($status === 'Aktif'){
            //             $query->whereDate('a.training_date_expired', '>', $now);
            //         } 
            //         else if($status === 'Kadaluarsa'){
            //             $query->whereDate('a.training_date_expired', '<=', $now);
            //         }
            //     }
            // })
            ->rawColumns(['aksi'])
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
                END AS training_level
                -- CASE
                --     WHEN a.training_status = '0' THEN 'Pending'
                --     WHEN a.training_status = '1' THEN 'Pengajuan'
                --     WHEN a.training_status = '2' THEN 'Ditolak'
                --     WHEN a.training_status = '3' THEN 'Disetujui'
                --     WHEN a.training_status = '4' THEN 'Selesai'
                -- END AS training_status
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
        return view('lecturer.training_history.show', [
            'training' => $training,
            'interest' => $interest,
            'course' => $course,
        ]);
    }
}
