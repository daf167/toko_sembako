@extends('layouts.app')

@section('title', 'Pengguna')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h4 mb-0">Pengguna</h1>
    <a class="btn btn-primary" href="{{ route('users.create') }}"><i class="bi bi-plus-lg me-1"></i>Tambah</a>
</div>
<div class="table-wrap bg-white p-3">
    @include('components.table-controls', ['paginator' => $users, 'perPage' => $perPage, 'id' => 'users_per_page'])
    <div class="table-responsive">
        <table class="table table-hover">
            <thead><tr><th>Nama</th><th>Email</th><th>Role</th><th class="text-end">Aksi</th></tr></thead>
            <tbody>
                @forelse($users as $user)
                    <tr>
                        <td class="fw-semibold">{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td><span class="badge text-bg-light text-capitalize">{{ $user->role }}</span></td>
                        <td class="text-end">
                            <a class="btn btn-sm btn-outline-info" href="{{ route('users.show', $user) }}">View Detail</a>
                            <a class="btn btn-sm btn-outline-primary" href="{{ route('users.edit', $user) }}">Edit</a>
                            <form class="d-inline" method="POST" action="{{ route('users.destroy', $user) }}" onsubmit="return confirm('Hapus pengguna ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger" type="submit">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center text-secondary">Belum ada pengguna.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-3">
        {{ $users->links() }}
    </div>
</div>
@endsection
