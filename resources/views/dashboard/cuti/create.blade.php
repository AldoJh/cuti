@extends('layouts.app')

@section('content')
<div class="section-header">
  <h1>Form Pengajuan Cuti</h1>
</div>

<div class="section-body">
  <div class="card">
    <div class="card-header">
      <h4>Ajukan Cuti</h4>
    </div>
    <div class="card-body">
      <form action="{{ route('cuti.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
          <label>Jenis Cuti</label>
          <select name="jenis_cuti" id="jenis_cuti" class="form-control" required>
            <option value="">-- Pilih --</option>
            <option value="tahunan">Cuti Tahunan</option>
            <option value="sakit">Cuti Sakit</option>
          </select>
        </div>

        <div class="form-group">
          <label>Tanggal Mulai</label>
          <input type="date" name="tanggal_mulai" class="form-control" required>
        </div>

        <div class="form-group">
          <label>Tanggal Selesai</label>
          <input type="date" name="tanggal_selesai" class="form-control" required>
        </div>

        <div class="form-group">
          <label>Alasan</label>
          <textarea name="alasan" class="form-control" required></textarea>
        </div>

        <!-- Input surat sakit -->
        <div class="form-group" id="surat_sakit_group" style="display:none;">
          <label>Unggah Surat Cuti Sakit</label>
          <input type="file" name="surat_sakit" class="form-control">
          <small class="text-muted">Hanya wajib untuk cuti sakit. Format: pdf/jpg/png, max 2MB.</small>
        </div>

        <button type="submit" class="btn btn-primary">Ajukan</button>
      </form>
    </div>
  </div>
</div>

<script>
  const jenisCuti = document.getElementById('jenis_cuti');
  const suratGroup = document.getElementById('surat_sakit_group');

  jenisCuti.addEventListener('change', function() {
    if (this.value === 'sakit') {
      suratGroup.style.display = 'block';
    } else {
      suratGroup.style.display = 'none';
    }
  });
</script>
@endsection
