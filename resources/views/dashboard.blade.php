@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="row g-3">
    @php
        $metrics = [
            ['label' => 'Total Barang', 'value' => $totalItems, 'icon' => 'bi-box', 'class' => 'bg-primary-subtle text-primary'],
            ['label' => 'Total Stok Masuk', 'value' => $totalStockIn, 'icon' => 'bi-arrow-down-circle', 'class' => 'bg-success-subtle text-success'],
            ['label' => 'Total Stok Keluar', 'value' => $totalStockOut, 'icon' => 'bi-arrow-up-circle', 'class' => 'bg-warning-subtle text-warning'],
            ['label' => 'Stok Kritis', 'value' => $criticalStock, 'icon' => 'bi-exclamation-triangle', 'class' => 'bg-danger-subtle text-danger'],
            ['label' => 'Stok Tertinggi', 'value' => $highestStockItem ? $highestStockItem->current_stock : 0, 'icon' => 'bi-bar-chart', 'class' => 'bg-info-subtle text-info'],
        ];
    @endphp
    @foreach($metrics as $metric)
        <div class="col-12 col-md-6 col-xl">
            <div class="card h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="metric-icon {{ $metric['class'] }}"><i class="bi {{ $metric['icon'] }}"></i></div>
                    <div>
                        <div class="text-secondary small">{{ $metric['label'] }}</div>
                        <div class="fs-4 fw-semibold">{{ $metric['value'] }}</div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
<div class="row g-3 mt-1">
    <div class="col-12 col-xl-6">
        <div class="card h-100">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h2 class="h5 mb-0">5 Stok Tertinggi</h2>
                    <span class="badge text-bg-info">Top Stock</span>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Barang</th>
                                <th>Kategori</th>
                                <th class="text-end">Stok</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($highestStockItems as $item)
                                <tr>
                                    <td>
                                        <div class="fw-semibold">{{ $item->name }}</div>
                                        <div class="small text-secondary">{{ $item->item_code }}</div>
                                    </td>
                                    <td>{{ $item->category->name }}</td>
                                    <td class="text-end fw-semibold">{{ $item->current_stock }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="3" class="text-center text-secondary">Belum ada data barang.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-xl-6">
        <div class="card h-100">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h2 class="h5 mb-0">5 Stok Terendah</h2>
                    <span class="badge text-bg-danger">Low Stock</span>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Barang</th>
                                <th>Kategori</th>
                                <th class="text-end">Stok</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($lowestStockItems as $item)
                                <tr>
                                    <td>
                                        <div class="fw-semibold">{{ $item->name }}</div>
                                        <div class="small text-secondary">{{ $item->item_code }}</div>
                                    </td>
                                    <td>{{ $item->category->name }}</td>
                                    <td class="text-end fw-semibold">{{ $item->current_stock }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="3" class="text-center text-secondary">Belum ada data barang.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
