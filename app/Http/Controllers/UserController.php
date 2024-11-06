<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar User',
            'list' => ['Home', 'User']
        ];

        $page = (object) [
            'title' => 'Daftar user yang terdaftar dalam sistem'
        ];


        $activeMenu = 'user';

        return view('admin.user.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }

    public function create_ajax()
    {
        return view('admin.user.create');
    }

    public function store_ajax(Request $request)
    {
        // Simulasi respons sukses tanpa menyimpan data
        return response()->json([
            'status' => true,
            'message' => 'Data Pengguna Berhasil Ditambahkan (Simulasi)',
            'redirect' => url('/user') // URL tujuan redirect
        ]);
    }

    // Ambil data user dalam bentuk json untuk datatables 
    public function list(Request $request)
    {
        // Static data for simulation
        $users = collect([
            [
                'user_id' => 1,
                'username' => '2241760135',
                'nama' => 'Agung Nugroho',
                'level_id' => 1,
                'level' => [
                    'level_nama' => 'Administrator'
                ]
            ],
            [
                'user_id' => 2,
                'username' => '2241760001',
                'nama' => 'Rega Dane',
                'level_id' => 2,
                'level' => [
                    'level_nama' => 'Dosen'
                ]
            ],
            [
                'user_id' => 3,
                'username' => '2241760002',
                'nama' => 'Sheva',
                'level_id' => 3,
                'level' => [
                    'level_nama' => 'Pimpinan'
                ]
            ]
        ]);

        // Filter data user berdasarkan level_id jika ada
        if ($request->level_id) {
            $users = $users->where('level_id', $request->level_id);
        }

        // Return the data in DataTables format
        return DataTables::of($users)
            ->addIndexColumn() // Add index column for row number
            ->addColumn('aksi', function ($user) { // Add action column
                $btn = '<button onclick="modalAction(\'' . url('/user/' . $user['user_id'] . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/user/' . $user['user_id'] . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/user/' . $user['user_id'] . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button>';
                return $btn;
            })
            ->rawColumns(['aksi']) // Specify that 'aksi' column contains HTML
            ->make(true);
    }

    public function show_ajax(string $id)
    {
        $users = collect([
            [
                'user_id' => 1,
                'username' => '2241760135',
                'nama' => 'Agung Nugroho',
                'level_id' => 1,
                'level' => [
                    'level_nama' => 'Administrator'
                ]
            ],
            [
                'user_id' => 2,
                'username' => '2241760001',
                'nama' => 'Rega Dane',
                'level_id' => 2,
                'level' => [
                    'level_nama' => 'Dosen'
                ]
            ],
            [
                'user_id' => 3,
                'username' => '2241760002',
                'nama' => 'Sheva',
                'level_id' => 3,
                'level' => [
                    'level_nama' => 'Pimpinan'
                ]
            ]
        ]);

        // Find the user by ID
        $user = $users->firstWhere('user_id', (int)$id);

        // Return the view with either the found user or null if not found
        return view('admin.user.show_ajax', ['user' => $user]);
    }

    public function edit_ajax(string $id)
    {
        // Data Statis
        $users = collect([
            [
                'user_id' => 1,
                'username' => '2241760135',
                'nama' => 'Agung Nugroho',
                'level_id' => 1,
                'level' => [
                    'level_nama' => 'Administrator'
                ]
            ],
            [
                'user_id' => 2,
                'username' => '2241760001',
                'nama' => 'Rega Dane',
                'level_id' => 2,
                'level' => [
                    'level_nama' => 'Dosen'
                ]
            ],
            [
                'user_id' => 3,
                'username' => '2241760002',
                'nama' => 'Sheva',
                'level_id' => 3,
                'level' => [
                    'level_nama' => 'Pimpinan'
                ]
            ]
        ]);

        // Data statis untuk level
        $level = collect([
            ['level_id' => 1, 'level_nama' => 'Administrator'],
            ['level_id' => 2, 'level_nama' => 'Dosen'],
            ['level_id' => 3, 'level_nama' => 'Pimpinan'],
        ]);

        // Menemukan pengguna by ID
        $user = $users->firstWhere('user_id', (int)$id);

        // Mengembalikan view penguna dan level
        return view('admin.user.edit_ajax', ['user' => $user, 'level' => $level]);
    }

    public function update_ajax(Request $request, $id)
    {
        // Update data pengguna disini
        return response()->json([
            'status' => true,
            'message' => 'Data Pengguna Berhasil Diupdate (Simulasi)',
            'redirect' => url('/user') // URL tujuan redirect
        ]);
    }

    public function confirm_ajax(string $id)
    {
        // Static collection of users for simulation
        $users = collect([
            [
                'user_id' => 1,
                'username' => '2241760135',
                'nama' => 'Agung Nugroho',
                'level_id' => 1,
                'level' => [
                    'level_nama' => 'Administrator'
                ]
            ],
            [
                'user_id' => 2,
                'username' => '2241760001',
                'nama' => 'Rega Dane',
                'level_id' => 2,
                'level' => [
                    'level_nama' => 'Dosen'
                ]
            ],
            [
                'user_id' => 3,
                'username' => '2241760002',
                'nama' => 'Sheva',
                'level_id' => 3,
                'level' => [
                    'level_nama' => 'Pimpinan'
                ]
            ]
        ]);

        // Find user by ID
        $user = $users->firstWhere('user_id', $id);

        return view('admin.user.confirm_ajax', ['user' => $user]);
    }

    public function delete_ajax(Request $request, $id)
    {
        // Hapus data pengguna disini
        return response()->json([
            'status' => true,
            'message' => 'Data Pengguna Berhasil Dihapus (Simulasi)',
            'redirect' => url('/user') // URL tujuan redirect
        ]);

    }

    public function import()
    {
        return view('admin.user.import');
    }

    public function import_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            // Data statis untuk simulasi
            $insert = [
                [
                    'level_id' => 1,
                    'username' => '2241760135',
                    'nama' => 'Agung Nugroho',
                    'password' => 'password123', // Gantilah dengan password yang sesuai
                    'created_at' => now(),
                ],
                [
                    'level_id' => 2,
                    'username' => '2241760001',
                    'nama' => 'Rega Dane',
                    'password' => 'password123', // Gantilah dengan password yang sesuai
                    'created_at' => now(),
                ],
                [
                    'level_id' => 3,
                    'username' => '2241760002',
                    'nama' => 'Sheva',
                    'password' => 'password123', // Gantilah dengan password yang sesuai
                    'created_at' => now(),
                ],
            ];
    
            // Simulasi penyimpanan data ke database
            UserModel::insertOrIgnore($insert);
    
            return response()->json([
                'status' => true,
                'message' => 'Data berhasil diimport'
            ]);
        }
        return redirect('/');
    }
}
