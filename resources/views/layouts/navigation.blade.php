<nav class="nav flex-column gap-1">
    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
        <i class="bi bi-speedometer2 me-2"></i>Dashboard
    </a>
    @if(auth()->user()->role === 'admin')
        <div class="text-uppercase small text-white-50 mt-3 mb-1 px-2">Master Data</div>
        <a class="nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}" href="{{ route('categories.index') }}">
            <i class="bi bi-tags me-2"></i>Kategori
        </a>
        <a class="nav-link {{ request()->routeIs('items.*') ? 'active' : '' }}" href="{{ route('items.index') }}">
            <i class="bi bi-box-seam me-2"></i>Barang
        </a>
        <a class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}" href="{{ route('users.index') }}">
            <i class="bi bi-people me-2"></i>Pengguna
        </a>
    @endif
    @if(in_array(auth()->user()->role, ['admin', 'staff'], true))
        <div class="text-uppercase small text-white-50 mt-3 mb-1 px-2">Transaksi</div>
        <a class="nav-link {{ request()->routeIs('inventory.*') ? 'active' : '' }}" href="{{ route('inventory.stock') }}">
            <i class="bi bi-arrow-left-right me-2"></i>Stok Masuk/Keluar
        </a>
    @endif
    <div class="text-uppercase small text-white-50 mt-3 mb-1 px-2">Laporan</div>
    <a class="nav-link {{ request()->routeIs('reports.*') ? 'active' : '' }}" href="{{ route('reports.index') }}">
        <i class="bi bi-file-earmark-text me-2"></i>Mutasi Stok
    </a>
</nav>
