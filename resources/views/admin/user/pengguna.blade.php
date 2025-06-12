@extends('admin.main')

@section('content')
<div class="container-fluid px-4">
    <h4 class="fw-bold mb-4">Pengguna</h4>

    <div class="d-flex justify-content-between mb-3 align-items-center">
        <form method="GET" action="{{ route('admin.user.pengguna') }}" class="d-flex">
            <input type="text" name="search" class="form-control me-2 shadow-sm" placeholder="Cari nama/email" value="{{ request('search') }}">
            <button type="submit" class="btn btn-outline-primary">Cari</button>
        </form>

        <a href="{{ route('admin.user.create') }}" class="btn btn-primary shadow-sm">
            <i class="bi bi-plus-lg me-1"></i> Tambah Pengguna
        </a>
    </div>

    <div class="table-responsive">
        <table class="table mb-0" style="border-collapse: collapse; width: 100%; border: 1px solid #dee2e6; border-radius: 8px; overflow: hidden;">
            <thead style="background-color: #e9f0fb; color: #333; border-bottom: 2px solid #a0b9e8;">
                <tr class="text-center">
                    <th style="padding: 12px 15px; border-right: 1px solid #dee2e6;">Nama</th>
                    <th style="padding: 12px 15px; border-right: 1px solid #dee2e6;">Email</th>
                    <th style="padding: 12px 15px; border-right: 1px solid #dee2e6;">Posisi</th>
                    <th style="padding: 12px 15px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                <tr class="text-center" style="border-top: 1px solid #dee2e6;">
                    <td class="text-start ps-4" style="border-right: 1px solid #dee2e6; padding: 12px 15px;">{{ $user->nama }}</td>
                    <td class="text-start" style="border-right: 1px solid #dee2e6; padding: 12px 15px;">{{ $user->email }}</td>
                    <td style="border-right: 1px solid #dee2e6; padding: 12px 15px;">{{ ucfirst($user->role) }}</td>
                    <td style="padding: 12px 15px;">
                        <div class="d-flex justify-content-center gap-2">
                            <a href="{{ route('admin.user.edit', $user->id) }}" class="btn btn-sm btn-outline-secondary" title="Edit">
                                <i class="bi bi-pencil-fill"></i>
                            </a>
                            <form action="{{ route('admin.user.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger" title="Hapus">
                                    <i class="bi bi-trash-fill"></i>
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

    <div class="mt-3 d-flex justify-content-center">
        {{ $users->withQueryString()->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
