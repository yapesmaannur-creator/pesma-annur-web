@extends('layouts.vertical', ['title' => 'Daftar Pengguna'])

@section('content')

<div class="row">
    <div class="col-xl-12">

        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif
        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center gap-1">
                <h4 class="card-title flex-grow-1">Semua Pengguna</h4>
                <form action="{{ route('admin.users.index') }}" method="GET" class="d-flex me-2">
                    <input type="text" name="search" class="form-control form-control-sm" placeholder="Cari..." value="{{ request('search') }}">
                    <button type="submit" class="btn btn-sm btn-secondary ms-1"><iconify-icon icon="solar:magnifer-linear"></iconify-icon></button>
                </form>
                <a href="{{ route('admin.users.create') }}" class="btn btn-sm btn-primary text-nowrap">Tambah</a>
            </div>
            <div>
                <div class="table-responsive">
                    <table class="table align-middle mb-0 table-hover table-centered text-nowrap">
                        <thead class="bg-light-subtle">
                            <tr>
                                <th style="width: 20px;">#</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Telepon</th>
                                <th>Tanggal Daftar</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                            <tr>
                                <td>{{ method_exists($users, 'firstItem') ? ($users->firstItem() + $loop->index) : $loop->iteration }}</td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        @if($user->avatar)
                                            <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}" class="rounded-circle avatar-sm" style="object-fit: cover; border: 2px solid var(--bs-primary-bg-subtle);">
                                        @else
                                            <div class="rounded-circle bg-primary-subtle avatar-sm d-flex align-items-center justify-content-center">
                                                <span class="text-primary fw-bold fs-16">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                                            </div>
                                        @endif
                                        <span class="fw-medium">{{ $user->name }}</span>
                                    </div>
                                </td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @php
                                        $badges = [
                                            'admin' => 'bg-danger',
                                            'editor' => 'bg-primary',
                                            'pengasuh' => 'bg-dark text-white',
                                            'ustadz' => 'bg-success',
                                            'pengurus' => 'bg-warning text-dark',
                                            'santri' => 'bg-info text-dark',
                                            'alumni' => 'bg-secondary',
                                            'kontributor' => 'bg-light text-dark border'
                                        ];
                                        $badgeClass = $badges[$user->role] ?? 'bg-secondary';
                                    @endphp
                                    <span class="badge {{ $badgeClass }}">{{ $user->role_label }}</span>
                                </td>
                                <td>{{ $user->phone_number ?? '-' }}</td>
                                <td>{{ $user->created_at->format('d M Y') }}</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-soft-primary btn-sm"><iconify-icon icon="solar:pen-2-broken" class="align-middle fs-18"></iconify-icon></a>
                                        @if($user->id !== auth()->id())
                                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus pengguna ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-soft-danger btn-sm"><iconify-icon icon="solar:trash-bin-minimalistic-2-broken" class="align-middle fs-18"></iconify-icon></button>
                                        </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">Belum ada pengguna.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if($users->hasPages())
            <div class="card-footer border-top">
                <nav>{{ $users->links('pagination::bootstrap-5') }}</nav>
            </div>
            @endif
        </div>
    </div>
</div>

@endsection
