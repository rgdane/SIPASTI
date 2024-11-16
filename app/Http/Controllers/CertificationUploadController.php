<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CertificationUploadController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Certification Upload',
            'list' => ['Home', 'Upload']
        ];

        $activeMenu = 'certification_upload';

        return view('lecturer.certification_input.certification_upload', ['breadcrumb' => $breadcrumb ,'activeMenu' => $activeMenu]);
    }
}
