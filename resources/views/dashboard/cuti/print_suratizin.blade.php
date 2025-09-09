<!DOCTYPE html>
<html>
<head>
    <title>Surat Izin</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 30px; }
        h3 { text-align: center; margin-bottom: 20px; }
        p { font-size: 14px; margin: 5px 0; }
        .ttd-section { margin-top: 60px; text-align: center; }
        .ttd { margin-bottom: 60px; }
    </style>
</head>
<body onload="window.print()">

    <h3>Surat Izin</h3>

    <p>Nama: <b>{{ $user->name }}</b></p>
    <p>Jenis Cuti/Izin: <b>{{ ucfirst($cuti->jenis_cuti) }}</b></p>
    <p>Tanggal: {{ $cuti->tanggal_mulai }} s/d {{ $cuti->tanggal_selesai }}</p>
    <p>Alasan: {{ $cuti->alasan }}</p>

    <div class="ttd-section">
        <p>Disetujui oleh,</p>

        {{-- TTD Ketua --}}
        @if($showKetua && $ketua && $ketua->ttd_path)
            <div class="ttd">
                <img src="{{ asset('storage/'.$ketua->ttd_path) }}" alt="TTD Ketua" style="height:80px;"><br>
                <b>{{ $ketua->name }}</b><br>
                <span>{{ $ketua->jabatan ?? 'Ketua' }}</span>
            </div>
        @else
            <p><i>(Belum ada persetujuan)</i></p>
        @endif
    </div>

</body>
</html>
