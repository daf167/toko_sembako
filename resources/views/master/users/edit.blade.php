@extends('layouts.app')

@section('title', 'Edit Pengguna')

@section('content')
<div class="card"><div class="card-body"><form method="POST" action="{{ route('users.update', $user) }}">@method('PUT') @include('master.users._form')</form></div></div>
@endsection
