<?php

namespace App\Http\Controllers;

use App\Models\CertificationModel;
use App\Models\CertificationVendorModel;
use App\Models\TrainingMemberModel;
use App\Models\TrainingModel;
use App\Models\TrainingVendorModel;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class WelcomeController extends Controller
{

    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Beranda',
            'list' => ['Beranda']
        ];

        $activeMenu = 'dashboard';

        $totalCertification = CertificationModel::count();
        $totalTraining = TrainingModel::count();
        $totalVendorCertification = CertificationVendorModel::count();
        $totalVendorTraining = TrainingVendorModel::count();

        // Get monthly data
        $monthlyData = $this->getMonthlyChartData();

        $userCertificationTotal = $this->getUserCertificationTotal();
        $userTrainingTotal = $this->getUserTrainingTotal();

        return view('welcome', [
            'breadcrumb' => $breadcrumb, 
            'activeMenu' => $activeMenu,
            'totalCertification' => $totalCertification,
            'totalTraining' => $totalTraining,
            'totalVendorCertification' => $totalVendorCertification,
            'totalVendorTraining' => $totalVendorTraining,
            'monthlyChartData' => $monthlyData,
            'userCertificationTotal' => $userCertificationTotal,
            'userTrainingTotal' => $userTrainingTotal,
        ]);
    }

    private function getMonthlyChartData()
    {
        // Get certifications and trainings for the last 12 months
        $now = Carbon::now();
        $monthlyData = [];

        for ($i = 11; $i >= 0; $i--) {
            $monthStart = $now->copy()->subMonths($i)->startOfMonth();
            $monthEnd = $now->copy()->subMonths($i)->endOfMonth();

            $certCount = CertificationModel::whereBetween('created_at', [$monthStart, $monthEnd])->count();
            $trainingCount = TrainingModel::whereBetween('created_at', [$monthStart, $monthEnd])->count();

            $monthlyData[] = $certCount + $trainingCount;
        }

        return $monthlyData;
    }

    private function getUserCertificationTotal()
    {
        // Only for Dosen (lecturer) user type
        $user = Auth::user();
        if ($user->user_type->user_type_code === 'DSN') {
            return CertificationModel::where('user_id', $user->user_id)->count();
        }
        return 0;
    }

    private function getUserTrainingTotal()
    {
        // Only for Dosen (lecturer) user type
        $user = Auth::user();
        if ($user->user_type->user_type_code === 'DSN') {
            return TrainingMemberModel::where('user_id', $user->user_id)->count();
        }
        return 0;
    }
}
