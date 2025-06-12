<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
 use Illuminate\Support\Facades\Auth;
use App\Models\Presensi;
use Carbon\Carbon;

class DashboardController extends Controller
{


public function index()
{
    $user = Auth::user();
    $today = Carbon::today()->toDateString();

    $presensiHariIni = Presensi::where('user_id', $user->id)
        ->whereDate('tanggal_presensi', $today)
        ->first();

    return view('dashboard', compact('presensiHariIni'));
}


   public function adminDashboard()
{
    $totalUsers = User::where('role', 'user')->count();
    $presensiToday = Presensi::whereDate('tanggal_presensi', Carbon::today())->count();
    $presensiLengkapToday = Presensi::whereDate('tanggal_presensi', Carbon::today())
        ->whereNotNull('jam_masuk')
        ->whereNotNull('jam_keluar')
        ->count();
    $belumPresensi = User::where('role', 'user')
        ->whereDoesntHave('presensi', function ($query) {
            $query->whereDate('tanggal_presensi', Carbon::today());
        })->count();
    $recentPresensis = Presensi::with('user')
        ->orderByDesc('tanggal_presensi')
        ->limit(5)
        ->get();

    return view('admin.dashboard', compact(
        'totalUsers',
        'presensiToday',
        'presensiLengkapToday',
        'belumPresensi',
        'recentPresensis'
    ));
}

}
