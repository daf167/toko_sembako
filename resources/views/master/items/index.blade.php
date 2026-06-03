@extends('layouts.app')

@section('title', 'Barang')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h4 mb-0">{{ in_array(auth()->user()->role, ['staff', 'owner'], true) ? 'Daftar Produk' : 'Barang' }}</h1>
    @if(auth()->user()->role === 'admin')
        <a class="btn btn-primary" href="{{ route('items.create') }}"><i class="bi bi-plus-lg me-1"></i>Tambah</a>
    @endif
</div>
<div class="table-wrap bg-white p-3">
    @include('components.table-controls', ['paginator' => $items, 'perPage' => $perPage, 'id' => 'items_per_page'])
    <div class="table-responsive">
        <table class="table table-hover">
            <thead><tr><th>Kode</th><th>Nama</th><th>Kategori</th><th>Stok</th><th>Minimum</th><th>Status</th><th class="text-end">Aksi</th></tr></thead>
            <tbody>
                @forelse($items as $item)
                    <tr>
                        <td>{{ $item->item_code }}</td>
                        <td class="fw-semibold">{{ $item->name }}</td>
                        <td>{{ $item->category->name }}</td>
                        <td>{{ $item->current_stock }}</td>
                        <td>{{ $item->lowest_stock_threshold }}</td>
                        <td><span class="badge {{ $item->status === 'tersedia' ? 'text-bg-success' : 'text-bg-secondary' }}">{{ $item->status }}</span></td>
                        <td class="text-end">
                            <a class="btn btn-sm btn-outline-info" href="{{ route('items.show', $item) }}">View Detail</a>
                            @if(auth()->user()->role === 'admin')
                                <a class="btn btn-sm btn-outline-primary" href="{{ route('items.edit', $item) }}">Edit</a>
                                <form class="d-inline" method="POST" action="{{ route('items.destroy', $item) }}" onsubmit="return confirm('Barang hanya bisa dihapus jika stok sudah 0. Lanjutkan?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger" type="submit">Delete</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center text-secondary">Belum ada barang.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-3">
        {{ $items->links() }}
    </div>
</div>
@endsection
