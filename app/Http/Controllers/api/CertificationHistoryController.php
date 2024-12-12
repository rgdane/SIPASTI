<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CertificationHistoryController extends Controller
{
    public function index(String $user){
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
                INNER JOIN m_period d ON a.period_id = d.period_id
            WHERE
            a.user_id = :user", ['user' => $user]
        );

        return response()->json($certifications);
    }

    public function show(String $id){
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

        return response()->json([$certification, $interest, $course]);
    }
}
