@extends('layouts.app')

@section('title', 'Edit Kategori')

@section('content')
<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('categories.update', $category) }}">
            @method('PUT')
            @include('master.categories._form')
        </form>
    </div>
</div>
@endsection
