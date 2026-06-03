@extends('layouts.app')

@section('title', 'Edit Barang')

@section('content')
<div class="card"><div class="card-body"><form method="POST" action="{{ route('items.update', $item) }}">@method('PUT') @include('master.items._form')</form></div></div>
@endsection
