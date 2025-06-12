@extends('admin.main')

@section('content')
<h4 class="fw-bold mb-4">Dashboard Admin</h4>

<div class="row g-4 mb-4">
    {{-- Total Pengguna --}}
    <div class="col-md-3 col-sm-6">
        <div class="card p-3 shadow-sm rounded-4 bg-light">
            <p class="text-muted mb-1">Total Pengguna</p>
            <h5 class="fw-bold">{{ $totalUsers }}</h5>
        </div>
    </div>

    {{-- Total Presensi Hari Ini --}}
    <div class="col-md-3 col-sm-6">
        <div class="card p-3 shadow-sm rounded-4 bg-light">
            <p class="text-muted mb-1">Presensi Hari Ini</p>
            <h5 class="fw-bold">{{ $presensiToday }}</h5>
        </div>
    </div>

    {{-- Presensi Lengkap --}}
    <div class="col-md-3 col-sm-6">
        <div class="card p-3 shadow-sm rounded-4 bg-light">
            <p class="text-muted mb-1">Presensi Lengkap</p>
            <h5 class="fw-bold text-success">{{ $presensiLengkapToday }}</h5>
        </div>
    </div>

    {{-- Belum Presensi --}}
    <div class="col-md-3 col-sm-6">
        <div class="card p-3 shadow-sm rounded-4 bg-light">
            <p class="text-muted mb-1">Belum Presensi</p>
            <h5 class="fw-bold text-danger">{{ $belumPresensi }}</h5>
        </div>
    </div>
</div>

{{-- Tabel Presensi Terbaru --}}
<div class="card shadow-sm rounded-4 p-4">
    <h6 class="fw-bold mb-3">5 Presensi Terbaru</h6>
    <div class="table-responsive">
        <table class="table table-striped align-middle mb-0">
            <thead style="background-color: #f5f8fc;">
                <tr class="text-center">
                    <th>Nama</th>
                    <th>Tanggal</th>
                    <th>Jam Masuk</th>
                    <th>Jam Keluar</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentPresensis as $presensi)
                <tr class="text-center">
                    <td>{{ $presensi->user->nama ?? 'N/A' }}</td>
                    <td>{{ \Carbon\Carbon::parse($presensi->tanggal_presensi)->translatedFormat('d F Y') }}</td>
                    <td>{{ $presensi->jam_masuk ?? '-' }}</td>
                    <td>{{ $presensi->jam_keluar ?? '-' }}</td>
                    <td class="{{ $presensi->jam_masuk && $presensi->jam_keluar ? 'text-success' : 'text-warning' }} fw-semibold">
                        {{ $presensi->jam_masuk && $presensi->jam_keluar ? 'Hadir' : 'Belum Lengkap' }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted py-3">Belum ada presensi terbaru.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
