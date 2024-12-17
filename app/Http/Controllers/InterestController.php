<?php

namespace App\Http\Controllers;

use App\Models\InterestModel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Yajra\DataTables\Facades\DataTables;

class InterestController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Bidang Minat',
            'list' => ['Home', 'Bidang Minat']
        ];

        $page = (object) [
            'title' => 'Manajemen Data Bidang Minat'
        ];

        $activeMenu = 'interest';

        return view('admin.interest.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }

    public function list()
    {
        $interests = InterestModel::select(
            'interest_id',
            'interest_code',
            'interest_name'
        );
        return DataTables::of($interests)
        // menambahkan kolom index / no urut (default interest_code kolom: DT_RowIndex)
        ->addIndexColumn()
        ->addColumn('aksi', function ($interests) { // menambahkan kolom aksi
            // $btn  = '<button onclick="modalAction(\''.url('/interest/' . $interests->interest_id . '/show').'\')" class="btn btn-info btn-sm">Detail</button> '; 
            $btn = '<button onclick="modalAction(\''.url('/interest/' . $interests->interest_id . '/edit').'\')" class="btn btn-warning btn-sm">Edit</button> '; 
            $btn .= '<button onclick="modalAction(\''.url('/interest/' . $interests->interest_id . '/delete').'\')"  class="btn btn-danger btn-sm">Hapus</button> ';
            return $btn;
        })
        ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
        ->make(true);
    }

    public function create(){
        return view('admin.interest.create');
    }

    public function store(Request $request){
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'interest_code' => 'required|string|max:255',
                'interest_name' => 'required|string|max:255'
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(),
                ]);
            }
            InterestModel::create($request->all());
            return response()->json([
                'status' => true,
                'message' => 'Data bidang minat berhasil disimpan'
            ]);
        }
        redirect('/');
    }

        public function show(string $id){
            $interest = InterestModel::find($id);
            return view('admin.interest.show', ['interest' => $interest]);
        }

        public function edit(string $id){
            $interest = InterestModel::find($id);
            return view('admin.interest.edit', ['interest' => $interest]);
        }
        
        Public function update(Request $request, $id){
            // cek apakah request dari ajax
            // dd('sdgjasd');
            if ($request->ajax()|| $request->wantsJson()) {
                $rules = [ 
                    'interest_code' => 'required|string|max:255',
                    'interest_name' => 'required|string|max:255'
                ];
                $validator = Validator::make($request->all(), $rules);

                if ($validator->fails()) {
                    return response()->json([
                        'status'   => false,
                        'message'  => 'Validasi gagal.',
                        'msgField' => $validator->errors()
                    ]);
                }

                $check = InterestModel::find($id); 
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
            $interest = InterestModel::find($id);
            return view('admin.interest.confirm', ['interest' => $interest]);
        }

        public function delete(Request $request, $id){
            if($request -> ajax() || $request -> wantsJson()){
                $interest = InterestModel::find($id);
                if($interest){
                    $interest -> delete();
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
    return view('admin.interest.import');
    }

    public function import_excel(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            // Validasi file harus xlsx dan maksimal 1MB
            $rules = [
                'file_interest' => ['required', 'mimes:xlsx', 'max:1024']
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
            $file = $request->file('file_interest');

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
                            'interest_code' => $value['A'],
                            'interest_name' => $value['B'],
                            'created_at' => now(),
                        ];
                    }
                }

                // Insert data ke database, jika data sudah ada, maka diabaikan
                if (count($insert) > 0) {
                    InterestModel::insertOrIgnore($insert);
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
        return redirect('/interest');
    }

    public function export_excel()
    {
        // ambil data interest yang akan di export
        $interest = InterestModel::select(
            'interest_id',
            'interest_code',
            'interest_name'
        )
                                    ->get();
        //load library excel
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet(); // ambil sheet yang aktif
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Kode Bidang Minat');
        $sheet->setCellValue('C1', 'Nama Bidang Minat');
        $sheet->getStyle('A1:C1')->getFont()->setBold(true); //bold header
        
        $no=1; //nomor data dimulai dari 1
        $baris = 2;
        foreach ($interest as $key => $value){
            $sheet->setCellValue('A' .$baris, $no);
            $sheet->setCellValue('B' .$baris, $value->interest_code);
            $sheet->setCellValue('C' .$baris, $value->interest_name);
            $baris++;
            $no++;
        }
        foreach(range('A','C') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true); //set auto size untuk kolom
        }
        
        $sheet->setTitle('Data Bidang Minat'); //set title sheet
        $writter = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Data Bidang Minat' .date('Y-m-d H:i:s') .' .xlsx';
        
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
        $interest = InterestModel::select(
            'interest_id',
            'interest_code',
            'interest_name'
        )
        ->orderBy('interest_code')
        ->get();
        $pdf = Pdf::loadView('admin.interest.export_pdf', ['interest' => $interest]);
        $pdf->setPaper('a4', 'portrait'); //set ukuran kertas dan orientasi
        $pdf->setOption("isRemoteEnabled", true); // set true jika ada gambar dari url
        $pdf->render();
        return $pdf->stream('Data Bidang Minat' .date ('Y-m-d H:i:s'). '.pdf');
    }
}