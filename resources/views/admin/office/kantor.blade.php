@extends('admin.main')

@section('content')
<div class="container-fluid px-3">
    <h4 class="fw-bold mb-4">Lokasi Kantor</h4>

    <!-- Tombol Tambah -->
    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('admin.office.create') }}" class="btn btn-primary shadow-sm">
            <i class="bi bi-plus-lg me-1"></i> Tambah Lokasi
        </a>
    </div>

    <!-- Tabel Lokasi -->
    <div class="card shadow-sm rounded-4 p-4 border-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle custom-table mb-0">
                <thead>
                    <tr class="text-center">
                        <th>Nama Kantor</th>
                        <th>Latitude</th>
                        <th>Longitude</th>
                        <th>Radius</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($kantors as $kantor)
                    <tr class="text-center">
                        <td class="fw-semibold">{{ $kantor->nama }}</td>
                        <td><span class="text-muted">{{ $kantor->latitude }}</span></td>
                        <td><span class="text-muted">{{ $kantor->longitude }}</span></td>
                        <td>
                            <span class="badge text-dark" style="background-color: #fbb03b;">{{ $kantor->radius }} m</span>
                        </td>
                        <td>
                            <div class="d-flex justify-content-center gap-2">
                                <!-- Edit -->
                                <a href="{{ route('admin.office.edit', $kantor->id) }}"
                                   class="btn btn-sm btn-outline-success"
                                   title="Edit Lokasi">
                                    <i class="bi bi-pencil-square"></i>
                                </a>

                                <!-- Hapus -->
                                <form action="{{ route('admin.office.destroy', $kantor->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus lokasi ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus Lokasi">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">Belum ada data lokasi kantor.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

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
</style>
@endsection
