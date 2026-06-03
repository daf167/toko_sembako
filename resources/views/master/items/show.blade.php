@extends('layouts.app')

@section('title', 'Detail Barang')

@section('content')
<div class="card mb-3">
    <div class="card-body">
        <h1 class="h4">{{ $item->name }}</h1>
        <div class="row g-3 mt-1">
            <div class="col-md-3"><div class="text-secondary small">Kode</div><div class="fw-semibold">{{ $item->item_code }}</div></div>
            <div class="col-md-3"><div class="text-secondary small">Kategori</div><div class="fw-semibold">{{ $item->category->name }}</div></div>
            <div class="col-md-3"><div class="text-secondary small">Stok</div><div class="fw-semibold">{{ $item->current_stock }}</div></div>
            <div class="col-md-3"><div class="text-secondary small">Status</div><div class="fw-semibold">{{ $item->status }}</div></div>
        </div>
    </div>
</div>
<div class="table-wrap bg-white p-3">
    <h2 class="h6 mb-3">Riwayat Mutasi</h2>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead><tr><th>Tanggal</th><th>Tipe</th><th>Jumlah</th><th>Stok Awal</th><th>Stok Akhir</th><th>Petugas</th><th>Catatan</th></tr></thead>
            <tbody>
                @forelse($item->inventoryLogs as $log)
                    <tr><td>{{ $log->date->format('d/m/Y') }}</td><td>{{ $log->type }}</td><td>{{ $log->quantity }}</td><td>{{ $log->stock_before ?? '-' }}</td><td>{{ $log->stock_after ?? '-' }}</td><td>{{ $log->user->name }}</td><td>{{ $log->notes ?? '-' }}</td></tr>
                @empty
                    <tr><td colspan="7" class="text-center text-secondary">Belum ada mutasi.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <a class="btn btn-outline-secondary" href="{{ route('items.index') }}">Kembali</a>
</div>
@endsection
