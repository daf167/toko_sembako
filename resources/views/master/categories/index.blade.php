@extends('layouts.app')

@section('title', 'Kategori')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h4 mb-0">Kategori</h1>
    <a class="btn btn-primary" href="{{ route('categories.create') }}"><i class="bi bi-plus-lg me-1"></i>Tambah</a>
</div>
<div class="table-wrap bg-white p-3">
    @include('components.table-controls', ['paginator' => $categories, 'perPage' => $perPage, 'id' => 'categories_per_page'])
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Deskripsi</th>
                    <th>Jumlah Barang</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                    <tr>
                        <td class="fw-semibold">{{ $category->name }}</td>
                        <td>{{ $category->description ?? '-' }}</td>
                        <td>{{ $category->items_count }}</td>
                        <td class="text-end">
                            <a class="btn btn-sm btn-outline-info" href="{{ route('categories.show', $category) }}">View Detail</a>
                            <a class="btn btn-sm btn-outline-primary" href="{{ route('categories.edit', $category) }}">Edit</a>
                            <form class="d-inline" method="POST" action="{{ route('categories.destroy', $category) }}" onsubmit="return confirm('Kategori hanya bisa dihapus jika semua stok barang di dalamnya sudah 0. Lanjutkan?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger" type="submit">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center text-secondary">Belum ada kategori.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-3">
        {{ $categories->links() }}
    </div>
</div>
@endsection
