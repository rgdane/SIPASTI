<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CertificationController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Sertifikasi',
            'list' => ['Home', 'Sertifikasi']
        ];

        $page = (object) [
            'title' => 'Manajemen Sertifikasi'
        ];

        $activeMenu = 'certification';

        return view('admin.certification.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }

    public function list(Request $request)
    {
        // Static data for simulation
        $certifications = collect([
            [
                'certification_id' => 1,
                'certification_name' => 'Google Data Analytics',
                'certification_number' => '001/GOOGLE/DATA-ANALYTICS/2024',
                'certification_date' => '2024-11-04',
                'certification_expired' => '2027-11-04',
                'certification_vendor_id' => 1,
                'vendor' => [
                    'certification_vendor_name' => 'Google'
                ],
                'certification_type_id' => 1,
                'type' => [
                    'certification_type_name' => 'Sertifikasi Profesi'
                ],
                'certification_level_id' => 1,
                'level' => [
                    'certification_level_name' => 'Internasional',
                ],
                'course_id' => 1,
                'course' => [
                    'course_name' => 'Data Analytics'
                ],
                'interest_id' => 1,
                'interest' => [
                    'interest_name' => 'Big Data'
                ],
            ],
            [
                'certification_id' => 2,
                'certification_name' => 'IBM Data Science',
                'certification_number' => '001/IBM/DATA-SCIENCE/2024',
                'certification_date' => '2024-11-05',
                'certification_expired' => '2027-11-05',
                'certification_vendor_id' => 2,
                'vendor' => [
                    'certification_vendor_name' => 'IBM'
                ],
                'certification_type_id' => 1,
                'type' => [
                    'certification_type_name' => 'Sertifikasi Profesi'
                ],
                'certification_level_id' => 1,
                'level' => [
                    'certification_level_name' => 'Internasional',
                ],
                'course_id' => 2,
                'course' => [
                    'course_name' => 'Data Science'
                ],
                'interest_id' => 1,
                'interest' => [
                    'interest_name' => 'Big Data'
                ],
            ],
            [
                'certification_id' => 3,
                'certification_name' => 'Program Improvement Business',
                'certification_number' => '001/UNIVERSITYOFSYDNEY/BUSINESS/2024',
                'certification_date' => '2024-11-06',
                'certification_expired' => '2027-11-06',
                'certification_vendor_id' => 3,
                'vendor' => [
                    'certification_vendor_name' => 'The University Of Sydney'
                ],
                'certification_type_id' => 1,
                'type' => [
                    'certification_type_name' => 'Sertifikasi Profesi'
                ],
                'certification_level_id' => 1,
                'level' => [
                    'certification_level_name' => 'Internasional',
                ],
                'course_id' => 3,
                'course' => [
                    'course_name' => 'Business Intellegent'
                ],
                'interest_id' => 2,
                'interest' => [
                    'interest_name' => 'Business'
                ],
            ]
        ]);

        if ($request->certification_vendor_id) {
            $certifications = $certifications->where('certification_vendor_id', $request->certification_vendor_id);
        }

        // Return the data in DataTables format
        return DataTables::of($certifications)
        ->addIndexColumn()
        ->addColumn('show_url', function ($certification) {
            return url('/certification/' . $certification['certification_id'] . '/show_ajax');
        })
        ->addColumn('edit_url', function ($certification) {
            return url('/certification/' . $certification['certification_id'] . '/edit_ajax');
        })
        ->addColumn('delete_url', function ($certification) {
            return url('/certification/' . $certification['certification_id'] . '/delete_ajax');
        })
        ->make(true);
    }

    public function create_ajax()
    {
        return view('admin.certification.create');
    }

    public function store_ajax(Request $request)
    {
        // Simulasi respons sukses tanpa menyimpan data
        return response()->json([
            'status' => true,
            'message' => 'Data Sertifikasi Berhasil Ditambahkan (Simulasi)',
            'redirect' => url('/certification') // URL tujuan redirect
        ]);
    }

    public function show_ajax(string $id)
    {
        // Static data for simulation
        $certifications = collect([
            [
                'certification_id' => 1,
                'certification_name' => 'Google Data Analytics',
                'certification_number' => '001/GOOGLE/DATA-ANALYTICS/2024',
                'certification_date' => '2024-11-04',
                'certification_expired' => '2027-11-04',
                'certification_vendor_id' => 1,
                'vendor' => [
                    'certification_vendor_name' => 'Google'
                ],
                'certification_type_id' => 1,
                'type' => [
                    'certification_type_name' => 'Sertifikasi Profesi'
                ],
                'certification_level_id' => 1,
                'level' => [
                    'certification_level_name' => 'Internasional',
                ],
                'course_id' => 1,
                'course' => [
                    'course_name' => 'Data Analytics'
                ],
                'interest_id' => 1,
                'interest' => [
                    'interest_name' => 'Big Data'
                ],
            ],
            [
                'certification_id' => 2,
                'certification_name' => 'IBM Data Science',
                'certification_number' => '001/IBM/DATA-SCIENCE/2024',
                'certification_date' => '2024-11-05',
                'certification_expired' => '2027-11-05',
                'certification_vendor_id' => 2,
                'vendor' => [
                    'certification_vendor_name' => 'IBM'
                ],
                'certification_type_id' => 1,
                'type' => [
                    'certification_type_name' => 'Sertifikasi Profesi'
                ],
                'certification_level_id' => 1,
                'level' => [
                    'certification_level_name' => 'Internasional',
                ],
                'course_id' => 2,
                'course' => [
                    'course_name' => 'Data Science'
                ],
                'interest_id' => 1,
                'interest' => [
                    'interest_name' => 'Big Data'
                ],
            ],
            [
                'certification_id' => 3,
                'certification_name' => 'Program Improvement Business',
                'certification_number' => '001/UNIVERSITYOFSYDNEY/BUSINESS/2024',
                'certification_date' => '2024-11-06',
                'certification_expired' => '2027-11-06',
                'certification_vendor_id' => 3,
                'vendor' => [
                    'certification_vendor_name' => 'The University Of Sydney'
                ],
                'certification_type_id' => 1,
                'type' => [
                    'certification_type_name' => 'Sertifikasi Profesi'
                ],
                'certification_level_id' => 1,
                'level' => [
                    'certification_level_name' => 'Internasional',
                ],
                'course_id' => 3,
                'course' => [
                    'course_name' => 'Business Intellegent'
                ],
                'interest_id' => 2,
                'interest' => [
                    'interest_name' => 'Business'
                ],
            ]
        ]);

        // Find the user by ID
        $certification = $certifications->firstWhere('certification_id', (int)$id);

        // Return the view with either the found user or null if not found
        return view('admin.certification.show_ajax', ['certification' => $certification]);
    }

    public function edit_ajax(string $id)
    {
        // Static data for simulation
        $certifications = collect([
            [
                'certification_id' => 1,
                'certification_name' => 'Google Data Analytics',
                'certification_number' => '001/GOOGLE/DATA-ANALYTICS/2024',
                'certification_date' => '2024-11-04',
                'certification_expired' => '2027-11-04',
                'certification_vendor_id' => 1,
                'vendor' => [
                    'certification_vendor_name' => 'Google'
                ],
                'certification_type_id' => 1,
                'type' => [
                    'certification_type_name' => 'Sertifikasi Profesi'
                ],
                'certification_level_id' => 1,
                'level' => [
                    'certification_level_name' => 'Internasional',
                ],
                'course_id' => 1,
                'course' => [
                    'course_name' => 'Data Analytics'
                ],
                'interest_id' => 1,
                'interest' => [
                    'interest_name' => 'Big Data'
                ],
            ],
            [
                'certification_id' => 2,
                'certification_name' => 'IBM Data Science',
                'certification_number' => '001/IBM/DATA-SCIENCE/2024',
                'certification_date' => '2024-11-05',
                'certification_expired' => '2027-11-05',
                'certification_vendor_id' => 2,
                'vendor' => [
                    'certification_vendor_name' => 'IBM'
                ],
                'certification_type_id' => 1,
                'type' => [
                    'certification_type_name' => 'Sertifikasi Profesi'
                ],
                'certification_level_id' => 1,
                'level' => [
                    'certification_level_name' => 'Internasional',
                ],
                'course_id' => 2,
                'course' => [
                    'course_name' => 'Data Science'
                ],
                'interest_id' => 1,
                'interest' => [
                    'interest_name' => 'Big Data'
                ],
            ],
            [
                'certification_id' => 3,
                'certification_name' => 'Program Improvement Business',
                'certification_number' => '001/UNIVERSITYOFSYDNEY/BUSINESS/2024',
                'certification_date' => '2024-11-06',
                'certification_expired' => '2027-11-06',
                'certification_vendor_id' => 3,
                'vendor' => [
                    'certification_vendor_name' => 'The University Of Sydney'
                ],
                'certification_type_id' => 1,
                'type' => [
                    'certification_type_name' => 'Sertifikasi Profesi'
                ],
                'certification_level_id' => 1,
                'level' => [
                    'certification_level_name' => 'Internasional',
                ],
                'course_id' => 3,
                'course' => [
                    'course_name' => 'Business Intellegent'
                ],
                'interest_id' => 2,
                'interest' => [
                    'interest_name' => 'Business'
                ],
            ]
        ]);

        $vendor = collect([
            ['certification_vendor_id' => 1, 'certification_vendor_name' => 'Google'],
            ['certification_vendor_id' => 2, 'certification_vendor_name' => 'BNSP'],
            ['certification_vendor_id' => 3, 'certification_vendor_name' => 'IBM'],
        ]);

        $type = collect([
            ['certification_type_id' => 1, 'certification_type_name' => 'Sertifikasi Profesi'],
            ['certification_type_id' => 2, 'certification_type_name' => 'Sertifikasi Profesi'],
        ]);

        // Data statis untuk level
        $level = collect([
            ['certification_level_id' => 1, 'certification_level_name' => 'Internasional'],
            ['certification_level_id' => 2, 'certification_level_name' => 'Nasional'],
            ['certification_level_id' => 3, 'certification_level_name' => 'Regional'],
        ]);

        $course = collect([
            ['course_id' => 1, 'course_name' => 'Big Data'],
            ['course_id' => 2, 'course_name' => 'Data Science'],
            ['course_id' => 3, 'course_name' => 'Business Intellegent'],
        ]);

        $interest = collect([
            ['interest_id' => 1, 'interest_name' => 'Data Analytics'],
            ['interest_id' => 2, 'interest_name' => 'Business'],
            ['interest_id' => 3, 'interest_name' => 'Development'],
        ]);


        // Menemukan pengguna by ID
        $certification = $certifications->firstWhere('certification_id', (int)$id);

        // Mengembalikan view penguna dan level
        return view('admin.certification.edit_ajax', ['certification' => $certification, 'vendor' => $vendor, 'type' => $type, 'level' => $level, 'course' => $course, 'interest' => $interest]);
    }

    public function update_ajax(Request $request, $id)
    {
        // Update data pengguna disini
        return response()->json([
            'status' => true,
            'message' => 'Data Sertifikasi Berhasil Diupdate (Simulasi)',
            'redirect' => url('/certification') // URL tujuan redirect
        ]);
    }

    public function confirm_ajax(string $id)
    {
        // Static data for simulation
        $certifications = collect([
            [
                'certification_id' => 1,
                'certification_name' => 'Google Data Analytics',
                'certification_number' => '001/GOOGLE/DATA-ANALYTICS/2024',
                'certification_date' => '2024-11-04',
                'certification_expired' => '2027-11-04',
                'certification_vendor_id' => 1,
                'vendor' => [
                    'certification_vendor_name' => 'Google'
                ],
                'certification_type_id' => 1,
                'type' => [
                    'certification_type_name' => 'Sertifikasi Profesi'
                ],
                'certification_level_id' => 1,
                'level' => [
                    'certification_level_name' => 'Internasional',
                ],
                'course_id' => 1,
                'course' => [
                    'course_name' => 'Data Analytics'
                ],
                'interest_id' => 1,
                'interest' => [
                    'interest_name' => 'Big Data'
                ],
            ],
            [
                'certification_id' => 2,
                'certification_name' => 'IBM Data Science',
                'certification_number' => '001/IBM/DATA-SCIENCE/2024',
                'certification_date' => '2024-11-05',
                'certification_expired' => '2027-11-05',
                'certification_vendor_id' => 2,
                'vendor' => [
                    'certification_vendor_name' => 'IBM'
                ],
                'certification_type_id' => 1,
                'type' => [
                    'certification_type_name' => 'Sertifikasi Profesi'
                ],
                'certification_level_id' => 1,
                'level' => [
                    'certification_level_name' => 'Internasional',
                ],
                'course_id' => 2,
                'course' => [
                    'course_name' => 'Data Science'
                ],
                'interest_id' => 1,
                'interest' => [
                    'interest_name' => 'Big Data'
                ],
            ],
            [
                'certification_id' => 3,
                'certification_name' => 'Program Improvement Business',
                'certification_number' => '001/UNIVERSITYOFSYDNEY/BUSINESS/2024',
                'certification_date' => '2024-11-06',
                'certification_expired' => '2027-11-06',
                'certification_vendor_id' => 3,
                'vendor' => [
                    'certification_vendor_name' => 'The University Of Sydney'
                ],
                'certification_type_id' => 1,
                'type' => [
                    'certification_type_name' => 'Sertifikasi Profesi'
                ],
                'certification_level_id' => 1,
                'level' => [
                    'certification_level_name' => 'Internasional',
                ],
                'course_id' => 3,
                'course' => [
                    'course_name' => 'Business Intellegent'
                ],
                'interest_id' => 2,
                'interest' => [
                    'interest_name' => 'Business'
                ],
            ]
        ]);

        $certification = $certifications->firstWhere('certification_id', (int)$id);

        // Mengembalikan view penguna dan level
        return view('admin.certification.confirm_ajax', ['certification' => $certification]);
    }

    public function delete_ajax(Request $request, $id)
    {
        // Hapus data pengguna disini
        return response()->json([
            'status' => true,
            'message' => 'Data Sertifikasi Berhasil Dihapus (Simulasi)',
            'redirect' => url('/certification') // URL tujuan redirect
        ]);

    }
}
