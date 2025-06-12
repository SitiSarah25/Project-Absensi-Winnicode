@extends('layout.main')

@section('content')
<div class="container">
    {{-- <div class="mb-3">
        <a href="{{ route('presensi.index') }}" class="btn btn-secondary">
            &larr; Kembali
        </a>
    </div> --}}

    <div class="card shadow-sm rounded-4 p-4" style="max-width: 500px; margin: auto;">
        <h5 class="fw-bold mb-3 text-center">Informasi Pegawai</h5>

        <div style="background-color: rgba(33, 150, 243, 0.1);" class="rounded-3 p-3 mb-3">
            <p class="mb-1"><strong>Nama :</strong> {{ Auth::user()->nama ?? Auth::user()->name }}</p>
            <p class="mb-1"><strong>Jam Kerja :</strong> 09.00 - 17.00</p>
            <p class="mb-0"><strong>Kantor :</strong> Kantor Utama</p>
        </div>

        <div class="d-flex justify-content-between mb-3">
            <div style="background-color: rgba(33, 150, 243, 0.1); flex: 1; margin-right: 5px;" class="rounded-3 p-2 text-center">
                <strong>Jam Masuk</strong>
                <div id="displayJamMasuk">{{ $jamMasuk ?? '- - : - - : - -' }}</div>
            </div>
            <div style="background-color: rgba(33, 150, 243, 0.1); flex: 1; margin-left: 5px;" class="rounded-3 p-2 text-center">
                <strong>Jam Keluar</strong>
                <div id="displayJamKeluar">{{ $jamKeluar ?? '- - : - - : - -' }}</div>
            </div>
        </div>

        <h6 class="fw-bold mb-2">Presensi</h6>

        <div id="map" style="height: 250px;" class="rounded mb-3"></div>

        <div class="d-flex justify-content-between">
            <button id="lokasiBtn" class="btn btn-primary w-50 me-2">Klik Lokasi</button>
            <button id="presensiBtn" class="btn btn-danger w-50 ms-2" disabled>Kirim Presensi</button>
        </div>
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
            const timeFormatted = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' });

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
@endsection
