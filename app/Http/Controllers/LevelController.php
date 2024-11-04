<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class LevelController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Level Pengguna',
            'list' => ['Home', 'Level']
        ];

        $page = (object) [
            'title' => 'Manajemen Level Pengguna'
        ];


        $activeMenu = 'level';

        return view('admin.level.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }

    // Ambil data user dalam bentuk json untuk datatables 
    public function list(Request $request)
    {
        // Static data for simulation
        $levels = collect([
            [
                'level_id' => 1,
                'level_kode' => 'ADM',
                'level_nama' => 'Administrator',
            ],
            [
                'level_id' => 2,
                'level_kode' => 'DSN',
                'level_nama' => 'Dosen',
            ],
            [
                'level_id' => 3,
                'level_kode' => 'PMP',
                'level_nama' => 'Pimpinan',
            ]
        ]);

        // Return the data in DataTables format
        return DataTables::of($levels)
            ->addIndexColumn() // Add index column for row number
            ->addColumn('aksi', function ($level) { // Add action column
                $btn = '<button onclick="modalAction(\'' . url('/level/' . $level['level_id'] . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/level/' . $level['level_id'] . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/level/' . $level['level_id'] . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button>';
                return $btn;
            })
            ->rawColumns(['aksi']) // Specify that 'aksi' column contains HTML
            ->make(true);
    }

    public function create_ajax()
    {
        return view('admin.level.create');
    }

    public function store_ajax(Request $request)
    {
        // Simulasi respons sukses tanpa menyimpan data
        return response()->json([
            'status' => true,
            'message' => 'Data Level Pengguna Berhasil Ditambahkan (Simulasi)',
            'redirect' => url('/user') // URL tujuan redirect
        ]);
    }

    public function show_ajax(string $id)
    {
        $levels = collect([
            [
                'level_id' => 1,
                'level_kode' => 'ADM',
                'level_nama' => 'Administrator',
            ],
            [
                'level_id' => 2,
                'level_kode' => 'DSN',
                'level_nama' => 'Dosen',
            ],
            [
                'level_id' => 3,
                'level_kode' => 'PMP',
                'level_nama' => 'Pimpinan',
            ]
        ]);

        // Find the user by ID
        $level = $levels->firstWhere('level_id', (int)$id);

        // Return the view with either the found user or null if not found
        return view('admin.level.show_ajax', ['level' => $level]);
    }

    public function edit_ajax(string $id)
    {
        // Data Statis
        $levels = collect([
            [
                'level_id' => 1,
                'level_kode' => 'ADM',
                'level_nama' => 'Administrator',
            ],
            [
                'level_id' => 2,
                'level_kode' => 'DSN',
                'level_nama' => 'Dosen',
            ],
            [
                'level_id' => 3,
                'level_kode' => 'PMP',
                'level_nama' => 'Pimpinan',
            ]
        ]);

        // Menemukan pengguna by ID
        $level = $levels->firstWhere('level_id', (int)$id);

        // Mengembalikan view penguna dan level
        return view('admin.level.edit_ajax', ['level' => $level]);
    }

    public function update_ajax(Request $request, $id)
    {
        // Update data level disini
        return response()->json([
            'status' => true,
            'message' => 'Data Level Pengguna Berhasil Diupdate (Simulasi)',
            'redirect' => url('/level') // URL tujuan redirect
        ]);
    }

    public function confirm_ajax(string $id)
    {
        // Static collection of users for simulation
        $levels = collect([
            [
                'level_id' => 1,
                'level_kode' => 'ADM',
                'level_nama' => 'Administrator',
            ],
            [
                'level_id' => 2,
                'level_kode' => 'DSN',
                'level_nama' => 'Dosen',
            ],
            [
                'level_id' => 3,
                'level_kode' => 'PMP',
                'level_nama' => 'Pimpinan',
            ]
        ]);

        // Find user by ID
        $level = $levels->firstWhere('level_id', $id);

        return view('admin.level.confirm_ajax', ['level' => $level]);
    }

    public function delete_ajax(Request $request, $id)
    {
        // Hapus data pengguna disini
        return response()->json([
            'status' => true,
            'message' => 'Data Level Pengguna Berhasil Dihapus (Simulasi)',
            'redirect' => url('/user') // URL tujuan redirect
        ]);

    }
}
