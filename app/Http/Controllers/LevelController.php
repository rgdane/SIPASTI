<?php

namespace App\Http\Controllers;

use App\Models\UserTypeModel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Yajra\DataTables\DataTables;

class UserTypeController extends Controller
{
<<<<<<< HEAD
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Jenis Pengguna',
            'list' => ['Home', 'Jenis']
        ];

        $page = (object) [
            'title' => 'Manajemen Jenis Pengguna'
=======
    public function index(){
        $breadcrumb = (object)[
            'title' => 'Daftar Jenis Pengguna',
            'list' => ['Home', 'Jenis Pengguna']
        ];
    
        $page = (object)[
            'title' => 'Daftar user_type yang terdaftar dalam sistem'
>>>>>>> 3fa3b4cb54bb0ea3bef77bbce5a74c02fcc99eeb
        ];
    
        $activeMenu = 'user_type'; //set menu yang sedang aktif

<<<<<<< HEAD

        $activeMenu = 'userType';

        return view('admin.user_type.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
=======
        $user_type = UserTypeModel::all(); //ambil data user_type unttuk filter user_type
    
        return view('user_type.index',['breadcrumb'=>$breadcrumb, 'page' => $page, 'user_type' => $user_type,'activeMenu'=>$activeMenu]);
>>>>>>> 3fa3b4cb54bb0ea3bef77bbce5a74c02fcc99eeb
    }
    
    // Ambil data user_type dalam bentuk json untuk datatables
    public function list(Request $request)
    {
        $user_types = UserTypeModel::select('user_type_id', 'user_type_kode', 'user_type_nama')
            ->with('user_type');
        
        //Filter data user_type berdasarkan user_type_id
        if ($request->user_type_id) {
            $user_types->where('user_type_id', $request->user_type_id);
        }

        return DataTables::of($user_types)
        // menambahkan kolom index / no urut (default user_type_nama kolom: DT_RowIndex)
        ->addIndexColumn()
        ->addColumn('aksi', function ($user_type) { // menambahkan kolom aksi
            // $btn = '<a href="'.url('/user_type/' . $user_type->user_type_id).'" class="btn btn-info btn-sm">Detail</a> ';
            // $btn .= '<a href="'.url('/user_type/' . $user_type->user_type_id. '/edit').'" class="btn btn-warning btn-sm">Edit</a> ';
            // $btn .= '<form class="d-inline-block" method="POST" action="'. url('/user_type/'.$user_type->user_type_id).'">'
            // . csrf_field() . method_field('DELETE') .
            // '<button type="submit" class="btn btn-danger btn-sm" onclick="return
            // confirm(\'Apakah Anda yakit menghapus data ini?\');">Hapus</button></form>';
            $btn  = '<button onclick="modalAction(\''.url('/user_type/' . $user_type->user_type_id . '/show_ajax').'\')" class="btn btn-info btn-sm">Detail</button> '; 
            $btn .= '<button onclick="modalAction(\''.url('/user_type/' . $user_type->user_type_id . '/edit_ajax').'\')" class="btn btn-warning btn-sm">Edit</button> '; 
            $btn .= '<button onclick="modalAction(\''.url('/user_type/' . $user_type->user_type_id . '/delete_ajax').'\')"  class="btn btn-danger btn-sm">Hapus</button> ';
            return $btn;
        })
        ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
        ->make(true);
    }

    public function createAjax(){
        $user_type = UserTypeModel::select('user_type_id', 'user_type_nama')->get();
        return view('user_type.create_ajax')->with('user_type', $user_type);
    }
            public function storeAjax(Request $request){
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'user_type_kode' => 'required|string|min:3|max:10|unique:m_user_type,user_type_kode',
                'user_type_nama' => 'required|string|max:100',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(),
                ]);
            }
            UserTypeModel::create($request->all());
            return response()->json([
                'status' => true,
                'message' => 'Data user berhasil disimpan'
            ]);
        }
        redirect('/');
    }

        public function showAjax(string $id){
            $user_type = UserTypeModel::find($id);
            return view('user_type.show_ajax', ['user_type' => $user_type]);
        }

        public function editAjax(string $id){
            $user_type = UserTypeModel::find($id);
            return view('user_type.edit_ajax', ['user_type' => $user_type]);
        }
        
        Public function updateAjax(Request $request, $id){ 
            // cek apakah request dari ajax 
            // dd('sdgjasd');
            if ($request->ajax()|| $request->wantsJson()) { 
                $rules = [ 
                    'user_type_kode' => 'required|string|min:3|max:10|unique:m_user_type,user_type_kode,'.$id.',user_type_id', 
                    'user_type_nama'     => 'required|max:100', 
                ]; 
                $validator = Validator::make($request->all(), $rules); 

                if ($validator->fails()) { 
                    return response()->json([ 
                        'status'   => false,    
                        'message'  => 'Validasi gagal.', 
                        'msgField' => $validator->errors()  
                    ]); 
                } 

                $check = UserTypeModel::find($id); 
                if ($check) { 
                    if(!$request->filled('password') ){  
                        $request->request->remove('password'); 
                    }
                    $check->update($request->all()); 
                    return response()->json([ 
                        'status'  => true, 
                        'message' => 'Data berhasil diupdate' 
                    ]); 
                } else{ 
                    return response()->json([ 
                        'status'  => false, 
                        'message' => 'Data tidak ditemukan' 
                    ]); 
                } 
            } 
            return redirect('/'); 
        } 
        public function confirmAjax(string $id){
            $user_type = UserTypeModel::find($id);
            return view('user_type.confirm_ajax', ['user_type' => $user_type]);
        }
        public function deleteAjax(Request $request, $id){
            if($request -> ajax() || $request -> wantsJson()){
                $user_type = UserTypeModel::find($id);
                if($user_type){
                    $user_type -> delete();
                    return response() -> json([
                        'status' => true,
                        'message' => 'Data berhasil dihapus'
                    ]);
                } else {
                    return response() -> json([
                        'status' => false,
                        'message' => 'data tidak ditemukan'
                    ]);
                }
            }
            return redirect('/');
        }
    

    //Menampilkan halaman form tambah user_type
    public function create(){
        $breadcrumb = (object)[
            'title' => 'Tambah UserType',
            'list' => ['Home', 'UserType', 'Tambah']
        ];
        $page = (object)[
            'title' => 'Tambah user_type baru'
        ];
        $user_type = UserTypeModel::all(); //ambil data user_type untuk ditampilkan di form
        $activeMenu = 'user_type'; //set menu yang sedang aktif
        return view('user_type.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'user_type' => $user_type, 'activeMenu' => $activeMenu]);
    }

    //Menyimpan data user_type baru
    public function store(Request $request){
        $request -> validate([
            //user_type_kode harus diisi, berupa string, minimal 3 karakter, dan bernilai unik di tabel m_user_type kolom user_type_kode
            'user_type_kode' => 'required|string|min:3|unique:m_user_type,user_type_kode',
            'user_type_nama' => 'required|string|max:100', //user_type_nama harus diisi, berupa string, dan maksimal 100 karakter
            // 'user_type_id' => 'required|integer'
        ]);
<<<<<<< HEAD

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
        return view('admin.user_type.create');
    }

    public function store_ajax(Request $request)
    {
        // Simulasi respons sukses tanpa menyimpan data
        return response()->json([
            'status' => true,
            'message' => 'Data Jenis Pengguna Berhasil Ditambahkan (Simulasi)',
            'redirect' => url('/user') // URL tujuan redirect
=======
        UserTypeModel::create([
            'user_type_kode' => $request->user_type_kode,
            'user_type_nama' => $request -> user_type_nama,
            'user_type_id' => $request->user_type_id
>>>>>>> 3fa3b4cb54bb0ea3bef77bbce5a74c02fcc99eeb
        ]);
        return redirect('/user_type') -> with('success', 'Data user_type berhasil disimpan');
    }
    
    //Menampilkan detail user_type
    public function show(String $id){
        $user_type = UserTypeModel::with('user_type') -> find($id);
        $breadcrumb = (object)[
            'title' => 'Detail UserType',
            'list' => ['Home', 'UserType', 'Detail']
        ];
        $page = (object)[
            'title' => 'Detail user_type'
        ];
        $activeMenu = 'user_type'; //set menu yang sedang aktif
        return view('user_type.show', ['breadcrumb' => $breadcrumb, 'page'=>$page, 'user_type'=>$user_type, 'activeMenu'=>$activeMenu]);
    }

    //Menampilkan halaman form edit user_type
    public function edit(string $id){
        $user_type = UserTypeModel::find($id);
        $breadcrumb = (object)[
            'title' => 'Edit user_type',
            'list' => ['Home', 'UserType', 'Edit']
        ];
        $page = (object)[
            'title' => 'Edit UserType'
        ];
        $activeMenu = 'user_type';
        return view ('user_type.edit', ['breadcrumb'=>$breadcrumb, 'page'=>$page, 'user_type'=>$user_type, 'activeMenu'=>$activeMenu]);
    }
    //Menyimpan perubahan data user_type
    public function update(Request $request, string $id)
    {
        $request->validate([
            'user_type_kode' => 'required|string|min:3|unique:m_user_type,user_type_kode,' . $id . ',user_type_id',
            'user_type_nama' => 'required|string|max:100',
            // 'user_type_id' => 'required|integer'
        ]);
<<<<<<< HEAD

        // Find the user by ID
        $level = $levels->firstWhere('level_id', (int)$id);

        // Return the view with either the found user or null if not found
        return view('admin.user_type.show_ajax', ['level' => $level]);
=======
        UserTypeModel::find($id)->update([
            'user_type_kode' => $request->user_type_kode,
            'user_type_nama' => $request->user_type_nama,
            'user_type_id' => $request->user_type_id
        ]);
        return redirect('/user_type')->with('success' . "data user_type berhasil diubah");
>>>>>>> 3fa3b4cb54bb0ea3bef77bbce5a74c02fcc99eeb
    }

    //Mengapus data user_type
    public function destroy(string $id)
    {
<<<<<<< HEAD
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
        return view('admin.user_type.edit_ajax', ['level' => $level]);
=======
        $check = UserTypeModel::find($id);
        if (!$check) {
            return redirect('/user_type')->with('error','Data user_type tidak ditemukan');
        }
        try{
            UserTypeModel::destroy($id);
            return redirect('/user_type')->with('success', 'Data user_type berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/user_type')->with('error','Data user gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
>>>>>>> 3fa3b4cb54bb0ea3bef77bbce5a74c02fcc99eeb
    }

    public function import()
    {
<<<<<<< HEAD
        // Update data level disini
        return response()->json([
            'status' => true,
            'message' => 'Data Jenis Pengguna Berhasil Diupdate (Simulasi)',
            'redirect' => url('/level') // URL tujuan redirect
        ]);
=======
    return view('user_type.import');
>>>>>>> 3fa3b4cb54bb0ea3bef77bbce5a74c02fcc99eeb
    }

    public function import_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            // Validasi file harus xlsx dan maksimal 1MB
            $rules = [
                'file_user_type' => ['required', 'mimes:xlsx', 'max:1024']
            ];

            $validator = Validator::make($request->all(), $rules);

<<<<<<< HEAD
        return view('admin.user_type.confirm_ajax', ['level' => $level]);
=======
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            // Ambil file dari request
            $file = $request->file('file_user_type');

            // Load reader file excel
            $reader = IOFactory::createReader('Xlsx');
            $reader->setReadDataOnly(true);

            // Load file excel dan ambil sheet yang aktif
            $spreadsheet = $reader->load($file->getRealPath());
            $sheet = $spreadsheet->getActiveSheet();

            // Ambil data excel
            $data = $sheet->toArray(null, false, true, true);
            $insert = [];

            // Jika data lebih dari 1 baris
            if (count($data) > 1) {
                foreach ($data as $baris => $value) {
                    // Baris pertama adalah header, maka lewati
                    if ($baris > 1) {
                        $insert[] = [
                            'user_type_kode' => $value['A'],
                            'user_type_nama' => $value['B'],
                            'created_at' => now(),
                        ];
                    }
                }

                // Insert data ke database, jika data sudah ada, maka diabaikan
                if (count($insert) > 0) {
                    UserTypeModel::insertOrIgnore($insert);
                }

                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil diimport'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Tidak ada data yang diimport'
                ]);
            }
        }
        return redirect('/user_type');
>>>>>>> 3fa3b4cb54bb0ea3bef77bbce5a74c02fcc99eeb
    }

    public function export_excel()
    {
<<<<<<< HEAD
        // Hapus data pengguna disini
        return response()->json([
            'status' => true,
            'message' => 'Data Jenis Pengguna Berhasil Dihapus (Simulasi)',
            'redirect' => url('/user') // URL tujuan redirect
        ]);
=======
        // ambil data user_type yang akan di export
        $user_type = UserTypeModel::select('user_type_kode','user_type_nama')
                                    ->get();
        //load library excel
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet(); // ambil sheet yang aktif
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Kode UserType');
        $sheet->setCellValue('C1', 'Nama UserType');
        $sheet->getStyle('A1:C1')->getFont()->setBold(true); //bold header
        
        $no=1; //nomor data dimulai dari 1
        $baris = 2;
        foreach ($user_type as $key => $value){
            $sheet->setCellValue('A' .$baris, $no);
            $sheet->setCellValue('B' .$baris, $value->user_type_kode);
            $sheet->setCellValue('C' .$baris, $value->user_type_nama);
            $baris++;
            $no++;
        }
        foreach(range('A','C') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true); //set auto size untuk kolom
        }
        
        $sheet->setTitle('Data UserType'); //set title sheet
        $writter = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Data UserType ' .date('Y-m-d H:i:s') .' .xlsx';
        
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0'); 
        header('Cache-Control: max-age=1');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') .' GMT');
        header('Cache-Control: cache, must-revalidate');
        header('Pragma: public');
        $writter->save('php://output');
        exit;
    } //end function export_excel
>>>>>>> 3fa3b4cb54bb0ea3bef77bbce5a74c02fcc99eeb

    public function export_pdf(){
        $user_type = UserTypeModel::select('user_type_kode','user_type_nama')
        ->orderBy('user_type_kode')
        ->get();
        $pdf = Pdf::loadView('user_type.export_pdf', ['user_type' => $user_type]);
        $pdf->setPaper('a4', 'portrait'); //set ukuran kertas dan orientasi
        $pdf->setOption("isRemoteEnabled", true); // set true jika ada gambar dari url
        $pdf->render();
        return $pdf->stream('Data UserType' .date ('Y-m-d H:i:s'). '.pdf');
    }
}