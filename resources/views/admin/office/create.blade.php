@extends('admin.main')

@section('content')
<div class="container-fluid px-3">
    <h4 class="fw-bold mb-4">Tambah Lokasi Kantor</h4>

    <div class="card shadow-sm border-0 rounded-4 p-4">
        <form method="POST" action="{{ route('admin.office.store') }}" class="row g-3">
            @csrf

            <div class="col-12">
                <label for="nama" class="form-label fw-semibold">Nama Kantor</label>
                <select id="nama" name="nama" class="form-select shadow-sm @error('nama') is-invalid @enderror" required>
                    <option disabled selected>-- Pilih Kantor --</option>
                    <option value="Kantor Utama" {{ old('nama') == 'Kantor Utama' ? 'selected' : '' }}>Kantor Utama</option>
                    <option value="Kantor Cabang" {{ old('nama') == 'Kantor Cabang' ? 'selected' : '' }}>Kantor Cabang</option>
                </select>
                @error('nama')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-12">
                <label class="form-label fw-semibold">Lokasi (Klik pada Peta)</label>
                <div id="map" style="height: 300px;" class="rounded mb-2"></div>
            </div>

            <div class="col-md-6">
                <label for="latitude" class="form-label fw-semibold">Latitude</label>
                <input 
                    type="text" 
                    id="latitude" 
                    name="latitude" 
                    class="form-control shadow-sm @error('latitude') is-invalid @enderror"
                    placeholder="Masukkan Latitude"
                    required 
                >
                @error('latitude')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <label for="longitude" class="form-label fw-semibold">Longitude</label>
                <input 
                    type="text" 
                    id="longitude" 
                    name="longitude" 
                    class="form-control shadow-sm @error('longitude') is-invalid @enderror"
                    placeholder="Masukkan Longitude"
                    required 
                >
                @error('longitude')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <label for="radius" class="form-label fw-semibold">Radius (meter)</label>
                <input 
                    type="text" 
                    id="radius" 
                    name="radius" 
                    class="form-control shadow-sm @error('radius') is-invalid @enderror" 
                    placeholder="Contoh: 200"
                    required 
                >
                @error('radius')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-12 d-flex flex-wrap gap-2 justify-content-between pt-3">
                <a href="{{ route('admin.kantor') }}" class="btn btn-light border shadow-sm">
                    <i class="bi bi-arrow-left me-1"></i> Batal
                </a>
                <button type="submit" class="btn btn-primary shadow-sm">
                    <i class="bi bi-save me-1"></i> Simpan
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Peta --}}
<script>
    const latitudeInput = document.getElementById("latitude");
    const longitudeInput = document.getElementById("longitude");

    let defaultLat = -5.898764;
    let defaultLng = 105.892765;

    let map = L.map('map').setView([defaultLat, defaultLng], 13);
    let marker = L.marker([defaultLat, defaultLng], { draggable: true }).addTo(map);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    marker.on('dragend', function (e) {
        const position = marker.getLatLng();
        latitudeInput.value = position.lat.toFixed(6);
        longitudeInput.value = position.lng.toFixed(6);
    });

    map.on('click', function (e) {
        marker.setLatLng(e.latlng);
        latitudeInput.value = e.latlng.lat.toFixed(6);
        longitudeInput.value = e.latlng.lng.toFixed(6);
    });

    function updateMarkerFromInputs() {
        const lat = parseFloat(latitudeInput.value);
        const lng = parseFloat(longitudeInput.value);

        if (!isNaN(lat) && !isNaN(lng)) {
            const newLatLng = L.latLng(lat, lng);
            marker.setLatLng(newLatLng);
            map.setView(newLatLng);
        }
    }

    latitudeInput.addEventListener("input", updateMarkerFromInputs);
    longitudeInput.addEventListener("input", updateMarkerFromInputs);
</script>

{{-- Bootstrap Icons --}}
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
@endsection
