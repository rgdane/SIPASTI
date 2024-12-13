<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class TrainingHistoryController extends Controller
{
    public function index(String $user)
    {

        // Ensure the user is authenticated
        // if (!Auth::check()) {
        //     return response()->json([
        //         'status' => false,
        //         'message' => 'Unauthorized access',
        //         'errors' => ['authentication' => ['User not authenticated']]
        //     ], 401);
        // }
        
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
                a.training_status = '4'", [$user]
        );

        return response()->json($trainings);
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
        return response()->json([$training, $interest, $course]);
    }
}
