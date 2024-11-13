<?php

namespace App\Http\Controllers;

use App\Models\CertificationTypeModel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Yajra\DataTables\DataTables;

class CertificationTypeController extends Controller
{
    public function index(){
        $breadcrumb = (object)[
            'title' => 'Daftar Jenis Sertifikasi',
            'list' => ['Home', 'Jenis Sertifikasi']
        ];
    
        $page = (object)[
            'title' => 'Daftar certification_type yang terdaftar dalam sistem'
        ];
    
        $activeMenu = 'certification_type'; //set menu yang sedang aktif
    
        return view('admin.certification_type.index',['breadcrumb'=>$breadcrumb, 'page' => $page, 'activeMenu'=>$activeMenu]);
    }
    
    // Ambil data certification_type dalam bentuk json untuk datatables
    public function list()
    {
        $certification_types = CertificationTypeModel::select('certification_type_id', 'certification_type_code', 'certification_type_name');
        return DataTables::of($certification_types)
        // menambahkan kolom index / no urut (default certification_type_name kolom: DT_RowIndex)
        ->addIndexColumn()
        ->addColumn('aksi', function ($certification_types) { // menambahkan kolom aksi
            $btn  = '<button onclick="modalAction(\''.url('/certification_type/' . $certification_types->certification_type_id . '/show').'\')" class="btn btn-info btn-sm">Detail</button> '; 
            $btn .= '<button onclick="modalAction(\''.url('/certification_type/' . $certification_types->certification_type_id . '/edit').'\')" class="btn btn-warning btn-sm">Edit</button> '; 
            $btn .= '<button onclick="modalAction(\''.url('/certification_type/' . $certification_types->certification_type_id . '/delete').'\')"  class="btn btn-danger btn-sm">Hapus</button> ';
            return $btn;
        })
        ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
        ->make(true);
    }

    public function create(){
        return view('admin.certification_type.create');
    }

    public function store(Request $request){
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'certification_type_code' => 'required|string|min:3|max:10|unique:m_certification_type,certification_type_code',
                'certification_type_name' => 'required|string|max:100',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(),
                ]);
            }
            CertificationTypeModel::create($request->all());
            return response()->json([
                'status' => true,
                'message' => 'Data jenis sertifikasi berhasil disimpan'
            ]);
        }
        redirect('/');
    }

        public function show(string $id){
            $certification_type = CertificationTypeModel::find($id);
            return view('admin.certification_type.show', ['certification_type' => $certification_type]);
        }

        public function edit(string $id){
            $certification_type = CertificationTypeModel::find($id);
            return view('admin.certification_type.edit', ['certification_type' => $certification_type]);
        }
        
        Public function update(Request $request, $id){ 
            // cek apakah request dari ajax
            // dd('sdgjasd');
            if ($request->ajax()|| $request->wantsJson()) { 
                $rules = [ 
                    'certification_type_code' => 'required|string|min:3|max:10|unique:m_certification_type,certification_type_code,'.$id.',certification_type_id', 
                    'certification_type_name'     => 'required|max:100', 
                ]; 
                $validator = Validator::make($request->all(), $rules); 

                if ($validator->fails()) { 
                    return response()->json([ 
                        'status'   => false,
                        'message'  => 'Validasi gagal.', 
                        'msgField' => $validator->errors()
                    ]); 
                } 

                $check = CertificationTypeModel::find($id); 
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
            $certification_type = CertificationTypeModel::find($id);
            return view('admin.certification_type.confirm', ['certification_type' => $certification_type]);
        }

        public function delete(Request $request, $id){
            if($request -> ajax() || $request -> wantsJson()){
                $certification_type = CertificationTypeModel::find($id);
                if($certification_type){
                    $certification_type -> delete();
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
    return view('admin.certification_type.import');
    }

    public function import_excel(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            // Validasi file harus xlsx dan maksimal 1MB
            $rules = [
                'file_certification_type' => ['required', 'mimes:xlsx', 'max:1024']
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
            $file = $request->file('file_certification_type');

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
                            'certification_type_code' => $value['A'],
                            'certification_type_name' => $value['B'],
                            'created_at' => now(),
                        ];
                    }
                }

                // Insert data ke database, jika data sudah ada, maka diabaikan
                if (count($insert) > 0) {
                    CertificationTypeModel::insertOrIgnore($insert);
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
        return redirect('/certification_type');
    }

    public function export_excel()
    {
        // ambil data certification_type yang akan di export
        $certification_type = CertificationTypeModel::select('certification_type_code','certification_type_name')
                                    ->get();
        //load library excel
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet(); // ambil sheet yang aktif
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Kode Jenis Sertifikasi');
        $sheet->setCellValue('C1', 'Nama Jenis Sertifikasi');
        $sheet->getStyle('A1:C1')->getFont()->setBold(true); //bold header
        
        $no=1; //nomor data dimulai dari 1
        $baris = 2;
        foreach ($certification_type as $key => $value){
            $sheet->setCellValue('A' .$baris, $no);
            $sheet->setCellValue('B' .$baris, $value->certification_type_code);
            $sheet->setCellValue('C' .$baris, $value->certification_type_name);
            $baris++;
            $no++;
        }
        foreach(range('A','C') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true); //set auto size untuk kolom
        }
        
        $sheet->setTitle('Data Jenis Sertifikasi'); //set title sheet
        $writter = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Data Jenis Sertifikasi ' .date('Y-m-d H:i:s') .' .xlsx';
        
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
        $certification_type = CertificationTypeModel::select('certification_type_code','certification_type_name')
        ->orderBy('certification_type_code')
        ->get();
        $pdf = Pdf::loadView('admin.certification_type.export_pdf', ['certification_type' => $certification_type]);
        $pdf->setPaper('a4', 'portrait'); //set ukuran kertas dan orientasi
        $pdf->setOption("isRemoteEnabled", true); // set true jika ada gambar dari url
        $pdf->render();
        return $pdf->stream('Data Jenis Sertifikasi' .date ('Y-m-d H:i:s'). '.pdf');
    }
}