@extends('layouts.app')

@section('title', 'Tambah Pengguna')

@section('content')
<div class="card"><div class="card-body"><form method="POST" action="{{ route('users.store') }}">@include('master.users._form')</form></div></div>
@endsection
