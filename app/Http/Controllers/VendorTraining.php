<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class VendorTraining extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Vendor Pelatihan',
            'list' => ['Home', 'Pelatihan']
        ];

        $page = (object) [
            'title' => 'Manejemen Vendor Pelatihan',
        ];

        $activeMenu = 'trainingVendor';

        return view('admin.trainingVendor.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }

    public function list(Request $request)
    {
        $trainingVendors = collect([
            [
                'training_vendor_id' => 1,
                'training_vendor_name' => 'Google',
                'training_vendor_address' => 'Jakarta',
                'training_vendor_city' => 'Cibaduyut',
                'training_vendor_phone' => '0858585858585',
                'training_vendor_web' => 'https://www.google.com'
            ],
            [
                'training_vendor_id' => 2,
                'training_vendor_name' => 'Microsoft',
                'training_vendor_address' => 'Malang',
                'training_vendor_city' => 'Kepanjen',
                'training_vendor_phone' => '0858585858585',
                'training_vendor_web' => 'https://www.microsoft.com'
            ],
            [
                'training_vendor_id' => 3,
                'training_vendor_name' => 'IBM',
                'training_vendor_address' => 'Bali',
                'training_vendor_city' => 'Banglis',
                'training_vendor_phone' => '0858585858585',
                'training_vendor_web' => 'https://www.ibm.com'
            ]
        ]);

        if ($request->training_vendor_id) {
            $trainingVendors = $trainingVendors->where(
                'training_vendor_id',
                $request->training_vendor_id
            );
        }

        return DataTables::of($trainingVendors)
            ->addIndexColumn() // Add index column for row number
            ->addColumn('aksi', function ($trainingVendor) { // Add action column
                $btn = '<button onclick="modalAction(\'' . url('/trainingVendor/' . $trainingVendor['training_vendor_id'] . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/trainingVendor/' . $trainingVendor['training_vendor_id'] . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/trainingVendor/' . $trainingVendor['training_vendor_id'] . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button>';
                return $btn;
            })
            ->rawColumns(['aksi']) // Specify that 'aksi' column contains HTML
            ->make(true);
    }

    public function create_ajax()
    {
        return view('admin.trainingVendor.create');
    }

    public function store_ajax()
    {
        return response()->json([
            'status' => true,
            'message' => 'Data Vendor Pelatihan Berhasil Ditambahkan (Simulasi)',
            'redirect' => url('/trainingVendor') // URL tujuan redirect
        ]);
    }

    public function show_ajax(string $id)
    {
        $trainingVendors = collect([
            [
                'training_vendor_id' => 1,
                'training_vendor_name' => 'Google',
                'training_vendor_address' => 'Jakarta',
                'training_vendor_city' => 'Cibaduyut',
                'training_vendor_phone' => '0858585858585',
                'training_vendor_web' => 'https://www.google.com'
            ],
            [
                'training_vendor_id' => 2,
                'training_vendor_name' => 'Microsoft',
                'training_vendor_address' => 'Malang',
                'training_vendor_city' => 'Kepanjen',
                'training_vendor_phone' => '0858585858585',
                'training_vendor_web' => 'https://www.microsoft.com'
            ],
            [
                'training_vendor_id' => 3,
                'training_vendor_name' => 'IBM',
                'training_vendor_address' => 'Bali',
                'training_vendor_city' => 'Banglis',
                'training_vendor_phone' => '0858585858585',
                'training_vendor_web' => 'https://www.ibm.com'
            ]
        ]);

        $trainingVendor = $trainingVendors->firstWhere('training_vendor_id', (int)$id);

        return view('admin.trainingVendor.show_ajax', ['trainingVendor' => $trainingVendor]);
    }

    public function edit_ajax(string $id)
    {
        $trainingVendors = collect([
            [
                'training_vendor_id' => 1,
                'training_vendor_name' => 'Google',
                'training_vendor_address' => 'Jakarta',
                'training_vendor_city' => 'Cibaduyut',
                'training_vendor_phone' => '0858585858585',
                'training_vendor_web' => 'https://www.google.com'
            ],
            [
                'training_vendor_id' => 2,
                'training_vendor_name' => 'Microsoft',
                'training_vendor_address' => 'Malang',
                'training_vendor_city' => 'Kepanjen',
                'training_vendor_phone' => '0858585858585',
                'training_vendor_web' => 'https://www.microsoft.com'
            ],
            [
                'training_vendor_id' => 3,
                'training_vendor_name' => 'IBM',
                'training_vendor_address' => 'Bali',
                'training_vendor_city' => 'Banglis',
                'training_vendor_phone' => '0858585858585',
                'training_vendor_web' => 'https://www.ibm.com'
            ]
        ]);

        $trainingVendor = $trainingVendors->firstWhere('training_vendor_id', (int)$id);

        return view('admin.trainingVendor.edit_ajax', ['trainingVendor' => $trainingVendor]);
    }

    public function update_ajax(Request $request, $id)
    {
        // Update data pengguna disini
        return response()->json([
            'status' => true,
            'message' => 'Data Vendor Pelatihan Berhasil Diupdate (Simulasi)',
            'redirect' => url('/vendorTraining') // URL tujuan redirect
        ]);
    }

    public function confirm_ajax(string $id)
    {
        $trainingVendors = collect([
            [
                'training_vendor_id' => 1,
                'training_vendor_name' => 'Google',
                'training_vendor_address' => 'Jakarta',
                'training_vendor_city' => 'Cibaduyut',
                'training_vendor_phone' => '0858585858585',
                'training_vendor_web' => 'https://www.google.com'
            ],
            [
                'training_vendor_id' => 2,
                'training_vendor_name' => 'Microsoft',
                'training_vendor_address' => 'Malang',
                'training_vendor_city' => 'Kepanjen',
                'training_vendor_phone' => '0858585858585',
                'training_vendor_web' => 'https://www.microsoft.com'
            ],
            [
                'training_vendor_id' => 3,
                'training_vendor_name' => 'IBM',
                'training_vendor_address' => 'Bali',
                'training_vendor_city' => 'Banglis',
                'training_vendor_phone' => '0858585858585',
                'training_vendor_web' => 'https://www.ibm.com'
            ]
        ]);

        $trainingVendor = $trainingVendors->firstWhere('training_vendor_id', (int)$id);

        return view('admin.trainingVendor.confirm_ajax', ['trainingVendor' => $trainingVendor]);
    }

    public function delete_ajax(Request $request, $id)
    {
        // Hapus data pengguna disini
        return response()->json([
            'status' => true,
            'message' => 'Data Vendor Sertifikasi Berhasil Dihapus (Simulasi)',
            'redirect' => url('/certificationVendor') // URL tujuan redirect
        ]);

    }
}
