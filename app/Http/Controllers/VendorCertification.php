<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class VendorCertification extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Vendor Sertifikasi',
            'list' => ['Home', 'Sertifikasi']
        ];

        $page = (object) [
            'title' => 'Manajemen Vendor Sertifikasi'
        ];

        $activeMenu = 'certificationVendor';

        return view('admin.certificationVendor.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }

    public function list(Request $request)
    {
        // Static data for simulation
        $certificationVendors = collect([
            [
                'certification_vendor_id' => 1,
                'certification_vendor_name' => 'Google',
                'certification_vendor_address' => 'Malang',
                'certification_vendor_city' => 'Malang',
                'certification_vendor_phone' => '0895809772288',
                'certification_vendor_web' => 'https://www.google.com'
            ],
            [
                'certification_vendor_id' => 2,
                'certification_vendor_name' => 'BNSP',
                'certification_vendor_address' => 'Kepanjen',
                'certification_vendor_city' => 'Malang',
                'certification_vendor_phone' => '0895809772288',
                'certification_vendor_web' => 'https://bnspsertifikasi.id'
            ],
            [
                'certification_vendor_id' => 3,
                'certification_vendor_name' => 'IBM',
                'certification_vendor_address' => 'Pandaan',
                'certification_vendor_city' => 'Pasuruan',
                'certification_vendor_phone' => '0895809772288',
                'certification_vendor_web' => 'https://www.ibm.com'
            ]
        ]);

        if ($request->certification_vendor_id) {
            $certificationVendors = $certificationVendors->where('certification_vendor_id', $request->certification_vendor_id);
        }

        // Return the data in DataTables format
        return DataTables::of($certificationVendors)
            ->addIndexColumn() // Add index column for row number
            ->addColumn('aksi', function ($certificationVendor) { // Add action column
                $btn = '<button onclick="modalAction(\'' . url('/certificationVendor/' . $certificationVendor['certification_vendor_id'] . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/certificationVendor/' . $certificationVendor['certification_vendor_id'] . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/certificationVendor/' . $certificationVendor['certification_vendor_id'] . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button>';
                return $btn;
            })
            ->rawColumns(['aksi']) // Specify that 'aksi' column contains HTML
            ->make(true);
    }

    public function create_ajax()
    {
        return view('admin.certificationVendor.create');
    }

    public function store_ajax(Request $request)
    {
        // Simulasi respons sukses tanpa menyimpan data
        return response()->json([
            'status' => true,
            'message' => 'Data Vendor Sertifikasi Berhasil Ditambahkan (Simulasi)',
            'redirect' => url('/certificationVendor') // URL tujuan redirect
        ]);
    }

    public function show_ajax(string $id)
    {
        $certificationVendors = collect([
            [
                'certification_vendor_id' => 1,
                'certification_vendor_name' => 'Google',
                'certification_vendor_address' => 'Malang',
                'certification_vendor_city' => 'Malang',
                'certification_vendor_phone' => '0895809772288',
                'certification_vendor_web' => 'https://www.google.com'
            ],
            [
                'certification_vendor_id' => 2,
                'certification_vendor_name' => 'BNSP',
                'certification_vendor_address' => 'Kepanjen',
                'certification_vendor_city' => 'Malang',
                'certification_vendor_phone' => '0895809772288',
                'certification_vendor_web' => 'https://bnspsertifikasi.id'
            ],
            [
                'certification_vendor_id' => 3,
                'certification_vendor_name' => 'IBM',
                'certification_vendor_address' => 'Pandaan',
                'certification_vendor_city' => 'Pasuruan',
                'certification_vendor_phone' => '0895809772288',
                'certification_vendor_web' => 'https://www.ibm.com'
            ]
        ]);

        $certificationVendor = $certificationVendors->firstWhere('certification_vendor_id', (int)$id);

        return view('admin.certificationVendor.show_ajax', ['certificationVendor' => $certificationVendor]);
    }

    public function edit_ajax(string $id)
    {
        $certificationVendors = collect([
            [
                'certification_vendor_id' => 1,
                'certification_vendor_name' => 'Google',
                'certification_vendor_address' => 'Malang',
                'certification_vendor_city' => 'Malang',
                'certification_vendor_phone' => '0895809772288',
                'certification_vendor_web' => 'https://www.google.com'
            ],
            [
                'certification_vendor_id' => 2,
                'certification_vendor_name' => 'BNSP',
                'certification_vendor_address' => 'Kepanjen',
                'certification_vendor_city' => 'Malang',
                'certification_vendor_phone' => '0895809772288',
                'certification_vendor_web' => 'https://bnspsertifikasi.id'
            ],
            [
                'certification_vendor_id' => 3,
                'certification_vendor_name' => 'IBM',
                'certification_vendor_address' => 'Pandaan',
                'certification_vendor_city' => 'Pasuruan',
                'certification_vendor_phone' => '0895809772288',
                'certification_vendor_web' => 'https://www.ibm.com'
            ]
        ]);

        $certificationVendor = $certificationVendors->firstWhere('certification_vendor_id', (int)$id);

        return view('admin.certificationVendor.edit_ajax', ['certificationVendor' => $certificationVendor]);
    }

    public function update_ajax(Request $request, $id)
    {
        // Update data pengguna disini
        return response()->json([
            'status' => true,
            'message' => 'Data Vendor Sertifikasi Berhasil Diupdate (Simulasi)',
            'redirect' => url('/certificationVendor') // URL tujuan redirect
        ]);
    }

    public function confirm_ajax(string $id)
    {
        $certificationVendors = collect([
            [
                'certification_vendor_id' => 1,
                'certification_vendor_name' => 'Google',
                'certification_vendor_address' => 'Malang',
                'certification_vendor_city' => 'Malang',
                'certification_vendor_phone' => '0895809772288',
                'certification_vendor_web' => 'https://www.google.com'
            ],
            [
                'certification_vendor_id' => 2,
                'certification_vendor_name' => 'BNSP',
                'certification_vendor_address' => 'Kepanjen',
                'certification_vendor_city' => 'Malang',
                'certification_vendor_phone' => '0895809772288',
                'certification_vendor_web' => 'https://bnspsertifikasi.id'
            ],
            [
                'certification_vendor_id' => 3,
                'certification_vendor_name' => 'IBM',
                'certification_vendor_address' => 'Pandaan',
                'certification_vendor_city' => 'Pasuruan',
                'certification_vendor_phone' => '0895809772288',
                'certification_vendor_web' => 'https://www.ibm.com'
            ]
        ]);

        $certificationVendor = $certificationVendors->firstWhere('certification_vendor_id', (int)$id);

        return view('admin.certificationVendor.confirm_ajax', ['certificationVendor' => $certificationVendor]);
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
