<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TrainingController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Pelatihan',
            'list' => ['Home', 'Pelatihan']
        ];

        $page = (object) [
            'title' => 'Manajemen Pelatihan',
        ];

        $activeMenu = 'training';

        return view('admin.training.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }

    public function list(Request $request)
    {
        $trainings = collect([
            [
                'training_id' => 1,
                'training_name' => 'Pelatihan Artificial Intellegent',
                'training_date' => '2024-12-02 08:00:00',
                'training_location' => 'JL. Soekarno Hatta, Graha Polinema',
                'training_cost' => '1500000',
                'training_vendor_id' => 1,
                'vendor' => [
                    'training_vendor_name' => 'Google'
                ],
                'training_type_id' => 1, // typo corrected here
                'type' => [
                    'training_type_name' => 'Mandiri'
                ],
                'training_quota' => 50,
                'course_id' => 1,
                'course' => [
                    'course_name' => 'Artificial Intellegent'
                ],
                'interest_id' => 3,
                'interest' => [
                    'interest_name' => 'Teknologi Informasi'
                ],
            ],
            [
                'training_id' => 2,
                'training_name' => 'Pelatihan Data Science',
                'training_date' => '2024-12-03 08:00:00',
                'training_location' => 'Universitas Brawijaya',
                'training_cost' => '2000000',
                'training_vendor_id' => 2,
                'vendor' => [
                    'training_vendor_name' => 'IBM'
                ],
                'training_type_id' => 2, // typo corrected here
                'type' => [
                    'training_type_name' => 'Non-Mandiri'
                ],
                'training_quota' => 100,
                'course_id' => 2,
                'course' => [
                    'course_name' => 'Data Science'
                ],
                'interest_id' => 3,
                'interest' => [
                    'interest_name' => 'Teknologi Informasi'
                ]
            ],
            [
                'training_id' => 3,
                'training_name' => 'Pelatihan Java Development',
                'training_date' => '2024-12-04 08:00:00',
                'training_location' => 'Dome Universitas Muhammadiyah Malang',
                'training_cost' => '2000000',
                'training_vendor_id' => 3,
                'vendor' => [
                    'training_vendor_name' => 'Microsoft'
                ],
                'training_type_id' => 2, // typo corrected here
                'type' => [
                    'training_type_name' => 'Non-Mandiri'
                ],
                'training_quota' => 100,
                'course_id' => 3,
                'course' => [
                    'course_name' => 'Pemrograman Dasar'
                ],
                'interest_id' => 3,
                'interest' => [
                    'interest_name' => 'Teknologi Informasi'
                ]
            ],
        ]);

        if ($request->training_vendor_id) {
            $trainings = $trainings->where('training_vendor_id', $request->training_vendor_id);
        }

        return DataTables::of($trainings)
            ->addIndexColumn()
            ->addColumn('show_url', function ($training) {
                return url('/training/' . $training['training_id'] . '/show');
            })
            ->addColumn('edit_url', function ($training) {
                return url('/training/' . $training['training_id'] . '/edit');
            })
            ->addColumn('delete_url', function ($training) {
                return url('/training/' . $training['training_id'] . '/delete');
            })
            ->make(true);
    }

    public function create()
    {
        return view('admin.training.create');
    }

    public function store(Request $request)
    {
        return response()->json([
            'status' => true,
            'message' => 'Data Pelatihan Berhasil Ditambahkan',
        ]);

        redirect('/training');
    }


    public function show(string $id)
    {
        $trainings = collect([
            [
                'training_id' => 1,
                'training_name' => 'Pelatihan Artificial Intellegent',
                'training_date' => '2024-12-02 08:00:00',
                'training_location' => 'JL. Soekarno Hatta, Graha Polinema',
                'training_cost' => '1500000',
                'training_vendor_id' => 1,
                'vendor' => [
                    'training_vendor_name' => 'Google'
                ],
                'training_type_id' => 1, // typo corrected here
                'type' => [
                    'training_type_name' => 'Mandiri'
                ],
                'training_quota' => 50,
                'course_id' => 1,
                'course' => [
                    'course_name' => 'Artificial Intellegent'
                ],
                'interest_id' => 3,
                'interest' => [
                    'interest_name' => 'Teknologi Informasi'
                ],
            ],
            [
                'training_id' => 2,
                'training_name' => 'Pelatihan Data Science',
                'training_date' => '2024-12-03 08:00:00',
                'training_location' => 'Universitas Brawijaya',
                'training_cost' => '2000000',
                'training_vendor_id' => 2,
                'vendor' => [
                    'training_vendor_name' => 'IBM'
                ],
                'training_type_id' => 2, // typo corrected here
                'type' => [
                    'training_type_name' => 'Non-Mandiri'
                ],
                'training_quota' => 100,
                'course_id' => 2,
                'course' => [
                    'course_name' => 'Data Science'
                ],
                'interest_id' => 3,
                'interest' => [
                    'interest_name' => 'Teknologi Informasi'
                ]
            ],
            [
                'training_id' => 3,
                'training_name' => 'Pelatihan Java Development',
                'training_date' => '2024-12-04 08:00:00',
                'training_location' => 'Dome Universitas Muhammadiyah Malang',
                'training_cost' => '2000000',
                'training_vendor_id' => 3,
                'vendor' => [
                    'training_vendor_name' => 'Microsoft'
                ],
                'training_type_id' => 2, // typo corrected here
                'type' => [
                    'training_type_name' => 'Non-Mandiri'
                ],
                'training_quota' => 100,
                'course_id' => 3,
                'course' => [
                    'course_name' => 'Pemrograman Dasar'
                ],
                'interest_id' => 3,
                'interest' => [
                    'interest_name' => 'Teknologi Informasi'
                ]
            ],
        ]);

        $training = $trainings->firstWhere('training_id', (int)$id);

        return view('admin.training.show', ['training' => $training]);
    }

    public function edit(string $id)
    {
        $trainings = collect([
            [
                'training_id' => 1,
                'training_name' => 'Pelatihan Artificial Intellegent',
                'training_date' => '2024-12-02 08:00:00',
                'training_location' => 'JL. Soekarno Hatta, Graha Polinema',
                'training_cost' => '1500000',
                'training_vendor_id' => 1,
                'vendor' => [
                    'training_vendor_name' => 'Google'
                ],
                'training_type_id' => 1, // typo corrected here
                'type' => [
                    'training_type_name' => 'Mandiri'
                ],
                'training_quota' => 50,
                'course_id' => 1,
                'course' => [
                    'course_name' => 'Artificial Intellegent'
                ],
                'interest_id' => 3,
                'interest' => [
                    'interest_name' => 'Teknologi Informasi'
                ],
            ],
            [
                'training_id' => 2,
                'training_name' => 'Pelatihan Data Science',
                'training_date' => '2024-12-03 08:00:00',
                'training_location' => 'Universitas Brawijaya',
                'training_cost' => '2000000',
                'training_vendor_id' => 2,
                'vendor' => [
                    'training_vendor_name' => 'IBM'
                ],
                'training_type_id' => 2, // typo corrected here
                'type' => [
                    'training_type_name' => 'Non-Mandiri'
                ],
                'training_quota' => 100,
                'course_id' => 2,
                'course' => [
                    'course_name' => 'Data Science'
                ],
                'interest_id' => 3,
                'interest' => [
                    'interest_name' => 'Teknologi Informasi'
                ]
            ],
            [
                'training_id' => 3,
                'training_name' => 'Pelatihan Java Development',
                'training_date' => '2024-12-04 08:00:00',
                'training_location' => 'Dome Universitas Muhammadiyah Malang',
                'training_cost' => '2000000',
                'training_vendor_id' => 3,
                'vendor' => [
                    'training_vendor_name' => 'Microsoft'
                ],
                'training_type_id' => 2, // typo corrected here
                'type' => [
                    'training_type_name' => 'Non-Mandiri'
                ],
                'training_quota' => 100,
                'course_id' => 3,
                'course' => [
                    'course_name' => 'Pemrograman Dasar'
                ],
                'interest_id' => 3,
                'interest' => [
                    'interest_name' => 'Teknologi Informasi'
                ]
            ],
        ]);

        $vendor = collect([
            ['training_vendor_id' => 1, 'training_vendor_name' => 'Google'],
            ['training_vendor_id' => 2, 'training_vendor_name' => 'IBM'],
            ['training_vendor_id' => 3, 'training_vendor_name' => 'Microsoft'],
        ]);
        $type = collect([
            ['training_type_id' => 1, 'training_type_name' => 'Mandiri'],
            ['training_type_id' => 2, 'training_type_name' => 'Non-Mandiri'],
        ]);
        $course = collect([
            ['course_id' => 1, 'course_name' => 'Artificial Intellegent'],
            ['course_id' => 2, 'course_name' => 'Data Science'],
            ['course_id' => 3, 'course_name' => 'Pemrograman Dasar'],
        ]);
        $interest = collect([
            ['interest_id' => 1, 'interest_name' => 'Data Analytics'],
            ['interest_id' => 2, 'interest_name' => 'Business'],
            ['interest_id' => 3, 'interest_name' => 'Teknologi Informasi'],
        ]);

        $training = $trainings->firstWhere('training_id', (int)$id);

        return view('admin.training.edit', ['training' => $training, 'vendor' => $vendor, 'type' => $type, 'course' => $course, 'interest' => $interest]);
    }


    public function update(Request $request, $id)
    {
        return response()->json([
            'status' => true,
            'message' => 'Data Pelatihan Berhasil Diupdate',
            'redirect' => url('/training')
        ]);
    }

    public function confirm(string $id)
    {
        $trainings = collect([
            [
                'training_id' => 1,
                'training_name' => 'Pelatihan Artificial Intellegent',
                'training_date' => '2024-12-02 08:00:00',
                'training_location' => 'JL. Soekarno Hatta, Graha Polinema',
                'training_cost' => '1500000',
                'training_vendor_id' => 1,
                'vendor' => [
                    'training_vendor_name' => 'Google'
                ],
                'training_type_id' => 1, // typo corrected here
                'type' => [
                    'training_type_name' => 'Mandiri'
                ],
                'training_quota' => 50,
                'course_id' => 1,
                'course' => [
                    'course_name' => 'Artificial Intellegent'
                ],
                'interest_id' => 3,
                'interest' => [
                    'interest_name' => 'Teknologi Informasi'
                ],
            ],
            [
                'training_id' => 2,
                'training_name' => 'Pelatihan Data Science',
                'training_date' => '2024-12-03 08:00:00',
                'training_location' => 'Universitas Brawijaya',
                'training_cost' => '2000000',
                'training_vendor_id' => 2,
                'vendor' => [
                    'training_vendor_name' => 'IBM'
                ],
                'training_type_id' => 2, // typo corrected here
                'type' => [
                    'training_type_name' => 'Non-Mandiri'
                ],
                'training_quota' => 100,
                'course_id' => 2,
                'course' => [
                    'course_name' => 'Data Science'
                ],
                'interest_id' => 3,
                'interest' => [
                    'interest_name' => 'Teknologi Informasi'
                ]
            ],
            [
                'training_id' => 3,
                'training_name' => 'Pelatihan Java Development',
                'training_date' => '2024-12-04 08:00:00',
                'training_location' => 'Dome Universitas Muhammadiyah Malang',
                'training_cost' => '2000000',
                'training_vendor_id' => 3,
                'vendor' => [
                    'training_vendor_name' => 'Microsoft'
                ],
                'training_type_id' => 2, // typo corrected here
                'type' => [
                    'training_type_name' => 'Non-Mandiri'
                ],
                'training_quota' => 100,
                'course_id' => 3,
                'course' => [
                    'course_name' => 'Pemrograman Dasar'
                ],
                'interest_id' => 3,
                'interest' => [
                    'interest_name' => 'Teknologi Informasi'
                ]
            ],
        ]);

        $training = $trainings->firstWhere('training_id', (int)$id);

        return view('admin.training.confirm', ['training' => $training]);
    }

    public function delete(Request $request, $id)
    {
        return response()->json([
            'status' => true,
            'message' => 'Data Pelatihan Berhasil Dihapus',
            'redirect' => url('/training')
        ]);
    }
}
