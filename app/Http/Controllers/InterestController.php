<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class InterestController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Bidang Minat',
            'list' => ['Home', 'Bidang Minat']
        ];

        $page = (object) [
            'title' => ' Manajemen Bidang Minat'
        ];

        $activeMenu = 'interest';

        return view('admin.interest.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }

    public function list() {
        $interests = collect([
            [
                'interest_id' => 1,
                'interest_code' => 'BD01',
                'interest_name' => 'Big Data',
            ],
            [
                'interest_id' => 2,
                'interest_code' => 'AI01',
                'interest_name' => 'Artificial Intelligence',
            ],
            [
                'interest_id' => 3,
                'interest_code' => 'ML01',
                'interest_name' => 'Machine Learning',
            ]
        ]);

        return DataTables::of($interests)
        ->addIndexColumn() // Add index column for row number
        ->addColumn('aksi', function ($interest) { // Add action column
            $btn = '<button onclick="modalAction(\'' . url('/interest/' . $interest['interest_id'] . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
            $btn .= '<button onclick="modalAction(\'' . url('/interest/' . $interest['interest_id'] . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
            $btn .= '<button onclick="modalAction(\'' . url('/interest/' . $interest['interest_id'] . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button>';
            return $btn;
        })
        ->rawColumns(['aksi']) // Specify that 'aksi' column contains HTML
        ->make(true);
    }

    public function create_ajax()
    {
        return view('admin.interest.create');
    }

    public function store_ajax()
    {
        // Simulasi respons sukses tanpa menyimpan data
        return response()->json([
            'status' => true,
            'message' => 'Data Bidang Minat Berhasil Ditambahkan (Simulasi)',
            'redirect' => url('/interest') // URL tujuan redirect
        ]);
    }

    public function show_ajax(string $id)
    {
        $interests = collect([
            [
                'interest_id' => 1,
                'interest_code' => 'BD01',
                'interest_name' => 'Big Data',
            ],
            [
                'interest_id' => 2,
                'interest_code' => 'AI01',
                'interest_name' => 'Artificial Intelligence',
            ],
            [
                'interest_id' => 3,
                'interest_code' => 'ML01',
                'interest_name' => 'Machine Learning',
            ]
        ]);

        $interest = $interests->firstWhere('interest_id', (int)$id);

        return view('admin.interest.show_ajax', ['interest' => $interest]);
    }

    public function edit_ajax(string $id)
    {
        $interests = collect([
            [
                'interest_id' => 1,
                'interest_code' => 'BD01',
                'interest_name' => 'Big Data',
            ],
            [
                'interest_id' => 2,
                'interest_code' => 'AI01',
                'interest_name' => 'Artificial Intelligence',
            ],
            [
                'interest_id' => 3,
                'interest_code' => 'ML01',
                'interest_name' => 'Machine Learning',
            ]
        ]);

        $interest = $interests->firstWhere('interest_id', (int)$id);

        return view('admin.interest.edit_ajax', ['interest' => $interest]);
    }

    public function update_ajax(Request $request, $id)
    {
        // Simulasi respons sukses tanpa menyimpan data
        return response()->json([
            'status' => true,
            'message' => 'Data Bidang Minat Berhasil Diupdate (Simulasi)',
            'redirect' => url('/interest') // URL tujuan redirect
        ]);
    }

    public function confirm_ajax(string $id)
    {
        $interests = collect([
            [
                'interest_id' => 1,
                'interest_code' => 'BD01',
                'interest_name' => 'Big Data',
            ],
            [
                'interest_id' => 2,
                'interest_code' => 'AI01',
                'interest_name' => 'Artificial Intelligence',
            ],
            [
                'interest_id' => 3,
                'interest_code' => 'ML01',
                'interest_name' => 'Machine Learning',
            ]
        ]);

        $interest = $interests->firstWhere('interest_id', (int)$id);

        return view('admin.interest.confirm_ajax', ['interest' => $interest]);
    }

    public function delete_ajax()
    {
        // Hapus data pengguna disini
        return response()->json([
            'status' => true,
            'message' => 'Data Bidang Minat Berhasil Dihapus (Simulasi)',
            'redirect' => url('/interest') // URL tujuan redirect
        ]);
    }
}
