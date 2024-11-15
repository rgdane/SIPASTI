<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CourseController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Mata Kuliah',
            'list' => ['Home', 'Mata Kuliah']
        ];

        $page = (object) [
            'title' => 'Manajemen Data Mata Kuliah',
        ];

        $activeMenu = 'course';

        return view('admin.course.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 
        'activeMenu' => $activeMenu]);
    }

    public function list()
    {
        $courses = collect([
            [
                'course_id' => 1,
                'course_name' => 'Pemrograman Web',
                'course_code' => 'PW',
            ],
            [
                'course_id' => 2,
                'course_name' => 'Pemrograman Mobile',
                'course_code' => 'PM',
            ],
            [
                'course_id' => 3,
                'course_name' => "Workshop",
                'course_code' => 'WP'
            ]
        ]);

        return DataTables::of($courses)
        ->addIndexColumn() // Add index column for row number
        ->addColumn('aksi', function ($course) { // Add action column
            $btn = '<button onclick="modalAction(\'' . url('/course/' . $course['course_id'] . '/show') . '\')" class="btn btn-info btn-sm">Detail</button> ';
            $btn .= '<button onclick="modalAction(\'' . url('/course/' . $course['course_id'] . '/edit') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
            $btn .= '<button onclick="modalAction(\'' . url('/course/' . $course['course_id'] . '/delete') . '\')" class="btn btn-danger btn-sm">Hapus</button>';
            return $btn;
        })
        ->rawColumns(['aksi']) // Specify that 'aksi' column contains HTML
        ->make(true);
    }

    public function create()
    {
        return view('admin.course.create');
    }

    public function store()
    {
        // Simulasi respons sukses tanpa menyimpan data
        return response()->json([
            'status' => true,
            'message' => 'Data Bidang Minat Berhasil Ditambahkan (Simulasi)',
            'redirect' => url('/course') // URL tujuan redirect
        ]);
    }

    public function show(string $id)
    {
        $courses = collect([
            [
                'course_id' => 1,
                'course_name' => 'Pemrograman Web',
                'course_code' => 'PW',
            ],
            [
                'course_id' => 2,
                'course_name' => 'Pemrograman Mobile',
                'course_code' => 'PM',
            ],
            [
                'course_id' => 3,
                'course_name' => "Workshop",
                'course_code' => 'WP'
            ]
        ]);

        $course = $courses->firstWhere('course_id', (int)$id);

        return view('admin.course.show', ['course' => $course]);
    }

    public function edit(string $id)
    {
        $courses = collect([
            [
                'course_id' => 1,
                'course_name' => 'Pemrograman Web',
                'course_code' => 'PW',
            ],
            [
                'course_id' => 2,
                'course_name' => 'Pemrograman Mobile',
                'course_code' => 'PM',
            ],
            [
                'course_id' => 3,
                'course_name' => "Workshop",
                'course_code' => 'WP'
            ]
        ]);

        $course = $courses->firstWhere('course_id', (int)$id);

        return view('admin.course.edit', ['course' => $course]);
    }

    public function update(Request $request, $id)
    {
        // Simulasi respons sukses tanpa menyimpan data
        return response()->json([
            'status' => true,
            'message' => 'Data Mata Kuliah Berhasil Diupdate (Simulasi)',
            'redirect' => url('/course') // URL tujuan redirect
        ]);
    }

    public function confirm(string $id)
    {
        $courses = collect([
            [
                'course_id' => 1,
                'course_name' => 'Pemrograman Web',
                'course_code' => 'PW',
            ],
            [
                'course_id' => 2,
                'course_name' => 'Pemrograman Mobile',
                'course_code' => 'PM',
            ],
            [
                'course_id' => 3,
                'course_name' => "Workshop",
                'course_code' => 'WP'
            ]
        ]);

        $course = $courses->firstWhere('course_id', (int)$id);

        return view('admin.course.confirm', ['course' => $course]);
    }

    public function delete()
    {
        // Hapus data pengguna disini
        return response()->json([
            'status' => true,
            'message' => 'Data Mata Kuliah Berhasil Dihapus (Simulasi)',
            'redirect' => url('/course') // URL tujuan redirect
        ]);
    }
}
