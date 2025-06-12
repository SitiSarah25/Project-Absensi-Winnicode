@extends('admin.main')

@section('content')
<div class="container-fluid px-4">
    <h4 class="fw-bold mb-4">Lokasi Kantor</h4>

    <!-- Tombol Tambah -->
    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('admin.office.create') }}" class="btn btn-primary shadow-sm">
            <i class="bi bi-plus-lg me-1"></i> Tambah Lokasi
        </a>
    </div>

    <!-- Tabel Lokasi -->
    <div class="table-responsive">
        <table class="table mb-0" style="border-collapse: collapse; width: 100%; border: 1px solid #dee2e6; border-radius: 8px; overflow: hidden;">
             <thead style="background-color: #e9f0fb; color: #333; border-bottom: 2px solid #a0b9e8;">
                <tr class="text-center">
                    <th style="padding: 12px 15px; border-right: 1px solid #dee2e6;">Nama Kantor</th>
                    <th style="padding: 12px 15px; border-right: 1px solid #dee2e6;">Latitude</th>
                    <th style="padding: 12px 15px; border-right: 1px solid #dee2e6;">Longitude</th>
                    <th style="padding: 12px 15px; border-right: 1px solid #dee2e6;">Radius</th>
                    <th style="padding: 12px 15px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($kantors as $kantor)
                <tr class="text-center" style="border-top: 1px solid #dee2e6;">
                    <td style="padding: 12px 15px; border-right: 1px solid #dee2e6;">{{ $kantor->nama }}</td>
                    <td style="padding: 12px 15px; border-right: 1px solid #dee2e6;">{{ $kantor->latitude }}</td>
                    <td style="padding: 12px 15px; border-right: 1px solid #dee2e6;">{{ $kantor->longitude }}</td>
                    <td style="padding: 12px 15px; border-right: 1px solid #dee2e6;">{{ $kantor->radius }}</td>
                    <td style="padding: 12px 15px;">
                        <div class="d-flex justify-content-center gap-2">
                            <!-- Tombol Edit -->
                            <a href="{{ route('admin.office.edit', $kantor->id) }}"
                               class="btn btn-sm btn-outline-secondary d-flex align-items-center justify-content-center"
                               style="width: 35px; height: 35px;"
                               title="Edit Lokasi">
                                <i class="bi bi-pencil-fill"></i>
                            </a>

                            <!-- Tombol Hapus -->
                            <form action="{{ route('admin.office.destroy', $kantor->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus lokasi ini?');" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="btn btn-sm btn-outline-danger d-flex align-items-center justify-content-center"
                                        style="width: 35px; height: 35px;"
                                        title="Hapus Lokasi">
                                    <i class="bi bi-trash-fill"></i>
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

<!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
@endsection
