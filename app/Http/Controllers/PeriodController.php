<?php

namespace App\Http\Controllers;

use App\Models\PeriodModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class PeriodController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Tahun Periode',
            'list' => ['Home', 'Tahun Periode']
        ];

        $page = (object) [
            'title' => 'Manajemen Data Tahun Periode',
        ];

        $activeMenu = 'period';

        return view('admin.period.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 
        'activeMenu' => $activeMenu]);
    }

    public function list()
    {
        $periods = PeriodModel::select(
            'period_id',
            'period_year'
        );
        return DataTables::of($periods)
        // menambahkan kolom index / no urut (default period_code kolom: DT_RowIndex)
        ->addIndexColumn()
        ->addColumn('aksi', function ($periods) { // menambahkan kolom aksi
            $btn = '<button onclick="modalAction(\''.url('/period/' . $periods->period_id . '/edit').'\')" class="btn btn-warning btn-sm">Edit</button> '; 
            $btn .= '<button onclick="modalAction(\''.url('/period/' . $periods->period_id . '/delete').'\')"  class="btn btn-danger btn-sm">Hapus</button> ';
            return $btn;
        })
        ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
        ->make(true);
    }

    public function create(){
        return view('admin.period.create');
    }

    public function store(Request $request){
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'period_year' => 'required|integer',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(),
                ]);
            }
            PeriodModel::create($request->all());
            return response()->json([
                'status' => true,
                'message' => 'Data vendor sertifikasi berhasil disimpan'
            ]);
        }
        redirect('/');
    }

        public function show(string $id){
            $period = PeriodModel::find($id);
            return view('admin.period.show', ['period' => $period]);
        }

        public function edit(string $id){
            $period = PeriodModel::find($id);
            return view('admin.period.edit', ['period' => $period]);
        }
        
        Public function update(Request $request, $id){
            // cek apakah request dari ajax
            if ($request->ajax()|| $request->wantsJson()) {
                $rules = [ 
                    'period_year' => 'required|integer'
                ];
                $validator = Validator::make($request->all(), $rules);

                if ($validator->fails()) {
                    return response()->json([
                        'status'   => false,
                        'message'  => 'Validasi gagal.',
                        'msgField' => $validator->errors()
                    ]);
                }

                $check = PeriodModel::find($id); 
                if ($check) { 
                    $check->update($request->all()); 
                    return response()->json([ 
                        'status'  => true, 
                        'message' => 'Data berhasil diupdate' 
                    ]); 
                } else{ 
                    return response()->json([ 
                        'status'  => false, 
                        'message' => 'Data tidak ditemukan' 
                    ]); 
                } 
            } 
            return redirect('/'); 
        } 

        public function confirm(string $id){
            $period = PeriodModel::find($id);
            return view('admin.period.confirm', ['period' => $period]);
        }

        public function delete(Request $request, $id){
            if($request -> ajax() || $request -> wantsJson()){
                $period = PeriodModel::find($id);
                if($period){
                    $period -> delete();
                    return response() -> json([
                        'status' => true,
                        'message' => 'Data berhasil dihapus'
                    ]);
                } else {
                    return response() -> json([
                        'status' => false,
                        'message' => 'data tidak ditemukan'
                    ]);
                }
            }
            return redirect('/');
        }
}
