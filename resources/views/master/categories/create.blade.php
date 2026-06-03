@extends('layouts.app')

@section('title', 'Tambah Kategori')

@section('content')
<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('categories.store') }}">
            @include('master.categories._form')
        </form>
    </div>
</div>
@endsection
