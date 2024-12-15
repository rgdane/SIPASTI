<?php

namespace App\Http\Controllers;
require_once '../vendor/autoload.php';

use App\Models\EnvelopeModel;
use App\Models\TrainingModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\TemplateProcessor;
use Yajra\DataTables\Facades\DataTables;


class TrainingApprovalController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Pelatihan',
            'list' => ['Home', 'Pelatihan']
        ];

        $page = (object) [
            'title' => 'Pengajuan Pelatihan',
        ];

        $activeMenu = 'training_approval';

        return view('head_department.training_approval.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }

    public function list()
    {
        $trainings = DB::select(
            "SELECT
                a.training_id,
                a.training_name,
                d.period_year,
                DATE_FORMAT(a.training_date, '%d-%m-%Y') AS training_date,
                CASE
                    WHEN a.training_level = '0' THEN 'Nasional'
                        ELSE 'Internasional'
                END AS training_level,
                CASE
                    WHEN a.training_status = '0' THEN 'Pending'
                    WHEN a.training_status = '1' THEN 'Pengajuan'
                    WHEN a.training_status = '2' THEN 'Ditolak'
                    WHEN a.training_status = '3' THEN 'Disetujui'
                    WHEN a.training_status = '4' THEN 'Selesai'
                END AS training_status
            FROM
                m_training a
                INNER JOIN m_period d ON a.period_id = d.period_id
            WHERE
                a.training_status <> '0'
                ;"
        );
        return DataTables::of($trainings)
        // menambahkan kolom index / no urut (default training_name kolom: DT_RowIndex)
        ->addIndexColumn()
        ->addColumn('aksi', function ($trainings) { // menambahkan kolom aksi
            $btn = '<button onclick="modalAction(\''.url('/training_approval/' . $trainings->training_id . '/show').'\')" class="btn btn-info btn-sm">Detail</button> '; 
            return $btn;
        })
        ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
        ->make(true);
    }

    public function show(string $id)
    {
        $training = DB::selectOne(
            "SELECT
                a.training_id,
                a.training_name,
                d.period_year,
                a.training_date,
                a.training_hours,
                a.training_location,
                a.training_cost,
                a.training_quota,
                b.training_vendor_name,
                CASE
                    WHEN a.training_level = '0' THEN 'Nasional'
                        ELSE 'Internasional'
                END AS training_level,
                CASE
                    WHEN a.training_status = '0' THEN 'Pending'
                    WHEN a.training_status = '1' THEN 'Pengajuan'
                    WHEN a.training_status = '2' THEN 'Ditolak'
                    WHEN a.training_status = '3' THEN 'Disetujui'
                    WHEN a.training_status = '4' THEN 'Selesai'
                END AS training_status
            FROM
                m_training a
                INNER JOIN m_training_vendor b ON a.training_vendor_id = b.training_vendor_id
                INNER JOIN m_period d ON a.period_id = d.period_id
            WHERE
                a.training_id = :id", ['id' => $id]
        );

        $interest = DB::select(
            "SELECT
        b.`interest_name`
        FROM
        `t_interest_training` a
        INNER JOIN `m_interest` b ON a.`interest_id` = b.`interest_id`
        WHERE a.`training_id` = '$id';"
        );

        $course = DB::select(
            "SELECT
        b.`course_name`
        FROM
        `t_course_training` a
        INNER JOIN `m_course` b ON a.`course_id` = b.`course_id`
        WHERE a.`training_id` = '$id';"
        );
        // dd($training->training_id);
        // Kembalikan view dengan data
        return view('head_department.training_approval.show', [
            'training' => $training,
            'interest' => $interest,
            'course' => $course,
        ]);
    }

    public function show_member($id){
        $user = DB::select(
            "SELECT
        b.`user_fullname`
        FROM
        `t_training_member` a
        INNER JOIN `m_user` b ON a.`user_id` = b.`user_id`
        WHERE a.`training_id` = '$id';"
        );

        return DataTables::of($user)
            ->addIndexColumn() // Tambahkan kolom indeks
            ->make(true);      // Kembalikan data dalam format JSON
    }

    public function approve(String $id){
        $check = TrainingModel::find($id);
        if ($check) {
            $this->create_envelope($id);
            $check->training_status = '3';
            $check->save();
            return response()->json([
                'status' => true,
                'message' => 'Pengajuan Pelatihan Disetujui',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Pembaruan status berhasil',
            ]);
        }
    }

    public function reject(String $id){
        $check = TrainingModel::find($id);
        if ($check) {
            $check->training_status = '2';
            $check->save();
            return response()->json([
                'status' => true,
                'message' => 'Pembaruan status berhasil',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Data Pengajuan tidak ditemukan',
            ]);
        }
    }

    public function create_envelope(String $id)
    {
        // Query untuk mendapatkan data pelatihan
        $training = DB::selectOne(
            "SELECT
                a.*,
                b.`training_vendor_name`
                FROM
                    m_training a
                INNER JOIN 
                    m_training_vendor b 
                ON 
                    a.training_vendor_id = b.training_vendor_id 
                WHERE 
                    a.training_id = :id",
            ['id' => $id] // Gunakan array untuk parameter binding
        );

        // Query untuk mendapatkan data peserta
        $users = DB::select(
            "SELECT
                b.`user_fullname`,
                c.`user_detail_nip`,
                d.`user_type_name`
                FROM
                    `t_training_member` a
                INNER JOIN 
                    `m_user` b ON a.`user_id` = b.`user_id`
                INNER JOIN 
                    `m_user_detail` c ON b.`user_id` = c.`user_id`
                INNER JOIN 
                    `m_user_type` d ON b.`user_type_id` = d.`user_type_id`
                WHERE 
                    a.`training_id` = :id",
            ['id' => $id] // Gunakan array untuk parameter binding
        );

        

        // Path ke file template
        $templatePath = public_path('/template Permohonan ST 2 halaman.docx');

        // Buat TemplateProcessor
        $templateProcessor = new TemplateProcessor($templatePath);

        // Ganti placeholder di template
        $templateProcessor->setValue('timestamp', $this->format_date(now(), false));
        $templateProcessor->setValue('pelatihan', $training->training_name ?? ''); // Gunakan arrow untuk object
        $templateProcessor->setValue('vendor', $training->training_vendor_name ?? '');
        //$templateProcessor->setValue('tanggal', date('l, d F Y', strtotime($training->training_date ?? '')));
        $templateProcessor->setValue('tanggal', $this->format_date($training->training_date, true) ?? '');

        // Clone rows untuk data peserta
        $templateProcessor->cloneRow('no', count($users));

        // Isi data ke dalam tabel
        $i = 1;
        foreach ($users as $user) {
            $templateProcessor->setValue("no#$i", $i);
            $templateProcessor->setValue("nama#$i", $user->user_fullname ?? '');
            $templateProcessor->setValue("nip#$i", $user->user_detail_nip ?? '');
            $templateProcessor->setValue("jabatan#$i", $user->user_type_name ?? '');
            $i++;
        }

        // Simpan dokumen
        $path = 'storage/uploads/envelope/ST_'.$training->training_name.'.docx';
        $outputPath = public_path($path);
        $templateProcessor->saveAs($outputPath);

        EnvelopeModel::create([
            'training_id' => $id,
            'envelope_file' => $path
        ]);
    }

    public function format_date(String $date, Bool $is_day){
        // Array nama hari dan bulan dalam bahasa Indonesia
        $days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        $months = [
            1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];

        // Tanggal yang akan diformat
        $timestamp = strtotime($date);

        // Ambil nama hari, tanggal, bulan, dan tahun
        $dayName = $days[date('w', $timestamp)];
        $day = date('d', $timestamp);
        $month = $months[date('n', $timestamp)];
        $year = date('Y', $timestamp);

        if (!$is_day){
            return "$day $month $year";
        }
        // Gabungkan menjadi format akhir
        return "$dayName, $day $month $year";
    }
}
