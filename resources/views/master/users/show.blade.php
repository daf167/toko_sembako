@extends('layouts.app')

@section('title', 'Detail Pengguna')

@section('content')
<div class="card mb-3">
    <div class="card-body">
        <h1 class="h4">{{ $user->name }}</h1>
        <div class="text-secondary">{{ $user->email }} - {{ ucfirst($user->role) }}</div>
    </div>
</div>
<div class="table-wrap bg-white p-3">
    <h2 class="h6 mb-3">Riwayat Transaksi</h2>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead><tr><th>Tanggal</th><th>Barang</th><th>Tipe</th><th>Jumlah</th><th>Catatan</th></tr></thead>
            <tbody>
                @forelse($user->inventoryLogs as $log)
                    <tr><td>{{ $log->date->format('d/m/Y') }}</td><td>{{ $log->item->name }}</td><td>{{ $log->type }}</td><td>{{ $log->quantity }}</td><td>{{ $log->notes ?? '-' }}</td></tr>
                @empty
                    <tr><td colspan="5" class="text-center text-secondary">Belum ada transaksi.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <a class="btn btn-outline-secondary" href="{{ route('users.index') }}">Kembali</a>
</div>
@endsection
