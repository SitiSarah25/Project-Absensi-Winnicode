@extends('admin.main')

@section('content')
<div class="container-fluid px-3">
    <h4 class="fw-bold mb-4">Tambah Pengguna</h4>

    <div class="card shadow-sm border-0 rounded-4 p-4">
        <form action="{{ route('admin.user.store') }}" method="POST" class="row g-3">
            @csrf

            <div class="col-12">
                <label for="nama" class="form-label fw-semibold">Nama Lengkap</label>
                <input 
                    type="text" 
                    id="nama" 
                    name="nama" 
                    class="form-control shadow-sm @error('nama') is-invalid @enderror" 
                    value="{{ old('nama') }}" 
                    placeholder="Masukkan nama lengkap"
                    required
                >
                @error('nama')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-12">
                <label for="email" class="form-label fw-semibold">Email</label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    class="form-control shadow-sm @error('email') is-invalid @enderror" 
                    value="{{ old('email') }}" 
                    placeholder="Contoh: email@example.com"
                    required
                >
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-12">
                <label for="password" class="form-label fw-semibold">Password</label>
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    class="form-control shadow-sm @error('password') is-invalid @enderror" 
                    placeholder="Masukkan password"
                    required
                >
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-12">
                <label for="password_confirmation" class="form-label fw-semibold">Konfirmasi Password</label>
                <input 
                    type="password" 
                    id="password_confirmation" 
                    name="password_confirmation" 
                    class="form-control shadow-sm @error('password_confirmation') is-invalid @enderror" 
                    placeholder="Ulangi password"
                    required
                >
                @error('password_confirmation')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-12">
                <label for="role" class="form-label fw-semibold">Posisi / Role</label>
                <select 
                    id="role" 
                    name="role" 
                    class="form-select shadow-sm @error('role') is-invalid @enderror" 
                    required
                >
                    <option disabled selected>-- Pilih Role --</option>
                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>User</option>
                </select>
                @error('role')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-12 d-flex flex-wrap gap-2 justify-content-between pt-3">
                <a href="{{ route('admin.pengguna') }}" class="btn btn-light border shadow-sm">
                    <i class="bi bi-arrow-left me-1"></i> Batal
                </a>
                <button type="submit" class="btn btn-primary shadow-sm">
                    <i class="bi bi-save me-1"></i> Simpan
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Bootstrap Icons --}}
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
@endsection
