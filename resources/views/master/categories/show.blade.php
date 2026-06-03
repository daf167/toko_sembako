@extends('layouts.app')

@section('title', 'Detail Kategori')

@section('content')
<div class="card mb-3">
    <div class="card-body">
        <h1 class="h4">{{ $category->name }}</h1>
        <p class="text-secondary mb-0">{{ $category->description ?? 'Tidak ada deskripsi.' }}</p>
    </div>
</div>
<div class="table-wrap bg-white p-3">
    <h2 class="h6 mb-3">Barang dalam kategori ini</h2>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead><tr><th>Kode</th><th>Nama</th><th>Stok</th><th>Status</th></tr></thead>
            <tbody>
                @forelse($category->items as $item)
                    <tr><td>{{ $item->item_code }}</td><td>{{ $item->name }}</td><td>{{ $item->current_stock }}</td><td>{{ $item->status }}</td></tr>
                @empty
                    <tr><td colspan="4" class="text-center text-secondary">Belum ada barang.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <a class="btn btn-outline-secondary" href="{{ route('categories.index') }}">Kembali</a>
</div>
@endsection
