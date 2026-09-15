<!-- Title Meta -->
<meta charset="utf-8" />
<title>{{ $title ?? 'Admin Panel' }} | {{ \App\Models\Setting::getByKey('site_name', 'Pesantren Mahasiswa An-Nur') }}</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="{{ \App\Models\Setting::getByKey('site_description', 'Sistem Informasi Manajemen Terpadu Pesantren Mahasiswa An-Nur Surabaya.') }}" />
<meta name="author" content="Pesma An-Nur" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />

<!-- App favicon -->
@php
    $favicon = \App\Models\Setting::getByKey('favicon');
    $faviconUrl = $favicon ? asset('storage/' . $favicon) : asset('images/favicon.ico');
@endphp
<link rel="shortcut icon" href="{{ $faviconUrl }}">
<link rel="icon" href="{{ $faviconUrl }}" type="image/x-icon">
