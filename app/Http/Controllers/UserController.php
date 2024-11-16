<?php

namespace App\Http\Controllers;

use App\Models\UserTypeModel;
use Illuminate\Http\Request;
use App\Models\UserModel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{
    public function index(){
        $breadcrumb = (object)[
            'title' => 'Daftar Pengguna',
            'list' => ['Home', 'Pengguna']
        ];
    
        $page = (object)[
            'title' => 'Daftar user yang terdaftar dalam sistem'
        ];
    
        $activeMenu = 'user'; //set menu yang sedang aktif

        $user_type = UserTypeModel::all(); //ambil data user_type untuk filter user_type
    
        return view('admin.user.index',['breadcrumb'=>$breadcrumb, 'page' => $page, 'user_type' => $user_type,'activeMenu'=>$activeMenu]);
    }
    
    public function create()
    {
        $user_type = UserTypeModel::select('user_type_id', 'user_type_name')->get();

        return view('admin.user.create')
            ->with('user_type', $user_type);
    }

    public function store(Request $request) {
        // cek apakah request berupa ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'user_type_id' => 'required|string',
                'username' => 'required|string|min:3|unique:m_user,username',
                'password' => 'required|min:6'
            ];
            
            // use Illuminate\Support\Facades\Validator;
            $validator = Validator::make($request->all(), $rules);
            
            if ($validator->fails()) {
                return response()->json([
                    'status' => false, // response status, false: error/gagal, true: berhasil
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(), // pesan error validasi
                ]);
            }
            
            UserModel::create($request->all());
            return response()->json([
                'status' => true,
                'message' => 'Data pengguna berhasil disimpan'
            ]);
        }
        
        return redirect('/user');
    }

    // Ambil data user dalam bentuk json untuk datatables
    public function list(Request $request)
    {
        $users = UserModel::select('user_id', 'username', 'user_type_id')
        ->with('user_type');
        // Filter data user berdasarkan user_type_id
        if ($request->user_type_id){
        $users->where('user_type_id',$request->user_type_id);
        }
        return DataTables::of($users)
        ->addIndexColumn() // menambahkan kolom index / no urut (default nama kolom:DT_RowIndex)
        ->addColumn('aksi', function ($user) { // menambahkan kolom aksi
            $btn = '<button onclick="modalAction(\''.url('/user/' . $user->user_id .
            '/show').'\')" class="btn btn-info btn-sm">Detail</button> ';
            $btn .= '<button onclick="modalAction(\''.url('/user/' . $user->user_id .
            '/edit').'\')" class="btn btn-warning btn-sm">Edit</button> ';
            $btn .= '<button onclick="modalAction(\''.url('/user/' . $user->user_id .
            '/delete').'\')" class="btn btn-danger btn-sm">Hapus</button> ';
            return $btn;
            })
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
            ->make(true);
    }

    // Menampilkan halaman form detail user ajax
    public function show(string $id)
    {
        $user = UserModel::find($id);
        $user_type = UserTypeModel::select('user_type_id', 'user_type_name' ) ->get();

        return view('admin.user.show', ['user' => $user, 'user_type' => $user_type]);
    }
    
    // Menampilkan halaman form edit user ajax
    public function edit(string $id)
    {
        $user = UserModel::find($id);
        $user_type = UserTypeModel::select('user_type_id', 'user_type_name' ) ->get();

        return view('admin.user.edit', ['user' => $user, 'user_type' => $user_type]);
    }

    public function update(Request $request, $id){
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'user_type_id' => 'required',
                'username' => 'required|max:20|unique:m_user,username,'.$id.',user_id',
                'password' => 'nullable|min:6|max:20'
            ];
            // use Illuminate\Support\Facades\Validator;
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                'status' => false, // respon json, true: berhasil, false: gagal
                'message' => 'Validasi gagal.',
                'msgField' => $validator->errors() // menunjukkan field mana yang error
                ]);
            }
            $check = UserModel::find($id);
            if ($check) {
                if(!$request->filled('password') ){ // jika password tidak diisi, maka hapus dari request
                    $request->request->remove('password');
                }
                $check->update($request->all());
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil diupdate'
                ]);
            } else{
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }
        return redirect('/user');
    }

    public function confirm(string $id){
        $user = UserModel::find($id);
        return view('admin.user.confirm', ['user' => $user]);
    }

    public function delete(Request $request, $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $user = UserModel::find($id);
            if ($user) {
                $user->delete();
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil dihapus'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
            return redirect('/user');
        }
    }

    public function import()
    {
    return view('admin.user.import');
    }

    public function import_excel(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            // Validasi file harus xlsx dan maksimal 1MB
            $rules = [
                'file_user' => ['required', 'mimes:xlsx', 'max:1024']
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            // Ambil file dari request
            $file = $request->file('file_user');

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
                            'user_type_id' => $value['A'],
                            'username' => $value['B'],
                            'password' => bcrypt($value['C']),
                            'created_at' => now(),
                        ];
                    }
                }

                // Insert data ke database, jika data sudah ada, maka diabaikan
                if (count($insert) > 0) {
                    UserModel::insertOrIgnore($insert);
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
        return redirect('/');
    }

    public function export_excel()
    {
        // ambil data user yang akan di export
        $user = UserModel::select('user_type_id','username','password')
                                    ->orderBy('user_type_id')
                                    ->with('user_type')
                                    ->get();
        //load library excel
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet(); // ambil sheet yang aktif
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Username');
        $sheet->setCellValue('C1', 'Jenis Pengguna');
        $sheet->getStyle('A1:C1')->getFont()->setBold(true); //bold header
        
        $no=1; //nomor data dimulai dari 1
        $baris = 2;
        foreach ($user as $key => $value){
            $sheet->setCellValue('A' .$baris, $no);
            $sheet->setCellValue('B' .$baris, $value->username);
            $sheet->setCellValue('C' .$baris, $value->user_type->user_type_name); //ambil nama user_type
            $baris++;
            $no++;
        }
        foreach(range('A','C') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true); //set auto size untuk kolom
        }
        
        $sheet->setTitle('Data User'); //set title sheet
        $writter = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Data User ' .date('Y-m-d H:i:s') .' .xlsx';
        
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

    public function export_pdf(){
        $user = UserModel::select('user_type_id','username')
        ->orderBy('user_type_id')
        ->orderBy('username')
        ->with('user_type')
        ->get();
        $pdf = Pdf::loadView('admin.user.export_pdf', ['user' => $user]);
        $pdf->setPaper('a4', 'portrait'); //set ukuran kertas dan orientasi
        $pdf->setOption("isRemoteEnabled", true); // set true jika ada gambar dari url
        $pdf->render();
        return $pdf->stream('Data User' .date ('Y-m-d H:i:s'). '.pdf');
    }
}