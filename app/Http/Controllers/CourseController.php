<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        $courses = collect([
            
        ]);
    }
}
