@extends('admin.main')

@section('content')
<div class="container-fluid px-3">
    <h4 class="fw-bold mb-4">Daftar Pengguna</h4>

    {{-- Form Cari & Tombol Tambah --}}
    <div class="d-flex justify-content-between flex-wrap gap-2 mb-3 align-items-center">
        <form method="GET" action="{{ route('admin.user.pengguna') }}" style="max-width: 350px;" class="w-100 position-relative">
            <input type="text"
                name="search"
                class="form-control shadow-sm ps-4 pe-5 rounded-pill"
                placeholder="Cari nama atau email..."
                value="{{ request('search') }}"
                style="height: 42px; border: 1px solid #ced4da;">
            <button type="submit"
                    class="position-absolute top-50 end-0 translate-middle-y me-3 btn p-0 border-0 bg-transparent">
                <i class="bi bi-search text-primary fs-5"></i>
            </button>
        </form>

        <a href="{{ route('admin.user.create') }}" class="btn btn-primary shadow-sm">
            <i class="bi bi-plus-lg me-1"></i> Tambah Pengguna
        </a>
    </div>

    {{-- Tabel --}}
    <div class="card shadow-sm rounded-4 p-4 border-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle custom-table mb-0">
                <thead>
                    <tr class="text-center">
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Posisi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                    <tr class="text-center">
                        <td class="fw-semibold text-center ps-4">{{ $user->nama }}</td>
                        <td class="text-center">{{ $user->email }}</td>
                        <td>
                            <span class="badge bg-light text-dark rounded-pill px-3 py-2">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        <td>
                            <div class="d-flex justify-content-center gap-2">
                                {{-- Edit --}}
                                <a href="{{ route('admin.user.edit', $user->id) }}"
                                   class="btn btn-sm btn-outline-success"
                                   title="Edit Pengguna">
                                    <i class="bi bi-pencil-square"></i>
                                </a>

                                {{-- Hapus --}}
                                <form action="{{ route('admin.user.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="btn btn-sm btn-outline-danger"
                                            title="Hapus Pengguna">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted py-4">Data tidak ditemukan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Pagination --}}
    <div class="mt-3 d-flex justify-content-center">
        {{ $users->withQueryString()->links('pagination::bootstrap-5') }}
    </div>
</div>

{{-- Style --}}
<style>
    .custom-table thead {
        background-color: #e9f0fb;
        color: #333;
        border-bottom: 2px solid #a0b9e8;
    }

    .custom-table th,
    .custom-table td {
        padding: 12px 15px;
        vertical-align: middle;
    }

</style>
@endsection
