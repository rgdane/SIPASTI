<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

use function Ramsey\Uuid\v1;

class TypeTraining extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Jenis Pelatihan',
            'list' => ['Home', 'Pelatihan']
        ];

        $page = (object) [
            'title' => 'Manajemen Jenis Pelatihan',
        ];

        $activeMenu = 'trainingType';

        return view('admin.trainingType.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }

    public function list(Request $request)
    {
        // Static data for simulation
        $trainingTypes = collect([
            [
                'training_type_id' => 1,
                'training_type_code' => 'TRN01',
                'training_type_name' => 'Mandiri',
            ],
            [
                'training_type_id' => 2,
                'training_type_code' => 'TRN02',
                'training_type_name' => 'Non-Mandiri',
            ]
        ]);

        // Return the data in DataTables format
        return DataTables::of($trainingTypes)
            ->addIndexColumn() // Add index column for row number
            ->addColumn('aksi', function ($trainingType) { // Add action column
                $btn = '<button onclick="modalAction(\'' . url('/trainingType/' . $trainingType['training_type_id'] . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/trainingType/' . $trainingType['training_type_id'] . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/trainingType/' . $trainingType['training_type_id'] . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button>';
                return $btn;
            })
            ->rawColumns(['aksi']) // Specify that 'aksi' column contains HTML
            ->make(true);
    }

    public function create_ajax()
    {
        return view('admin.trainingType.create');
    }

    public function store_ajax()
    {
        // Simulasi respons sukses tanpa menyimpan data
        return response()->json([
            'status' => true,
            'message' => 'Data Jenis Pelatihan Berhasil Ditambahkan (Simulasi)',
            'redirect' => url('/trainingType') // URL tujuan redirect
        ]);
    }

    public function show_ajax(string $id)
    {
        $trainingTypes = collect([
            [
                'training_type_id' => 1,
                'training_type_code' => 'TRN01',
                'training_type_name' => 'Mandiri',
            ],
            [
                'training_type_id' => 2,
                'training_type_code' => 'TRN02',
                'training_type_name' => 'Non-Mandiri',
            ]
        ]);

        $trainingType = $trainingTypes->firstWhere('training_type_id', (int)$id);

        return view('admin.trainingType.show_ajax', ['trainingType' => $trainingType]);
    }

    public function edit_ajax(string $id)
    {
        $trainingTypes = collect([
            [
                'training_type_id' => 1,
                'training_type_code' => 'TRN01',
                'training_type_name' => 'Mandiri',
            ],
            [
                'training_type_id' => 2,
                'training_type_code' => 'TRN02',
                'training_type_name' => 'Non-Mandiri',
            ]
        ]);

        $trainingType = $trainingTypes->firstWhere('training_type_id', (int)$id);


        return view('admin.trainingType.edit_ajax', ['trainingType' => $trainingType]);
    }

    public function update_ajax(Request $request, $id)
    {
        // Simulasi respons sukses tanpa menyimpan data
        return response()->json([
            'status' => true,
            'message' => 'Data Jenis Pelatihan Berhasil Diupdate (Simulasi)',
            'redirect' => url('/trainingType') // URL tujuan redirect
        ]);
    }

    public function confirm_ajax(string $id)
    {
        $trainingTypes = collect([
            [
                'training_type_id' => 1,
                'training_type_code' => 'TRN01',
                'training_type_name' => 'Mandiri',
            ],
            [
                'training_type_id' => 2,
                'training_type_code' => 'TRN02',
                'training_type_name' => 'Non-Mandiri',
            ]
        ]);

        $trainingType = $trainingTypes->firstWhere('training_type_id', (int)$id);

        return view('admin.trainingType.confirm_ajax', ['trainingType' => $trainingType]);
    }

    public function delete_ajax()
    {
        // Hapus data pengguna disini
        return response()->json([
            'status' => true,
            'message' => 'Data Jenis Pelatihan Berhasil Dihapus (Simulasi)',
            'redirect' => url('/trainingType') // URL tujuan redirect
        ]);
    }
}
