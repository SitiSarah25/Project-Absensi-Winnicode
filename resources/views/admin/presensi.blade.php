@extends('admin.main')

@section('content')
<div class="container-fluid px-3">
    <h4 class="fw-bold mb-4">Riwayat Presensi Pengguna</h4>

    {{-- Filter Tanggal --}}
    <div class="d-flex justify-content-between flex-wrap gap-2 mb-4 align-items-center">
        <form method="GET" action="{{ route('admin.presensi') }}" style="max-width: 350px;" class="w-100 position-relative">
            <input
                type="date"
                name="tanggal"
                class="form-control shadow-sm ps-4 pe-5 rounded-pill"
                value="{{ request('tanggal') }}"
                style="height: 42px; border: 1px solid #ced4da;"
            >
            <button type="submit"
                    class="position-absolute top-50 end-0 translate-middle-y me-3 btn p-0 border-0 bg-transparent"
                    title="Cari berdasarkan tanggal">
                <i class="bi bi-search text-primary fs-5"></i>
            </button>
        </form>

        <a href="{{ route('admin.presensi') }}" class="btn btn-primary shadow-sm" style="border: none;">
            <i class="bi bi-arrow-clockwise me-1"></i> Reset
        </a>

    </div>

    {{-- Presensi Terbaru --}}
    <div class="card shadow-sm rounded-4 p-4 border-0">
        {{-- Desktop Table --}}
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
                    @forelse ($presensis as $presensi)
                    <tr class="text-center">
                        <td>{{ \Carbon\Carbon::parse($presensi->tanggal_presensi)->translatedFormat('d F Y') }}</td>
                        <td>{{ $presensi->user->nama ?? '-' }}</td>
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
        <div class="d-block d-md-none">
            @forelse ($presensis as $presensi)
            <div class="card shadow-sm mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h6 class="mb-1 fw-semibold">{{ $presensi->user->nama ?? '-' }}</h6>
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

    {{-- Pagination --}}
    <div class="mt-3 d-flex justify-content-center">
        {{ $presensis->withQueryString()->links('pagination::bootstrap-5') }}
    </div>
</div>

{{-- Bootstrap Icons --}}
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

{{-- Custom Table Styling --}}
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
