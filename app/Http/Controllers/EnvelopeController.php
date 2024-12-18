<?php

namespace App\Http\Controllers;

use App\Models\EnvelopeModel;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class EnvelopeController extends Controller
{
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Surat Tugas',
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
        $user = auth()->user();
        if ($user->user_type_id == 'UTP202411100001'){
            $envelopes = DB::select("SELECT
                    *
                    FROM t_envelope a
                    INNER JOIN m_training b ON a.training_id = b.training_id
                    INNER JOIN t_training_member c ON b.training_id = c.training_id
                    WHERE
                        b.training_status = '3' AND 
                        c.user_id = :id"
                    , ['id' => $user->user_id]
                );
        } else {
        $envelopes = DB::select("SELECT
                    *
                    FROM t_envelope a
                    INNER JOIN m_training b ON a.training_id = b.training_id AND b.training_status = '3'"
                    );
        }
        return DataTables::of($envelopes)
            ->addIndexColumn()
            ->addColumn('aksi', function ($envelope) {
                
                $btn = '<a href="' . url('/envelope/' . $envelope->envelope_id . '/download') . '" class="btn btn-info btn-sm" download>Download</a>';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function download(String $id)
    {
        // Path file yang akan diunduh
        $filePath = public_path(EnvelopeModel::find($id)->first()->envelope_file);
        // Validasi file ada
        if (!file_exists($filePath)) {
            abort(404, 'File not found');
        }

        // Beri respons untuk mengunduh file
        return response()->download($filePath);
    }
}
