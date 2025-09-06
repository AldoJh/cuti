@extends('layouts.app')

@section('content')
<div class="section-header">
  <h1>Dashboard</h1>
</div>

<div class="section-body">
  <p>Selamat datang, {{ Auth::user()->name }} 👋</p>
  <p>Silakan pilih menu pengajuan cuti atau persetujuan cuti.</p>
</div>
@if(!in_array(Auth::user()->role, ['admin']))
    <div>
      <h4>Sisa Cuti Tahunan: {{ $sisaCutiTahunan }} hari</h4>
      <h4>Sisa Cuti Sakit: {{ $sisaCutiSakit }} hari</h4>
    </div>
  @endif
@endsection

@section('scripts')
<script>
  @if(session('success'))
    swal({
      title: "Berhasil!",
      text: "{{ session('success') }}",
      icon: "success",
      buttons: false,
      timer: 3000
    });
  @endif

  @if(session('error'))
    swal({
      title: "Gagal!",
      text: "{{ session('error') }}",
      icon: "error",
      buttons: false,
      timer: 3000
    });
  @endif
</script>
@endsection
