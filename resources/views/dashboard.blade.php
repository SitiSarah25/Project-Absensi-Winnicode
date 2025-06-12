@extends('layout.main')

@section('content')
<h4 class="fw-bold mb-4">Beranda</h4>

<div class="d-flex justify-content-between mb-3" style="gap: 1rem;">
    <div class="card card-info p-3 flex-fill">
        <p class="text-muted mb-1">Jam Masuk Hari Ini</p>
        <h5 class="fw-bold">
            {{ $presensiHariIni && $presensiHariIni->jam_masuk
                ? \Carbon\Carbon::parse($presensiHariIni->jam_masuk)->format('H:i:s')
                : '-' }}
        </h5>
    </div>
    <div class="card card-info p-3 flex-fill">
        <p class="text-muted mb-1">Status Hari Ini</p>
        <h5 class="fw-bold {{ $presensiHariIni && $presensiHariIni->jam_keluar ? 'text-success' : 'text-warning' }}">
            @if ($presensiHariIni && $presensiHariIni->jam_masuk && $presensiHariIni->jam_keluar)
                Hadir
            @elseif ($presensiHariIni && $presensiHariIni->jam_masuk)
                Belum Lengkap
            @else
                Belum Absen
            @endif
        </h5>
    </div>
</div>
@endsection
