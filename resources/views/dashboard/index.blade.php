@extends('layouts.app')

@section('content')
<div class="section-header">
  <h1>Dashboard</h1>
</div>
<div class="section-body">
  <p>Selamat datang, {{ Auth::user()->name }} 👋</p>
  <p>Silakan pilih menu pengajuan cuti atau persetujuan cuti.</p>
</div>
@endsection
