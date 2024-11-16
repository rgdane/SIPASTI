<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EnvelopeController extends Controller
{
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Permintaan Surat Tugas',
            'list' => ['Home', 'Surat']
        ];

        $page = (object) [
            'title' => 'Manajemen Surat Tugas',
        ];

        $activeMenu = 'envelope';

        return view('admin.envelope.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }

    public function list()
    {
        
    }
}
