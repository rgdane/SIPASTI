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
    public function index(){
        $breadcrumb = (object)[
            'title' => 'Daftar Jenis Pengguna',
            'list' => ['Home', 'Jenis Pengguna']
        ];
    
        $page = (object)[
            'title' => 'Daftar user_type yang terdaftar dalam sistem'
        ];
    
        $activeMenu = 'user_type'; //set menu yang sedang aktif
    
        return view('admin.user_type.index',['breadcrumb'=>$breadcrumb, 'page' => $page, 'activeMenu'=>$activeMenu]);
    }
    
    // Ambil data user_type dalam bentuk json untuk datatables
    public function list()
    {
        $user_types = UserTypeModel::select('user_type_id', 'user_type_code', 'user_type_name');
        return DataTables::of($user_types)
        // menambahkan kolom index / no urut (default user_type_name kolom: DT_RowIndex)
        ->addIndexColumn()
        // ->addColumn('aksi', function ($user_types) { // menambahkan kolom aksi
        //     $btn  = '<button onclick="modalAction(\''.url('/user_type/' . $user_types->user_type_id . '/show').'\')" class="btn btn-info btn-sm">Detail</button> '; 
        //     $btn .= '<button onclick="modalAction(\''.url('/user_type/' . $user_types->user_type_id . '/edit').'\')" class="btn btn-warning btn-sm">Edit</button> '; 
        //     $btn .= '<button onclick="modalAction(\''.url('/user_type/' . $user_types->user_type_id . '/delete').'\')"  class="btn btn-danger btn-sm">Hapus</button> ';
        //     return $btn;
        // })
        // ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
        ->make(true);
    }

    public function create(){
        return view('admin.user_type.create');
    }

    public function store(Request $request){
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'user_type_code' => 'required|string|min:3|max:10|unique:m_user_type,user_type_code',
                'user_type_name' => 'required|string|max:100',
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
                'message' => 'Data jenis pengguna berhasil disimpan'
            ]);
        }
        redirect('/');
    }

        public function show(string $id){
            $user_type = UserTypeModel::find($id);
            return view('admin.user_type.show', ['user_type' => $user_type]);
        }

        public function edit(string $id){
            $user_type = UserTypeModel::find($id);
            return view('admin.user_type.edit', ['user_type' => $user_type]);
        }
        
        Public function update(Request $request, $id){ 
            // cek apakah request dari ajax
            // dd('sdgjasd');
            if ($request->ajax()|| $request->wantsJson()) { 
                $rules = [ 
                    'user_type_code' => 'required|string|min:3|max:10|unique:m_user_type,user_type_code,'.$id.',user_type_id', 
                    'user_type_name'     => 'required|max:100', 
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

        public function confirm(string $id){
            $user_type = UserTypeModel::find($id);
            return view('admin.user_type.confirm', ['user_type' => $user_type]);
        }

        public function delete(Request $request, $id){
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

    public function import()
    {
    return view('admin.user_type.import');
    }

    public function import_excel(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            // Validasi file harus xlsx dan maksimal 1MB
            $rules = [
                'file_user_type' => ['required', 'mimes:xlsx', 'max:1024']
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
                            'user_type_code' => $value['A'],
                            'user_type_name' => $value['B'],
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
    }

    public function export_excel()
    {
        // ambil data user_type yang akan di export
        $user_type = UserTypeModel::select('user_type_code','user_type_name')
                                    ->get();
        //load library excel
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet(); // ambil sheet yang aktif
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Kode Jenis Pengguna');
        $sheet->setCellValue('C1', 'Nama Jenis Pengguna');
        $sheet->getStyle('A1:C1')->getFont()->setBold(true); //bold header
        
        $no=1; //nomor data dimulai dari 1
        $baris = 2;
        foreach ($user_type as $key => $value){
            $sheet->setCellValue('A' .$baris, $no);
            $sheet->setCellValue('B' .$baris, $value->user_type_code);
            $sheet->setCellValue('C' .$baris, $value->user_type_name);
            $baris++;
            $no++;
        }
        foreach(range('A','C') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true); //set auto size untuk kolom
        }
        
        $sheet->setTitle('Data Jenis Pengguna'); //set title sheet
        $writter = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Data Jenis Pengguna ' .date('Y-m-d H:i:s') .' .xlsx';
        
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
        $user_type = UserTypeModel::select('user_type_code','user_type_name')
        ->orderBy('user_type_code')
        ->get();
        $pdf = Pdf::loadView('admin.user_type.export_pdf', ['user_type' => $user_type]);
        $pdf->setPaper('a4', 'portrait'); //set ukuran kertas dan orientasi
        $pdf->setOption("isRemoteEnabled", true); // set true jika ada gambar dari url
        $pdf->render();
        return $pdf->stream('Data Jenis Pengguna' .date ('Y-m-d H:i:s'). '.pdf');
    }
}