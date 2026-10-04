<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Ruang Kata') — BlogCRUD</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <header class="site-header">
        <nav class="nav-shell" aria-label="Navigasi utama">
            <a class="brand" href="{{ route('posts.index') }}"><span class="brand-mark">R</span> ruangkata</a>
            <a class="nav-link" href="{{ route('posts.index') }}">Semua artikel</a>
            <a class="button button-primary nav-cta" href="{{ route('posts.create') }}">Tulis artikel <span aria-hidden="true">↗</span></a>
        </nav>
    </header>

    <main class="page-shell">
        @if (session('success'))
            <x-alert type="success">{{ session('success') }}</x-alert>
        @endif

        @if (session('error'))
            <x-alert type="error">{{ session('error') }}</x-alert>
        @endif

        @if ($errors->any())
            <x-alert type="error">Ada isian yang perlu diperiksa. Perbaiki kolom yang ditandai, lalu coba lagi.</x-alert>
        @endif

        @yield('content')
    </main>

    <footer class="site-footer">
        <div class="footer-shell">
            <a class="brand footer-brand" href="{{ route('posts.index') }}"><span class="brand-mark">R</span> ruangkata</a>
            <p>Tempat ide sederhana menemukan kata-katanya.</p>
            <span>BlogCRUD · Laravel</span>
        </div>
    </footer>
</body>
</html>
