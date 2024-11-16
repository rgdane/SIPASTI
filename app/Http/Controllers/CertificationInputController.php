<?php

namespace App\Http\Controllers;

use App\Models\CertificationModel;
use App\Models\CertificationVendorModel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class CertificationInputController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Input Sertifikasi',
            'list' => ['Home', 'Input Sertifikasi']
        ];

        $page = (object) [
            'title' => 'Input Sertifikasi'
        ];

        // $userId = auth()->id();
        $userId = "USR202411110001";
        $certification_vendor = CertificationVendorModel::all();
        $activeMenu = 'certification_input';

        return view(
            'lecturer.certification_input.index',[
                'breadcrumb' => $breadcrumb,
                'page' => $page,
                'activeMenu' => $activeMenu,
                'userId' => $userId,
                'certification_vendor' => $certification_vendor
            ]);
    }

    public function store(Request $request, string $userId)
    {
            $rules = [
                'certification_name' => 'required|string',
                'certification_number' => 'required|string',
                'certification_date_start' => 'required|date',
                'certification_date_expired' => 'required|date',
                'certification_vendor_id' => 'required|string',
                'certification_level' => 'required', // Pastikan ini integer
                'certification_type' => 'required',  // Pastikan ini integer
                'certification_file' => 'required|mimes:pdf|max:2048', // Maksimal 2MB
            ];
            // Validasi input
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(),
                ]);
            }

            // Menyimpan file
            $filePath = $request->file('certification_file')->store('uploads/certification', 'public');
            
            // Simpan data ke database
            CertificationModel::create([
                'certification_name' => $request->certification_name,
                'certification_number' => $request->certification_number,
                'certification_date_start' => $request->certification_date_start,
                'certification_date_expired' => $request->certification_date_expired,
                'certification_vendor_id' => $request->certification_vendor_id,
                'certification_level' => $request->certification_level,
                'certification_type' => $request->certification_type,
                'certification_file' => $filePath,
                'user_id' => $userId
            ]);
            
            return response()->json([
                'status' => true,
                'message' => 'Data sertifikasi berhasil disimpan'
            ]);

            return redirect('/certification_input')->with('success' . "Sertifikasi berhasil ditambahkan");
        }
    

}
