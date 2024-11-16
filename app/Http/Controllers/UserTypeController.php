<?php

namespace App\Http\Controllers;

use App\Models\UserTypeModel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Yajra\DataTables\DataTables;

class UserTypeController extends Controller
{
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Daftar Jenis Pengguna',
            'list' => ['Home', 'Jenis Pengguna']
        ];

        $page = (object)[
            'title' => 'Daftar user_type yang terdaftar dalam sistem'
        ];

        $activeMenu = 'user_type'; //set menu yang sedang aktif

        return view('admin.user_type.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }

    // Ambil data user_type dalam bentuk json untuk datatables
    public function list()
    {
        $user_types = UserTypeModel::select('user_type_id', 'user_type_code', 'user_type_name');
        return DataTables::of($user_types)
            // menambahkan kolom index / no urut (default user_type_name kolom: DT_RowIndex)
            ->addIndexColumn()
            ->addColumn('aksi', function ($user_types) { // menambahkan kolom aksi
                $btn  = '<button onclick="modalAction(\'' . url('/user_type/' . $user_types->user_type_id . '/show') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                return $btn;
            })
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
            ->make(true);
    }

    public function create()
    {
        return view('admin.user_type.create');
    }

    public function store(Request $request)
    {
        $rules = [
            'user_type_code' => 'required|string|min:3|max:10|unique:m_user_type,user_type_code',
            'user_type_name' => 'required|string|max:100',
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi Gagal',
                'msgField' => $validator->errors(),
            ]);
        }

        UserTypeModel::create($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Data jenis pengguna berhasil disimpan',
        ]);

        redirect('/');
    }


    public function show(string $id)
    {
        $user_type = UserTypeModel::find($id);
        return view('admin.user_type.show', ['user_type' => $user_type]);
    }
}
