@extends('layouts.auth', ['title' => 'Register'])

@section('content')
<div class="auth-card" style="max-width: 500px;">
    {{-- Card Header with Branding --}}
    <div class="auth-card-header">
        @if(isset($settings['header_logo']) && $settings['header_logo'])
            <div class="auth-logo mb-2">
                <img src="{{ asset('storage/' . $settings['header_logo']) }}" alt="{{ $settings['site_name'] ?? 'Logo' }}">
            </div>
        @else
            <div class="auth-site-name mb-1">{{ $settings['site_name'] ?? 'Annur' }}</div>
        @endif
        <h4 class="mb-1">Daftar Akun Baru</h4>
        <p>Bergabunglah bersama kami sekarang</p>
    </div>

    {{-- Card Body / Form --}}
    <div class="auth-card-body">
        <form action="{{ route('register') }}" method="POST">
            @csrf

            {{-- Name --}}
            <div class="mb-3">
                <label for="name" class="form-label fw-medium fs-14">Nama Lengkap</label>
                <div class="input-group auth-input-group">
                    <span class="input-group-text border-end-0">
                        <iconify-icon icon="solar:user-id-bold-duotone" class="text-muted fs-18"></iconify-icon>
                    </span>
                    <input type="text" name="name" id="name" value="{{ old('name') }}"
                        class="form-control @error('name') is-invalid @enderror"
                        placeholder="Masukkan nama lengkap" required autofocus>
                </div>
                @error('name')
                    <div class="text-danger fs-12 mt-1">{{ $message }}</div>
                @enderror
            </div>

            {{-- Email --}}
            <div class="mb-3">
                <label for="email" class="form-label fw-medium fs-14">Alamat Email</label>
                <div class="input-group auth-input-group">
                    <span class="input-group-text border-end-0">
                        <iconify-icon icon="solar:letter-bold-duotone" class="text-muted fs-18"></iconify-icon>
                    </span>
                    <input type="email" name="email" id="email" value="{{ old('email') }}"
                        class="form-control @error('email') is-invalid @enderror"
                        placeholder="email@contoh.com" required>
                </div>
                @error('email')
                    <div class="text-danger fs-12 mt-1">{{ $message }}</div>
                @enderror
            </div>

            {{-- Password Row --}}
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="password" class="form-label fw-medium fs-14">Kata Sandi</label>
                    <div class="input-group auth-input-group">
                        <span class="input-group-text border-end-0">
                            <iconify-icon icon="solar:lock-password-bold-duotone" class="text-muted fs-18"></iconify-icon>
                        </span>
                        <input type="password" name="password" id="password"
                            class="form-control @error('password') is-invalid @enderror"
                            placeholder="Minimal 8 karakter" required>
                    </div>
                    @error('password')
                        <div class="text-danger fs-12 mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="password_confirmation" class="form-label fw-medium fs-14">Konfirmasi Sandi</label>
                    <div class="input-group auth-input-group">
                        <span class="input-group-text border-end-0">
                            <iconify-icon icon="solar:lock-password-unlocked-bold-duotone" class="text-muted fs-18"></iconify-icon>
                        </span>
                        <input type="password" name="password_confirmation" id="password_confirmation"
                            class="form-control"
                            placeholder="Ulangi sandi" required>
                    </div>
                </div>
            </div>

            {{-- Submit --}}
            <div class="d-grid mb-3 mt-1">
                <button type="submit" class="btn btn-primary auth-btn">
                    Buat Akun
                    <iconify-icon icon="solar:user-plus-bold" class="align-middle ms-1 fs-18"></iconify-icon>
                </button>
            </div>
        </form>

        <div class="text-center mt-3 text-muted fs-14">
            Sudah memiliki akun?
            <a href="{{ route('login') }}" class="text-primary fw-semibold text-decoration-none">Masuk di sini</a>
        </div>
    </div>
</div>
@endsection
