<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Persediaan Sembako')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body { background: #f5f7fb; color: #263238; }
        .app-shell { min-height: 100vh; }
        .sidebar, .mobile-menu { background: #18202b; }
        .sidebar { width: 270px; flex: 0 0 270px; }
        .sidebar .nav-link, .mobile-menu .nav-link { color: #b8c2cc; border-radius: 6px; padding: .7rem .85rem; }
        .sidebar .nav-link:hover, .sidebar .nav-link.active,
        .mobile-menu .nav-link:hover, .mobile-menu .nav-link.active { color: #fff; background: #2b6cb0; }
        .content { min-width: 0; }
        .topbar { background: #fff; border-bottom: 1px solid #e5e9f0; }
        .page-body { padding: 1.5rem; }
        .card, .table-wrap { border: 1px solid #e5e9f0; border-radius: 8px; box-shadow: 0 8px 24px rgba(38, 50, 56, .04); }
        .metric-icon { width: 42px; height: 42px; display: grid; place-items: center; border-radius: 8px; }
        .table > :not(caption) > * > * { vertical-align: middle; }
        @media (max-width: 991.98px) {
            .sidebar { display: none; }
            .topbar { align-items: flex-start !important; flex-wrap: wrap; padding: 1rem !important; }
            .topbar-title { min-width: 0; flex: 1 1 calc(100% - 56px); }
            .topbar-title .small { display: none; }
            .topbar-user { width: 100%; justify-content: space-between; }
            .page-body { padding: 1rem; }
            .metric-icon { width: 40px; height: 40px; }
            .card-body { padding: 1rem; }
        }
    </style>
</head>
<body>
<div class="app-shell d-flex">
    <aside class="sidebar p-3">
        <div class="text-white fw-semibold fs-5 mb-4">Toko Sembako</div>
        @include('layouts.navigation')
    </aside>
    <main class="content flex-grow-1">
        <nav class="topbar px-4 py-3 d-flex align-items-center justify-content-between gap-3">
            <button class="btn btn-outline-secondary d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileSidebar" aria-controls="mobileSidebar" aria-label="Buka menu">
                <i class="bi bi-list"></i>
            </button>
            <div class="topbar-title">
                <div class="fw-semibold">@yield('title', 'Persediaan Sembako')</div>
                <div class="small text-secondary">Aplikasi Persediaan Barang Toko Sembako</div>
            </div>
            <div class="topbar-user d-flex align-items-center gap-3">
                <div class="text-end">
                    <div class="fw-semibold">{{ auth()->user()->name }}</div>
                    <div class="small text-secondary text-capitalize">{{ auth()->user()->role }}</div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="btn btn-outline-secondary btn-sm" type="submit"><i class="bi bi-box-arrow-right me-1"></i>Logout</button>
                </form>
            </div>
        </nav>
        <div class="page-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
                </div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @yield('content')
        </div>
    </main>
</div>
<div class="offcanvas offcanvas-start mobile-menu text-white" tabindex="-1" id="mobileSidebar" aria-labelledby="mobileSidebarLabel">
    <div class="offcanvas-header">
        <div class="offcanvas-title fw-semibold fs-5" id="mobileSidebarLabel">Toko Sembako</div>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Tutup"></button>
    </div>
    <div class="offcanvas-body pt-0">
        @include('layouts.navigation')
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
