<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class StatisticController extends Controller
{
    public function index(){
        $breadcrumb = (object)[
            'title' => 'Data Statistik',
            'list' => ['Home', 'Data Statistik']
        ];
    
        $page = (object)[
            'title' => 'Daftar statistik dosen dan tenaga pendidikan'
        ];
    
        $activeMenu = 'statistic'; //set menu yang sedang aktif
    
        return view('statistic.index',['breadcrumb'=>$breadcrumb, 'page' => $page, 'activeMenu'=>$activeMenu]);
    }
    
    // Ambil data statistic dalam bentuk json untuk datatables
    public function list()
    {
        $statistics = DB::select(
            "SELECT
                a.user_id,
                a.user_fullname,
                COUNT(b.user_id) AS certification_count,
                COUNT(c.user_id) AS training_count
            FROM
                m_user a
                LEFT JOIN m_certification b ON a.user_id = b.user_id
                LEFT JOIN t_training_member c ON a.user_id = c.user_id
            GROUP BY
                a.user_id
                ;"
        );
        return DataTables::of($statistics)
        // menambahkan kolom index / no urut (default statistic_name kolom: DT_RowIndex)
        ->addIndexColumn()
        // ->addColumn('aksi', function ($statistics) { // menambahkan kolom aksi
        //     $btn = '<button onclick="modalAction(\''.url('/statistic/' . $statistics->statistic_id . '/show').'\')" class="btn btn-info btn-sm">Detail</button> '; 
        //     $btn .= '<button onclick="modalAction(\''.url('/statistic/' . $statistics->statistic_id . '/edit').'\')" class="btn btn-warning btn-sm">Edit</button> '; 
        //     $btn .= '<button onclick="modalAction(\''.url('/statistic/' . $statistics->statistic_id . '/delete').'\')"  class="btn btn-danger btn-sm">Hapus</button> ';
        //     return $btn;
        // })
        // ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
        ->make(true);
    }
}
