@extends('layout.main')

@section('content')
<div class="container-fluid px-3">

    {{-- Welcome Card --}}
    <div class="card border-0 mb-4 shadow-sm rounded-4 overflow-hidden" style="background-color: #0f2c63;">
        <div class="row g-0 flex-column-reverse flex-md-row align-items-center">
            <!-- Teks -->
            <div class="col-md-8 p-4 text-white text-center text-md-start">
                <h5 class="fw-bold mt-1 mb-3 text-white">
                    Selamat Datang, <span class="fw-bold" style="color: #fbb03b;">{{ Auth::user()->nama ?? 'User' }}</span>!
                </h5>

                @if (!$presensiHariIni || !$presensiHariIni->jam_masuk || !$presensiHariIni->jam_keluar)
                    <p class="mb-3 small">
                        Anda belum melakukan presensi hari ini. Segera lakukan presensi untuk mencatat kehadiran Anda.
                    </p>
                    <a href="{{ route('presensi.index') }}" class="btn fw-semibold text-dark px-3 py-1 shadow-sm" style="background-color: #fbb03b;">
                        <i class="bi bi-check2-circle me-1"></i> Lakukan Presensi
                    </a>
                @else
                    <p class="mb-0 small">
                        Senang melihat Anda kembali! Absensi hari ini telah tercatat dengan lengkap. Terima kasih atas kedisiplinan Anda.
                    </p>
                @endif
            </div>

            <!-- Ilustrasi -->
            <div class="col-md-4 text-center mt-3">
                <img src="{{ asset('assets/img/work-photo.png') }}" alt="Welcome Illustration" class="img-fluid" style="max-width: 250px;">
            </div>
        </div>
    </div>

    <h4 class="fw-bold mt-5 mb-4">Beranda</h4>

    <div class="d-flex flex-wrap gap-3 mb-4">
        <!-- Card Jam Masuk -->
        <div class="col">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary text-white rounded-circle d-flex justify-content-center align-items-center me-3" style="width: 45px; height: 45px;">
                            <i class="bi bi-clock-history fs-5"></i>
                        </div>
                        <div>
                            <p class="mb-1 text-muted small">Jam Masuk Hari Ini</p>
                            <h5 class="mb-0 fw-semibold">
                                {{ $presensiHariIni && $presensiHariIni->jam_masuk
                                    ? \Carbon\Carbon::parse($presensiHariIni->jam_masuk)->format('H:i:s')
                                    : '-' }}
                            </h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card Status -->
        <div class="col">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="text-white rounded-circle d-flex justify-content-center align-items-center me-3" style="width: 45px; height: 45px; background-color: #fbb03b;">
                            <i class="bi bi-info-circle fs-5"></i>
                        </div>
                        <div>
                            <p class="mb-1 text-muted small">Status Hari Ini</p>
                            <h5 class="mb-0 fw-semibold {{ $presensiHariIni && $presensiHariIni->jam_keluar ? 'text-success' : 'text-warning' }}">
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
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
