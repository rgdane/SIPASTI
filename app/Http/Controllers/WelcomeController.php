<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    private $trainings;

    public function __construct()
    {
        // Initialize static data in constructor
        $this->trainings = collect([
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
                'training_type_id' => 1,
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
                'training_type_id' => 2,
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
                'training_type_id' => 2,
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
    }

    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Beranda',
            'list' => ['Beranda']
        ];

        $activeMenu = 'dashboard';

        return view('welcome', [
            'breadcrumb' => $breadcrumb, 
            'activeMenu' => $activeMenu,
            'trainings' => $this->trainings
        ]);
    }

    public function show(string $id)
    {
        $training = $this->trainings->firstWhere('training_id', (int)$id);

        if (!$training) {
            abort(404, 'Training not found');
        }

        $breadcrumb = (object) [
            'title' => 'Detail Pelatihan',
            'list' => ['Beranda', 'Detail Pelatihan']
        ];

        $activeMenu = 'dashboard';

        return view('welcome', [
            'training' => $training,
            'breadcrumb' => $breadcrumb,
            'activeMenu' => $activeMenu
        ]);
    }

    public function getTrainingDetails(string $id)
    {
        $training = $this->trainings->firstWhere('training_id', (int)$id);

        if (!$training) {
            return response()->json(['error' => 'Training not found'], 404);
        }

        return view('admin.training.show', ['training' => $training])->render();
    }
}
