@extends('layout.main')

@section('content')
<div class="container-fluid px-4">
    <h4 class="fw-bold mb-4">Presensi</h4>

    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('presensi.create') }}" class="btn btn-primary shadow-sm">
            <i class="bi bi-plus-lg me-1"></i> Tambah Presensi
        </a>
    </div>

    <div class="table-responsive">
        <table class="table mb-0" style="border-collapse: collapse; width: 100%; border: 1px solid #dee2e6; border-radius: 8px; overflow: hidden;">
           <thead style="background-color: #e9f0fb; color: #333; border-bottom: 2px solid #a0b9e8;">
                <tr class="text-center">
                    <th style="padding: 12px 15px; border-right: 1px solid #dee2e6;">Tanggal</th>
                    <th style="padding: 12px 15px; border-right: 1px solid #dee2e6;">Nama</th>
                    <th style="padding: 12px 15px; border-right: 1px solid #dee2e6;">Jam Masuk</th>
                    <th style="padding: 12px 15px; border-right: 1px solid #dee2e6;">Jam Keluar</th>
                    <th style="padding: 12px 15px;">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($presensis as $presensi)
                <tr class="text-center" style="border-top: 1px solid #dee2e6;">
                    <td style="padding: 12px 15px;">{{ \Carbon\Carbon::parse($presensi->tanggal_presensi)->translatedFormat('d F Y') }}</td>
                    <td style="padding: 12px 15px;">{{ $presensi->user->nama ?? 'N/A' }}</td>
                    <td style="padding: 12px 15px;">{{ $presensi->jam_masuk ? \Carbon\Carbon::parse($presensi->jam_masuk)->setTimezone('Asia/Jakarta')->format('H:i:s') : '-' }}</td>
                    <td style="padding: 12px 15px;">{{ $presensi->jam_keluar ? \Carbon\Carbon::parse($presensi->jam_keluar)->setTimezone('Asia/Jakarta')->format('H:i:s') : '- - : - - : - -' }}</td>
                    <td style="padding: 12px 15px;" class="{{ ($presensi->jam_masuk && $presensi->jam_keluar) ? 'text-success' : 'text-warning' }} fw-bold">
                        @if ($presensi->jam_masuk && $presensi->jam_keluar)
                            Hadir
                        @else
                            Belum Lengkap
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
</div>

<!-- Bootstrap Icons (jika belum ada) -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
@endsection
