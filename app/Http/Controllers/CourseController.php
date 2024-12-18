<?php

namespace App\Http\Controllers;

use App\Models\CourseModel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
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
        $courses = CourseModel::select(
            'course_id',
            'course_code',
            'course_name'
        );
        return DataTables::of($courses)
        // menambahkan kolom index / no urut (default course_code kolom: DT_RowIndex)
        ->addIndexColumn()
        ->addColumn('aksi', function ($courses) { // menambahkan kolom aksi
            //$btn  = '<button onclick="modalAction(\''.url('/course/' . $courses->course_id . '/show').'\')" class="btn btn-info btn-sm">Detail</button> '; 
            $btn = '<button onclick="modalAction(\''.url('/course/' . $courses->course_id . '/edit').'\')" class="btn btn-warning btn-sm">Edit</button> '; 
            $btn .= '<button onclick="modalAction(\''.url('/course/' . $courses->course_id . '/delete').'\')"  class="btn btn-danger btn-sm">Hapus</button> ';
            return $btn;
        })
        ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
        ->make(true);
    }

    public function create(){
        return view('admin.course.create');
    }

    public function store(Request $request){
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'course_code' => 'required|string|max:255',
                'course_name' => 'required|string|max:255'
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(),
                ]);
            }
            CourseModel::create($request->all());
            return response()->json([
                'status' => true,
                'message' => 'Data vendor sertifikasi berhasil disimpan'
            ]);
        }
        redirect('/');
    }

        public function show(string $id){
            $course = CourseModel::find($id);
            return view('admin.course.show', ['course' => $course]);
        }

        public function edit(string $id){
            $course = CourseModel::find($id);
            return view('admin.course.edit', ['course' => $course]);
        }
        
        Public function update(Request $request, $id){
            // cek apakah request dari ajax
            // dd('sdgjasd');
            if ($request->ajax()|| $request->wantsJson()) {
                $rules = [ 
                    'course_code' => 'required|string|max:255',
                    'course_name' => 'required|string|max:255'
                ];
                $validator = Validator::make($request->all(), $rules);

                if ($validator->fails()) {
                    return response()->json([
                        'status'   => false,
                        'message'  => 'Validasi gagal.',
                        'msgField' => $validator->errors()
                    ]);
                }

                $check = CourseModel::find($id); 
                if ($check) { 
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
            $course = CourseModel::find($id);
            return view('admin.course.confirm', ['course' => $course]);
        }

        public function delete(Request $request, $id){
            if($request -> ajax() || $request -> wantsJson()){
                $course = CourseModel::find($id);
                if($course){
                    $course -> delete();
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
    return view('admin.course.import');
    }

    public function import_excel(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            // Validasi file harus xlsx dan maksimal 1MB
            $rules = [
                'file_course' => ['required', 'mimes:xlsx', 'max:1024']
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
            $file = $request->file('file_course');

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
                            'course_code' => $value['A'],
                            'course_name' => $value['B'],
                            'created_at' => now(),
                        ];
                    }
                }

                // Insert data ke database, jika data sudah ada, maka diabaikan
                if (count($insert) > 0) {
                    CourseModel::insertOrIgnore($insert);
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
        return redirect('/course');
    }

    public function export_excel()
    {
        // ambil data course yang akan di export
        $course = CourseModel::select(
            'course_id',
            'course_code',
            'course_name'
        )
                                    ->get();
        //load library excel
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet(); // ambil sheet yang aktif
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Kode Mata Kuliah');
        $sheet->setCellValue('C1', 'Nama Mata Kuliah');
        $sheet->getStyle('A1:C1')->getFont()->setBold(true); //bold header
        
        $no=1; //nomor data dimulai dari 1
        $baris = 2;
        foreach ($course as $key => $value){
            $sheet->setCellValue('A' .$baris, $no);
            $sheet->setCellValue('B' .$baris, $value->course_code);
            $sheet->setCellValue('C' .$baris, $value->course_name);
            $baris++;
            $no++;
        }
        foreach(range('A','C') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true); //set auto size untuk kolom
        }
        
        $sheet->setTitle('Data Mata Kuliah'); //set title sheet
        $writter = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Data Mata Kuliah ' .date('Y-m-d H:i:s') .' .xlsx';
        
        header('Content-Vendor: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
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
        $course = CourseModel::select(
            'course_id',
            'course_code',
            'course_name'
        )
        ->orderBy('course_code')
        ->get();
        $pdf = Pdf::loadView('admin.course.export_pdf', ['course' => $course]);
        $pdf->setPaper('a4', 'portrait'); //set ukuran kertas dan orientasi
        $pdf->setOption("isRemoteEnabled", true); // set true jika ada gambar dari url
        $pdf->render();
        return $pdf->stream('Data Mata Kuliah' .date ('Y-m-d H:i:s'). '.pdf');
    }
}
