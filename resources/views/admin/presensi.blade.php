@extends('admin.main')

@section('content')
<div class="container-fluid px-4">
    <h4 class="fw-bold mb-4">Presensi Pengguna</h4>

    {{-- Filter Tanggal --}}
    <form method="GET" action="{{ route('admin.presensi') }}" class="row g-3 mb-4 align-items-end">
        <div class="col-md-4">
            <label for="tanggal" class="form-label fw-semibold">Filter Tanggal</label>
            <input type="date" name="tanggal" id="tanggal" class="form-control"
                value="{{ request('tanggal') }}">
        </div>
        <div class="col-md-auto">
            <button type="submit" class="btn btn-primary">Filter</button>
            <a href="{{ route('admin.presensi') }}" class="btn btn-secondary ms-2">Reset</a>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table mb-0" style="border-collapse: collapse; width: 100%; border: 1px solid #dee2e6; border-radius: 8px; overflow: hidden;">
            <thead style="background-color: #f1f5fb; color: #333; border-bottom: 2px solid #a0b9e8;">
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
                    <td style="padding: 12px 15px; border-right: 1px solid #dee2e6;">
                        {{ \Carbon\Carbon::parse($presensi->tanggal_presensi)->translatedFormat('d F Y') }}
                    </td>
                    <td style="padding: 12px 15px; border-right: 1px solid #dee2e6;">
                        {{ $presensi->user->nama ?? '-' }}
                    </td>
                    <td style="padding: 12px 15px; border-right: 1px solid #dee2e6;">
                        {{ $presensi->jam_masuk ? \Carbon\Carbon::parse($presensi->jam_masuk)->format('H:i:s') : '-' }}
                    </td>
                    <td style="padding: 12px 15px; border-right: 1px solid #dee2e6;">
                        {{ $presensi->jam_keluar ? \Carbon\Carbon::parse($presensi->jam_keluar)->format('H:i:s') : '-' }}
                    </td>
                    <td style="padding: 12px 15px;" class="fw-bold
                        {{ $presensi->jam_masuk && $presensi->jam_keluar ? 'text-success' : ($presensi->jam_masuk ? 'text-warning' : 'text-muted') }}">
                        @if ($presensi->jam_masuk && $presensi->jam_keluar)
                            Hadir
                        @elseif ($presensi->jam_masuk)
                            Belum Lengkap
                        @else
                            -
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

    <div class="mt-3 d-flex justify-content-center">
        {{ $presensis->withQueryString()->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
