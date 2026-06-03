@extends('layouts.app')

@section('title', 'Laporan Mutasi Stok')

@section('content')
<div class="card mb-3">
    <div class="card-body">
        <form class="row g-3 align-items-end" method="GET" action="{{ route('reports.index') }}">
            <div class="col-md-4">
                <label class="form-label" for="start_date">Start Date</label>
                <input class="form-control" id="start_date" name="start_date" type="date" value="{{ $filters['start_date'] ?? '' }}">
            </div>
            <div class="col-md-4">
                <label class="form-label" for="end_date">End Date</label>
                <input class="form-control" id="end_date" name="end_date" type="date" value="{{ $filters['end_date'] ?? '' }}">
            </div>
            <div class="col-md-4 d-flex gap-2">
                <button class="btn btn-primary" type="submit"><i class="bi bi-funnel me-1"></i>Filter</button>
                <a class="btn btn-outline-secondary" href="{{ route('reports.index') }}">Reset</a>
            </div>
        </form>
    </div>
</div>
<div class="table-wrap bg-white p-3">
    @include('components.table-controls', ['paginator' => $logs, 'perPage' => $perPage, 'id' => 'reports_per_page'])
    <div class="table-responsive">
        <table class="table table-hover">
            <thead><tr><th>Tanggal</th><th>Kode</th><th>Barang</th><th>Kategori</th><th>Tipe</th><th>Jumlah</th><th>Stok Awal</th><th>Stok Akhir</th><th>Petugas</th><th>Catatan</th></tr></thead>
            <tbody>
                @forelse($logs as $log)
                    @php
                        $itemCode = $log->item?->item_code ?? $log->item_code_snapshot ?? '-';
                        $itemName = $log->item?->name ?? ($log->item_name_snapshot ? 'Produk dihapus - '.$log->item_name_snapshot : 'Produk dihapus');
                        $categoryName = $log->item?->category?->name ?? $log->category_name_snapshot ?? '-';
                    @endphp
                    <tr>
                        <td>{{ $log->date->format('d/m/Y') }}</td>
                        <td>{{ $itemCode }}</td>
                        <td class="fw-semibold">{{ $itemName }}</td>
                        <td>{{ $categoryName }}</td>
                        <td><span class="badge {{ $log->type === 'masuk' ? 'text-bg-success' : 'text-bg-warning' }}">{{ $log->type }}</span></td>
                        <td>{{ $log->quantity }}</td>
                        <td>{{ $log->stock_before ?? '-' }}</td>
                        <td>{{ $log->stock_after ?? '-' }}</td>
                        <td>{{ $log->user->name }}</td>
                        <td>{{ $log->notes ?? '-' }}</td>
                    </tr>
                @empty
                    <tr><td colspan="10" class="text-center text-secondary">Tidak ada data laporan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-3">
        {{ $logs->links() }}
    </div>
</div>
@endsection
