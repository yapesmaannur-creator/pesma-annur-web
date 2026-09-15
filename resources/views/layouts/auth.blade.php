<!DOCTYPE html>
<html lang="id">
<head>
    @include('layouts.partials.title-meta', ['title' => $title ?? 'Login'])
    @include('layouts.partials.head-css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @yield('css')
    @stack('styles')
</head>
<body class="authentication-bg position-relative">

    @yield('content')

    @include("layouts.partials.footer-scripts")
    @vite(['resources/js/app.js','resources/js/layout.js'])
    @yield('script')
    @stack('scripts')
</body>
</html>
