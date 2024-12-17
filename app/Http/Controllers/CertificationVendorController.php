<?php

namespace App\Http\Controllers;

use App\Models\CertificationVendorModel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Yajra\DataTables\DataTables;

class CertificationVendorController extends Controller
{
    public function index(){
        $breadcrumb = (object)[
            'title' => 'Daftar Vendor Sertifikasi',
            'list' => ['Home', 'Vendor Sertifikasi']
        ];
    
        $page = (object)[
            'title' => 'Daftar certification_vendor yang terdaftar dalam sistem'
        ];
    
        $activeMenu = 'certification_vendor'; //set menu yang sedang aktif
    
        return view('admin.certification_vendor.index',['breadcrumb'=>$breadcrumb, 'page' => $page, 'activeMenu'=>$activeMenu]);
    }
    
    // Ambil data certification_vendor dalam bentuk json untuk datatables
    public function list()
    {
        $certification_vendors = CertificationVendorModel::select(
            'certification_vendor_id',
            'certification_vendor_name',
            'certification_vendor_address',
            'certification_vendor_city',
            'certification_vendor_phone',
            'certification_vendor_web'
        );
        return DataTables::of($certification_vendors)
        // menambahkan kolom index / no urut (default certification_vendor_name kolom: DT_RowIndex)
        ->addIndexColumn()
        ->addColumn('aksi', function ($certification_vendors) { // menambahkan kolom aksi
            //$btn  = '<button onclick="modalAction(\''.url('/certification_vendor/' . $certification_vendors->certification_vendor_id . '/show').'\')" class="btn btn-info btn-sm">Detail</button> '; 
            $btn = '<button onclick="modalAction(\''.url('/certification_vendor/' . $certification_vendors->certification_vendor_id . '/edit').'\')" class="btn btn-warning btn-sm">Edit</button> '; 
            $btn .= '<button onclick="modalAction(\''.url('/certification_vendor/' . $certification_vendors->certification_vendor_id . '/delete').'\')"  class="btn btn-danger btn-sm">Hapus</button> ';
            return $btn;
        })
        ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
        ->make(true);
    }

    public function create(){
        return view('admin.certification_vendor.create');
    }

    public function store(Request $request){
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'certification_vendor_name' => 'required|string|max:255',
                'certification_vendor_address' => 'required|string',
                'certification_vendor_city' => 'required|string|max:255',
                'certification_vendor_phone' => 'required|string|max:20',
                'certification_vendor_web' => 'required|string'
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(),
                ]);
            }
            CertificationVendorModel::create($request->all());
            return response()->json([
                'status' => true,
                'message' => 'Data vendor sertifikasi berhasil disimpan'
            ]);
        }
        redirect('/');
    }

        public function show(string $id){
            $certification_vendor = CertificationVendorModel::find($id);
            return view('admin.certification_vendor.show', ['certification_vendor' => $certification_vendor]);
        }

        public function edit(string $id){
            $certification_vendor = CertificationVendorModel::find($id);
            return view('admin.certification_vendor.edit', ['certification_vendor' => $certification_vendor]);
        }
        
        Public function update(Request $request, $id){
            // cek apakah request dari ajax
            // dd('sdgjasd');
            if ($request->ajax()|| $request->wantsJson()) {
                $rules = [ 
                    'certification_vendor_name' => 'required|string|max:255',
                    'certification_vendor_address' => 'required|string',
                    'certification_vendor_city' => 'required|string|max:255',
                    'certification_vendor_phone' => 'required|string|max:20',
                    'certification_vendor_web' => 'required|string'
                ];
                $validator = Validator::make($request->all(), $rules);

                if ($validator->fails()) {
                    return response()->json([
                        'status'   => false,
                        'message'  => 'Validasi gagal.',
                        'msgField' => $validator->errors()
                    ]);
                }

                $check = CertificationVendorModel::find($id); 
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
            $certification_vendor = CertificationVendorModel::find($id);
            return view('admin.certification_vendor.confirm', ['certification_vendor' => $certification_vendor]);
        }

        public function delete(Request $request, $id){
            if($request -> ajax() || $request -> wantsJson()){
                $certification_vendor = CertificationVendorModel::find($id);
                if($certification_vendor){
                    $certification_vendor -> delete();
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
    return view('admin.certification_vendor.import');
    }

    public function import_excel(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            // Validasi file harus xlsx dan maksimal 1MB
            $rules = [
                'file_certification_vendor' => ['required', 'mimes:xlsx', 'max:1024']
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
            $file = $request->file('file_certification_vendor');

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
                            'certification_vendor_name' => $value['A'],
                            'certification_vendor_address' => $value['B'],
                            'certification_vendor_city' => $value['C'],
                            'certification_vendor_phone' => $value['D'],
                            'certification_vendor_web' => $value['E'],
                            'created_at' => now(),
                        ];
                    }
                }

                // Insert data ke database, jika data sudah ada, maka diabaikan
                if (count($insert) > 0) {
                    CertificationVendorModel::insertOrIgnore($insert);
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
        return redirect('/certification_vendor');
    }

    public function export_excel()
    {
        // ambil data certification_vendor yang akan di export
        $certification_vendor = CertificationVendorModel::select(
            'certification_vendor_id',
            'certification_vendor_name',
            'certification_vendor_address',
            'certification_vendor_city',
            'certification_vendor_phone',
            'certification_vendor_web'
        )
                                    ->get();
        //load library excel
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet(); // ambil sheet yang aktif
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Nama Vendor Sertifikasi');
        $sheet->setCellValue('C1', 'Alamat Vendor Sertifikasi');
        $sheet->setCellValue('D1', 'Kota Vendor Sertifikasi');
        $sheet->setCellValue('E1', 'PIC Vendor Sertifikasi');
        $sheet->setCellValue('F1', 'Website Vendor Sertifikasi');
        $sheet->getStyle('A1:F1')->getFont()->setBold(true); //bold header
        
        $no=1; //nomor data dimulai dari 1
        $baris = 2;
        foreach ($certification_vendor as $key => $value){
            $sheet->setCellValue('A' .$baris, $no);
            $sheet->setCellValue('B' .$baris, $value->certification_vendor_name);
            $sheet->setCellValue('C' .$baris, $value->certification_vendor_address);
            $sheet->setCellValue('D' .$baris, $value->certification_vendor_city);
            $sheet->setCellValue('E' .$baris, $value->certification_vendor_phone);
            $sheet->setCellValue('F' .$baris, $value->certification_vendor_web);
            $baris++;
            $no++;
        }
        foreach(range('A','F') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true); //set auto size untuk kolom
        }
        
        $sheet->setTitle('Data Vendor Sertifikasi'); //set title sheet
        $writter = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Data Vendor Sertifikasi ' .date('Y-m-d H:i:s') .' .xlsx';
        
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
        $certification_vendor = CertificationVendorModel::select(
            'certification_vendor_id',
            'certification_vendor_name',
            'certification_vendor_address',
            'certification_vendor_city',
            'certification_vendor_phone',
            'certification_vendor_web'
        )
        ->orderBy('certification_vendor_name')
        ->get();
        $pdf = Pdf::loadView('admin.certification_vendor.export_pdf', ['certification_vendor' => $certification_vendor]);
        $pdf->setPaper('a4', 'portrait'); //set ukuran kertas dan orientasi
        $pdf->setOption("isRemoteEnabled", true); // set true jika ada gambar dari url
        $pdf->render();
        return $pdf->stream('Data Vendor Sertifikasi' .date ('Y-m-d H:i:s'). '.pdf');
    }
}