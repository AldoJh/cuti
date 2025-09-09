<!DOCTYPE html>
<html>
<head>
    <title>Form Cuti</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        h3 { text-align: center; margin-bottom: 30px; }
        p { font-size: 14px; }
        hr { margin: 30px 0; }
    </style>
</head>
<body onload="window.print()">
    <h3>Form Cuti</h3>
    <p>Nama: {{ $user->name }}</p>
    <p>Jenis Cuti: {{ $cuti->jenis_cuti }}</p>
    <p>Tanggal: {{ $cuti->tanggal_mulai }} s/d {{ $cuti->tanggal_selesai }}</p>
    <hr>
    <div style="margin-top:50px; text-align:center;">
        <p>Disetujui oleh,</p>
    
        {{-- TTD Atasan --}}
        @if($showAtasan && $atasan && $atasan->ttd_path)
            <img src="{{ asset('storage/'.$atasan->ttd_path) }}" alt="TTD Atasan" style="height:80px;"><br>
            <b>{{ $atasan->name }}</b><br>
            <span>{{ $atasan->jabatan }}</span>
            <hr>
        @endif
    
        {{-- TTD Ketua --}}
        @if($showKetua && $ketua && $ketua->ttd_path)
            <img src="{{ asset('storage/'.$ketua->ttd_path) }}" alt="TTD Ketua" style="height:80px;"><br>
            <b>{{ $ketua->name }}</b><br>
            <span>{{ $ketua->jabatan }}</span>
        @endif
    </div>
    
</body>
</html>
