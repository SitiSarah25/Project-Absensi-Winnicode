<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Presensi;
use App\Models\Kantor;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class PresensiController extends Controller
{
    public function index()
    {
        $presensis = Presensi::with('user')
            ->where('user_id', Auth::id())
            ->orderBy('tanggal_presensi', 'desc')
            ->paginate(5);

        return view('presensi.presensi', compact('presensis'));
    }

    public function create()
    {
        $user = Auth::user();
        $today = Carbon::today();

        $presensi = Presensi::where('user_id', $user->id)
            ->where('tanggal_presensi', $today)
            ->first();

        $jamMasuk = $presensi?->jam_masuk ?? '-';
        $jamKeluar = $presensi?->jam_keluar ?? '-';

        return view('presensi.create', compact('jamMasuk', 'jamKeluar'));
    }

    public function store(Request $request)
    {
        $userId = Auth::id();
        $today = Carbon::today();

        $presensi = Presensi::firstOrNew([
            'user_id' => $userId,
            'tanggal_presensi' => $today,
        ]);

        try {
            // Ambil kantor, default ke 'Kantor Utama'
            $kantor = Kantor::where('nama', 'Kantor Utama')->first();

            if (!$kantor) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data kantor tidak ditemukan.'
                ], 400);
            }

            $kantorLat = $kantor->latitude;
            $kantorLon = $kantor->longitude;
            $radius = $kantor->radius;

            // Validasi jam masuk
            if ($request->filled('jam_masuk') && $request->filled('lokasi_masuk') && !$presensi->jam_masuk) {
                $lokasiMasuk = explode(',', $request->lokasi_masuk);
                $jarakMasuk = $this->hitungJarak($kantorLat, $kantorLon, $lokasiMasuk[0], $lokasiMasuk[1]);

                if ($jarakMasuk > $radius) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Lokasi masuk di luar radius kantor.'
                    ], 422);
                }

                $jamMasuk = Carbon::parse($request->jam_masuk)->timezone('Asia/Jakarta')->format('H:i:s');
                $presensi->jam_masuk = $jamMasuk;
                $presensi->lokasi_masuk = json_encode([
                    'latitude' => trim($lokasiMasuk[0]),
                    'longitude' => trim($lokasiMasuk[1])
                ]);
            }

            // Validasi jam keluar
            if ($request->filled('jam_keluar') && $request->filled('lokasi_keluar') && !$presensi->jam_keluar) {
                $lokasiKeluar = explode(',', $request->lokasi_keluar);
                $jarakKeluar = $this->hitungJarak($kantorLat, $kantorLon, $lokasiKeluar[0], $lokasiKeluar[1]);

                if ($jarakKeluar > $radius) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Lokasi keluar di luar radius kantor.'
                    ], 422);
                }

                $jamKeluar = Carbon::parse($request->jam_keluar)->timezone('Asia/Jakarta')->format('H:i:s');
                $presensi->jam_keluar = $jamKeluar;
                $presensi->lokasi_keluar = json_encode([
                    'latitude' => trim($lokasiKeluar[0]),
                    'longitude' => trim($lokasiKeluar[1])
                ]);
            }

            $presensi->user_id = $userId;
            $presensi->tanggal_presensi = $today;
            $presensi->save();

            return response()->json([
                'success' => true,
                'message' => 'Presensi berhasil disimpan.'
            ]);
        } catch (\Exception $e) {
            Log::error('Presensi Error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan presensi.'
            ], 500);
        }
    }

    // 🔽 Fungsi bantu hitung jarak menggunakan rumus haversine
    private function hitungJarak($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371000; // dalam meter

        $lat1 = deg2rad($lat1);
        $lon1 = deg2rad($lon1);
        $lat2 = deg2rad($lat2);
        $lon2 = deg2rad($lon2);

        $dLat = $lat2 - $lat1;
        $dLon = $lon2 - $lon1;

        $a = sin($dLat / 2) ** 2 + cos($lat1) * cos($lat2) * sin($dLon / 2) ** 2;
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c; // hasil dalam meter
    }
}
