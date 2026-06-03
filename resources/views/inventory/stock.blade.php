@extends('layouts.app')

@section('title', 'Stok Masuk/Keluar')

@section('content')
<div class="row g-4">
    <div class="col-lg-5">
        <div class="card">
            <div class="card-body">
                <h1 class="h5 mb-3">Form Transaksi Stok</h1>
                <form method="POST" action="{{ route('inventory.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label" for="item_id">Barang</label>
                        <select class="form-select" id="item_id" name="item_id" required>
                            <option value="">Pilih barang</option>
                            @foreach($items as $item)
                                <option value="{{ $item->id }}" @selected(old('item_id') == $item->id)>{{ $item->name }} - stok {{ $item->current_stock }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="type">Tipe Transaksi</label>
                        <select class="form-select" id="type" name="type" required>
                            <option value="masuk" @selected(old('type') === 'masuk')>Stok Masuk</option>
                            <option value="keluar" @selected(old('type') === 'keluar')>Stok Keluar</option>
                        </select>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label" for="quantity">Jumlah</label>
                            <input class="form-control" id="quantity" name="quantity" type="number" min="1" value="{{ old('quantity', 1) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="date">Tanggal</label>
                            <input class="form-control" id="date" name="date" type="date" value="{{ old('date', now()->toDateString()) }}" required>
                        </div>
                    </div>
                    <div class="mt-3 mb-4">
                        <label class="form-label" for="notes">Catatan</label>
                        <textarea class="form-control" id="notes" name="notes" rows="3">{{ old('notes') }}</textarea>
                    </div>
                    <button class="btn btn-primary" type="submit"><i class="bi bi-save me-1"></i>Simpan Transaksi</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-7">
        <div class="table-wrap bg-white p-3">
            <h2 class="h5 mb-3">Transaksi Terbaru</h2>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead><tr><th>Tanggal</th><th>Barang</th><th>Tipe</th><th>Jumlah</th><th>Petugas</th></tr></thead>
                    <tbody>
                        @forelse($logs as $log)
                            <tr><td>{{ $log->date->format('d/m/Y') }}</td><td>{{ $log->item->name }}</td><td>{{ $log->type }}</td><td>{{ $log->quantity }}</td><td>{{ $log->user->name }}</td></tr>
                        @empty
                            <tr><td colspan="5" class="text-center text-secondary">Belum ada transaksi.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
