<?php

namespace App\Http\Controllers;

use App\Models\CertificationModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CertificationHistoryController extends Controller
{
    public function index()
    {
        // Get the authenticated user's ID
        $userId = auth()->user()->user_id;
        $certifications = CertificationModel::where('user_id', $userId)->get();


        // Prepare breadcrumb and page information
        $breadcrumb = (object) [
            'title' => 'Riwayat Sertifikasi',
            'list' => ['Home', 'Riwayat Sertifikasi']
        ];

        $page = (object) [
            'title' => 'Riwayat Sertifikasi'
        ];

        $activeMenu = 'certification_history';

        return view('lecturer.certification_history.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu,
            'certifications' => $certifications,
            'userId' => $userId
        ]);
    }   
}