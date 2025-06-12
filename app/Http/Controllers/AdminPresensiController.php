<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Presensi;

class AdminPresensiController extends Controller
{
    public function adminPresensi(Request $request)
    {
        $query = Presensi::with('user')->orderBy('tanggal_presensi', 'desc');

        // Filter berdasarkan tanggal jika tersedia
        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal_presensi', $request->tanggal);
        }

        $presensis = $query->paginate(5);

        return view('admin.presensi', compact('presensis'));
    }
}
