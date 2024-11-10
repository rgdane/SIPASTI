<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TypeCertification extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Jenis Sertifikasi',
            'list' => ['Home', 'Sertifikasi']
        ];

        $page = (object) [
            'title' => 'Daftar sertifikasi yang terdaftar dalam sistem'
        ];


        $activeMenu = 'certificationType';

        return view('admin.certificationType.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }

    public function list(Request $request)
    {
        // Static data for simulation
        $certificationTypes = collect([
            [
                'certification_type_id' => 1,
                'certification_type_code' => 'CTF01',
                'certification_type_name' => 'Sertifikasi Profesi',
            ],
            [
                'certification_type_id' => 2,
                'certification_type_code' => 'CTF02',
                'certification_type_name' => 'Sertifikasi Profesi',
            ]
        ]);

        // Return the data in DataTables format
        return DataTables::of($certificationTypes)
            ->addIndexColumn() // Add index column for row number
            ->addColumn('aksi', function ($certificationType) { // Add action column
                $btn = '<button onclick="modalAction(\'' . url('/certificationType/' . $certificationType['certification_type_id'] . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/certificationType/' . $certificationType['certification_type_id'] . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/certificationType/' . $certificationType['certification_type_id'] . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button>';
                return $btn;
            })
            ->rawColumns(['aksi']) // Specify that 'aksi' column contains HTML
            ->make(true);
    }

    public function create_ajax()
    {
        return view('admin.certificationType.create');
    }

    public function store_ajax()
    {
        // Simulasi respons sukses tanpa menyimpan data
        return response()->json([
            'status' => true,
            'message' => 'Data Jenis Sertifikasi Berhasil Ditambahkan (Simulasi)',
            'redirect' => url('/certificationType') // URL tujuan redirect
        ]);
    }

    public function show_ajax(string $id)
    {
        // Static data for simulation
        $certificationTypes = collect([
            [
                'certification_type_id' => 1,
                'certification_type_code' => 'CTF01',
                'certification_type_name' => 'Sertifikasi Profesi',
            ],
            [
                'certification_type_id' => 2,
                'certification_type_code' => 'CTF02',
                'certification_type_name' => 'Sertifikasi Profesi',
            ]
        ]);

        $certificationType = $certificationTypes->firstWhere('certification_type_id', (int)$id);

        return view('admin.certificationType.show_ajax', ['certificationType' => $certificationType]);
    }

    public function edit_ajax(string $id)
    {
        // Static data for simulation
        $certificationTypes = collect([
            [
                'certification_type_id' => 1,
                'certification_type_code' => 'CTF01',
                'certification_type_name' => 'Sertifikasi Profesi',
            ],
            [
                'certification_type_id' => 2,
                'certification_type_code' => 'CTF02',
                'certification_type_name' => 'Sertifikasi Profesi',
            ]
        ]);

        $certificationType = $certificationTypes->firstWhere('certification_type_id', (int)$id);

        return view('admin.certificationType.edit_ajax', ['certificationType' => $certificationType]);
    }

    public function update_ajax(Request $request)
    {
        // Simulasi respons sukses tanpa menyimpan data
        return response()->json([
            'status' => true,
            'message' => 'Data Jenis Sertifikasi Berhasil Diupdate (Simulasi)',
            'redirect' => url('/certificationType') // URL tujuan redirect
        ]);
    }

    public function confirm_ajax(string $id)
    {
        // Static data for simulation
        $certificationTypes = collect([
            [
                'certification_type_id' => 1,
                'certification_type_code' => 'CTF01',
                'certification_type_name' => 'Sertifikasi Profesi',
            ],
            [
                'certification_type_id' => 2,
                'certification_type_code' => 'CTF02',
                'certification_type_name' => 'Sertifikasi Profesi',
            ]
        ]);

        $certificationType = $certificationTypes->firstWhere('certification_type_id', (int)$id);

        return view('admin.certificationType.confirm_ajax', ['certificationType' => $certificationType]);
    }

    public function delete_ajax()
    {
        // Hapus data pengguna disini
        return response()->json([
            'status' => true,
            'message' => 'Data Jenis Sertifikasi Berhasil Dihapus (Simulasi)',
            'redirect' => url('/certificationType') // URL tujuan redirect
        ]);
    }
}
