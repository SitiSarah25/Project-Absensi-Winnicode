@extends('admin.main')

@section('content')
<div class="container-fluid px-3">
    
    {{-- Welcome Card --}}
    <div class="card border-0 mb-4 shadow-sm rounded-4 overflow-hidden" style="background-color: #0f2c63;">
        <div class="row g-0 flex-column-reverse flex-md-row align-items-center">
            <!-- Teks -->
            <div class="col-md-8 p-4 text-white text-center text-md-start">
                <h5 class="fw-bold mt-3 mb-3 text-white">
                    Selamat Datang, <span class="fw-bold" style="color: #fbb03b;">{{ Auth::user()->nama ?? 'User' }}</span>!
                </h5>
                <p class="mb-3 small">
                    Anda telah masuk ke halaman admin. Hari ini Anda memiliki {{ $presensiToday }} presensi yang tercatat. Pantau dan kelola aktivitas kehadiran seluruh anggota secara real-time.
                </p>
            </div>

            <!-- Ilustrasi -->
            <div class="col-md-4 text-center mt-3">
                <img src="{{ asset('assets/img/work-photo.png') }}" alt="Welcome Illustration" class="img-fluid" style="max-width: 250px;">
            </div>
        </div>
    </div>

    <h4 class="fw-bold mt-5 mb-4">Beranda</h4>

    {{-- Statistik Card --}}
    <div class="d-flex flex-wrap gap-3 mb-4">
        <!-- Total Pengguna -->
        <div class="col">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="bg-primary text-white rounded-circle d-flex justify-content-center align-items-center me-3" style="width: 45px; height: 45px;">
                        <i class="bi bi-people-fill fs-5"></i>
                    </div>
                    <div>
                        <p class="mb-1 text-muted small">Total Pengguna</p>
                        <h5 class="mb-0 fw-bold">{{ $totalUsers }}</h5>
                    </div>
                </div>
            </div>
        </div>

        <!-- Presensi Hari Ini -->
        <div class="col">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="rounded-circle d-flex justify-content-center align-items-center me-3 text-white" style="width: 45px; height: 45px; background-color: #fbb03b;">
                        <i class="bi bi-calendar-check fs-5"></i>
                    </div>
                    <div>
                        <p class="mb-1 text-muted small">Presensi Hari Ini</p>
                        <h5 class="mb-0 fw-bold">{{ $presensiToday }}</h5>
                    </div>
                </div>
            </div>
        </div>

        <!-- Presensi Lengkap -->
        <div class="col">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="bg-success text-white rounded-circle d-flex justify-content-center align-items-center me-3" style="width: 45px; height: 45px;">
                        <i class="bi bi-check-circle fs-5"></i>
                    </div>
                    <div>
                        <p class="mb-1 text-muted small">Presensi Lengkap</p>
                        <h5 class="mb-0 fw-bold text-success">{{ $presensiLengkapToday }}</h5>
                    </div>
                </div>
            </div>
        </div>

        <!-- Belum Presensi -->
        <div class="col">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="bg-danger text-white rounded-circle d-flex justify-content-center align-items-center me-3" style="width: 45px; height: 45px;">
                        <i class="bi bi-x-circle fs-5"></i>
                    </div>
                    <div>
                        <p class="mb-1 text-muted small">Belum Presensi</p>
                        <h5 class="mb-0 fw-bold text-danger">{{ $belumPresensi }}</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Presensi Terbaru --}}
    <div class="card shadow-sm rounded-4 p-4 border-0">
        <h6 class="fw-bold mb-3">Presensi Terbaru (5 Teratas)</h6>

        {{-- Tabel Desktop --}}
        <div class="table-responsive d-none d-md-block">
            <table class="table table-hover mb-0 custom-table">
                <thead>
                    <tr class="text-center">
                        <th>Tanggal</th>
                        <th>Nama</th>
                        <th>Jam Masuk</th>
                        <th>Jam Keluar</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentPresensis as $presensi)
                    <tr class="text-center">
                        <td>{{ \Carbon\Carbon::parse($presensi->tanggal_presensi)->translatedFormat('d F Y') }}</td>
                        <td>{{ $presensi->user->nama ?? 'N/A' }}</td>
                        <td>{{ $presensi->jam_masuk ? \Carbon\Carbon::parse($presensi->jam_masuk)->format('H:i:s') : '-' }}</td>
                        <td>{{ $presensi->jam_keluar ? \Carbon\Carbon::parse($presensi->jam_keluar)->format('H:i:s') : '-' }}</td>
                        <td>
                            @if ($presensi->jam_masuk && $presensi->jam_keluar)
                                <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i>Hadir</span>
                            @elseif ($presensi->jam_masuk)
                                <span class="badge text-dark" style="background-color: #fbb03b;"><i class="bi bi-exclamation-triangle me-1"></i>Belum Lengkap</span>
                            @else
                                <span class="badge bg-secondary"><i class="bi bi-x-circle me-1"></i>Belum Absen</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">Belum ada data presensi.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Mobile Cards --}}
        <div class="d-block d-md-none mt-3">
            @forelse($recentPresensis as $presensi)
            <div class="card shadow-sm mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h6 class="mb-1 fw-semibold">{{ $presensi->user->nama ?? 'N/A' }}</h6>
                            <p class="text-muted mb-2" style="font-size: 0.85rem;">
                                {{ \Carbon\Carbon::parse($presensi->tanggal_presensi)->translatedFormat('d M Y') }}
                            </p>
                            <div class="small">
                                <span class="me-3">
                                    <i class="bi bi-box-arrow-in-right me-1"></i>{{ $presensi->jam_masuk ? \Carbon\Carbon::parse($presensi->jam_masuk)->format('H:i') : '-' }}
                                </span>
                                <span>
                                    <i class="bi bi-box-arrow-left me-1"></i>{{ $presensi->jam_keluar ? \Carbon\Carbon::parse($presensi->jam_keluar)->format('H:i') : '-' }}
                                </span>
                            </div>
                        </div>
                        <div>
                            @if ($presensi->jam_masuk && $presensi->jam_keluar)
                                <span class="badge bg-success">Hadir</span>
                            @elseif ($presensi->jam_masuk)
                                <span class="badge text-dark" style="background-color: #fbb03b;">Belum Lengkap</span>
                            @else
                                <span class="badge bg-secondary">Belum Absen</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="text-center text-muted py-4">Belum ada data presensi.</div>
            @endforelse
        </div>
    </div>
</div>

{{-- Bootstrap Icons --}}
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

{{-- Styling untuk tabel --}}
<style>
    .custom-table thead {
        background-color: #e9f0fb;
        color: #333;
        border-bottom: 2px solid #a0b9e8;
    }

    .custom-table th, .custom-table td {
        padding: 12px 15px;
        vertical-align: middle;
    }

    .card-body span i {
        color: #0f2c63;
    }
</style>
@endsection
