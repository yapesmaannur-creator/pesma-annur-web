@extends('layouts.auth', ['title' => 'Login'])

@section('content')
<div class="d-flex flex-column min-vh-100">
    <div class="row g-0 justify-content-center align-items-center flex-grow-1">
        <div class="col-xl-4 col-lg-5 col-md-7 mx-auto">
            <div class="card overflow-hidden">
                <div class="row g-0">
                    <div class="col-lg-12">
                        <div class="p-4 p-lg-5">
                            <div class="text-center mb-4">
                                @if(isset($settings['header_logo']) && $settings['header_logo'])
                                    <a href="{{ url('/') }}">
                                        <img src="{{ asset('storage/' . $settings['header_logo']) }}" alt="{{ $settings['site_name'] ?? 'Logo' }}" height="50">
                                    </a>
                                @else
                                    <a href="{{ url('/') }}" class="d-inline-block">
                                        <h3 class="fw-bold text-primary mb-0">{{ $settings['site_name'] ?? 'Pesma An-Nur' }}</h3>
                                    </a>
                                @endif
                            </div>

                            <div class="text-center mb-4">
                                <h4 class="fw-semibold fs-20">Selamat Datang!</h4>
                                <p class="text-muted mb-0">Masuk untuk mengakses panel administrasi</p>
                            </div>

                            @if(session('status'))
                                <div class="alert alert-success border-0 py-2 mb-3 fs-13">{{ session('status') }}</div>
                            @endif

                            <form action="{{ route('login') }}" method="POST">
                                @csrf

                                <div class="mb-3">
                                    <label for="email" class="form-label">Alamat Email</label>
                                    <input type="email" name="email" id="email" value="{{ old('email') }}"
                                        class="form-control @error('email') is-invalid @enderror"
                                        placeholder="Email Anda" required autofocus>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <label for="password" class="form-label mb-0">Kata Sandi</label>
                                        @if (Route::has('password.request'))
                                            <a href="{{ route('password.request') }}" class="text-muted fs-13">Lupa Sandi?</a>
                                        @endif
                                    </div>
                                    <input type="password" name="password" id="password"
                                        class="form-control @error('password') is-invalid @enderror"
                                        placeholder="Kata sandi" required>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3 form-check">
                                    <input type="checkbox" class="form-check-input" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="remember">Ingat Saya</label>
                                </div>

                                <div class="mb-0 d-grid">
                                    <button class="btn btn-primary" type="submit">
                                        <i class="mdi mdi-login me-1"></i> Masuk
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-4">
                <p class="text-muted fs-13 mb-0">
                    &copy; {{ date('Y') }} {{ $settings['site_name'] ?? 'Pesma An-Nur' }}.
                    @if(isset($settings['credit_text']) && $settings['credit_text'])
                        Dibuat oleh <a href="{{ $settings['credit_link'] ?? '#' }}" target="_blank" class="text-dark fw-medium">{{ $settings['credit_text'] }}</a>
                    @endif
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
