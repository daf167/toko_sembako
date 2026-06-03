@extends('layouts.app')

@section('title', 'Tambah Barang')

@section('content')
<div class="card"><div class="card-body"><form method="POST" action="{{ route('items.store') }}">@include('master.items._form')</form></div></div>
@endsection
