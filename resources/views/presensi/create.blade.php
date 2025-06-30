@extends('layout.main')

@section('content')
<div class="container-fluid px-3">
    <h4 class="fw-bold mb-4">Presensi Hari Ini</h4>

    <div class="card shadow-sm border-0 rounded-4 p-4" >
        <form method="POST" action="{{ route('presensi.store') }}"  class="row g-3">
            @csrf

            {{-- Informasi Pengguna --}}
            <div class="col">
                <div class="rounded-3 mb-1 p-3 rounded shadow-sm" style="background-color: rgba(33, 150, 243, 0.1);">
                    <p class="mb-1"><strong>Nama:</strong> {{ Auth::user()->nama ?? Auth::user()->name }}</p>
                    <p class="mb-1"><strong>Jam Kerja:</strong> 09.00 - 17.00</p>
                    <p class="mb-0"><strong>Kantor:</strong> Kantor Utama</p>
                </div>
            </div>

            {{-- Jam Masuk & Keluar --}}
            <div class="d-flex flex-wrap gap-3 mb-3">
                <div class="col">
                    <div class="rounded-3 p-3 rounded shadow-sm text-center h-100" style="background-color: rgba(33, 150, 243, 0.1);">
                        <strong >Jam Masuk</strong>
                        <div class="mt-2 fs-6" id="displayJamMasuk">
                            {{ $jamMasuk ?? '- - : - - : - -' }}
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="rounded-3 p-3 rounded shadow-sm text-center h-100" style="background-color: rgba(33, 150, 243, 0.1);">
                        <strong>Jam Keluar</strong>
                        <div class="mt-2 fs-6" id="displayJamKeluar">
                            {{ $jamKeluar ?? '- - : - - : - -' }}
                        </div>
                    </div>
                </div>
            </div>

            {{-- Peta Lokasi --}}
            <div class="mb-1">
                <label class="form-label fw-semibold">Peta Lokasi</label>
                <div id="map" style="height: 250px;" class="rounded shadow-sm border"></div>
            </div>

            {{-- Tombol Aksi --}}
            <div class="col-12 d-flex flex-wrap gap-2 justify-content-between pt-3">
                <button type="button" id="lokasiBtn" class="btn btn-light border shadow-sm">
                    <i class="bi bi-geo-alt me-1"></i> Klik Lokasi
                </button>
                <button type="button" id="presensiBtn" class="btn btn-primary shadow-sm">
                    <i class="bi bi-send me-1"></i> Kirim Presensi
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Leaflet --}}
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>

<script>
let map = L.map('map').setView([-2.5489, 118.0149], 5);
let userMarker = null;
let userCircle = null;

let state = "{{ $jamMasuk !== '-' ? ($jamKeluar !== '-' ? 'complete' : 'jam_masuk_done') : 'initial' }}";
let lokasi = {};
let waktu = {};

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; OpenStreetMap contributors'
}).addTo(map);

document.getElementById("lokasiBtn").addEventListener("click", function () {
    if (state === "complete") {
        alert("Presensi hari ini sudah lengkap.");
        return;
    }

    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function (position) {
            const lat = position.coords.latitude;
            const lon = position.coords.longitude;
            const now = new Date();
            const timeFormatted = now.toLocaleTimeString('id-ID', {
                hour: '2-digit', minute: '2-digit', second: '2-digit'
            });

            if (userMarker) map.removeLayer(userMarker);
            if (userCircle) map.removeLayer(userCircle);

            userMarker = L.marker([lat, lon]).addTo(map).bindPopup('Lokasi Anda').openPopup();
            userCircle = L.circle([lat, lon], {
                color: 'blue',
                fillColor: '#2196F3',
                fillOpacity: 0.3,
                radius: 100
            }).addTo(map);

            map.setView([lat, lon], 16);

            if (state === "initial") {
                document.getElementById("displayJamMasuk").innerText = timeFormatted;
                waktu.jam_masuk = now.toISOString();
                lokasi.lokasi_masuk = `${lat},${lon}`;
                state = "jam_masuk_done";
                document.getElementById("presensiBtn").disabled = false;
            } else if (state === "jam_masuk_done") {
                document.getElementById("displayJamKeluar").innerText = timeFormatted;
                waktu.jam_keluar = now.toISOString();
                lokasi.lokasi_keluar = `${lat},${lon}`;
                state = "complete";
                document.getElementById("presensiBtn").disabled = false;
            }
        }, function (error) {
            alert("Gagal mendapatkan lokasi: " + error.message);
        });
    } else {
        alert("Browser tidak mendukung geolocation.");
    }
});

document.getElementById("presensiBtn").addEventListener("click", function () {
    if (state === "jam_masuk_done") {
        kirimPresensi({
            jam_masuk: waktu.jam_masuk,
            lokasi_masuk: lokasi.lokasi_masuk
        });
    } else if (state === "complete") {
        kirimPresensi({
            jam_keluar: waktu.jam_keluar,
            lokasi_keluar: lokasi.lokasi_keluar
        });
    }
});

function kirimPresensi(data) {
    fetch("{{ route('presensi.store') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(res => {
        if (res.success) {
            alert(res.message || "Presensi berhasil!");
            window.location.href = "{{ route('presensi.index') }}";
        } else {
            alert(res.message || "Presensi gagal disimpan.");
        }
    })
    .catch(err => {
        console.error("Error:", err);
        alert("Terjadi kesalahan saat menyimpan presensi.");
    });
}
</script>

{{-- Bootstrap Icons --}}
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
@endsection
