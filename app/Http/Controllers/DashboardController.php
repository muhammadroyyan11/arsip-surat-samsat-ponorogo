<?php

namespace App\Http\Controllers;

use App\Models\SuratMasuk;
use App\Models\SuratKeluar;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $count = [
            'masuk' => SuratMasuk::count(),
            'keluar' => SuratKeluar::count(),
            'staff' => Staff::count(),
            'user' => User::count(),
        ];

        // Monthly Stats (Last 6 Months)
        $months = [];
        $masukData = [];
        $keluarData = [];

        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $months[] = $month->format('M Y');
            
            $masukData[] = SuratMasuk::whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->count();
                
            $keluarData[] = SuratKeluar::whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->count();
        }

        return view('dashboard', compact('count', 'months', 'masukData', 'keluarData'));
    }
}
