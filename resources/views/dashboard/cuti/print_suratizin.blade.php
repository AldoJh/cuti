<!DOCTYPE html>
<html>
<head>
    <title>Surat Izin</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 30px;
            line-height: 1.6;
            color: #1f2937;
            font-size: 12px;
        }

        /* HEADER */
        .header {
            display: flex;
            align-items: center;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .logo {
            flex: 0 0 80px;
        }

        .logo img {
            width: 80px;
            height: auto;
        }

        .header-text {
            flex: 1;
            text-align: center;
            line-height: 1.2;
        }

        .header-text .title {
            font-size: 13px;
            font-weight: bold;
        }

        .header-text .address {
            font-size: 8px;
            margin-top: 2px;
        }

        /* SURAT */
        .surat-title {
            text-align: center;
            font-size: 12px;
            font-weight: bold;
            margin-top: 20px;
            margin-bottom: 5px;
            text-transform: uppercase;
        }

        .surat-number {
            text-align: center;
            font-size: 12px;
            margin-bottom: 20px;
        }

        /* ISI SURAT */
        .isi-surat {
            margin-bottom: 20px;
        }

        .isi-surat ol {
            padding-left: 20px;
            margin-top: 10px;
        }

        .isi-surat li {
            margin-bottom: 8px;
        }

        /* Data Pegawai */
        .pegawai-info p {
            display: flex;
            margin: 2px 0;
        }

        .pegawai-info span.label {
            width: 140px;
            font-weight: normal;
        }

        .pegawai-info span.value {
            flex: 1;
        }

        /* TTD */
        .ttd-section {
            margin-top: 60px;
            display: flex;
            justify-content: flex-end;
            text-align: center;
        }

        .ttd {
            margin-top: 40px;
            margin-bottom: 60px;
        }

        .ttd img {
            max-height: 80px;
            display: block;
            margin: 0 auto 5px auto;
        }

        .ttd-name {
            font-weight: bold;
            font-size: 16px;
        }

        .ttd-jabatan {
            font-size: 14px;
            color: #4b5563;
        }

        .ttd-date {
            margin-bottom: 10px;
        }

        .note {
            font-style: italic;
            color: #6b7280;
        }
    </style>
</head>
<body onload="window.print()">

    <!-- HEADER -->
    <div class="header">
        <div class="logo">
            <img src="{{ asset('images/logosc.png') }}" alt="Logo PN">
        </div>
        <div class="header-text">
            <div class="title">
                MAHKAMAH AGUNG REPUBLIK INDONESIA<br>
                DIREKTORAT JENDERAL BADAN PERADILAN UMUM<br>
                PENGADILAN TINGGI BANDA ACEH<br>
                PENGADILAN NEGERI LHOKSEUMAWE
            </div>
            <div class="address">
                Jalan Iskandar Muda Nomor 44 Kp. Jawa, Kecamatan Banda Sakti<br>
                Kota Lhokseumawe, Aceh. www.pn-lhokseumawe.go.id, pn.lhokseumawe@gmail.com
            </div>
        </div>
    </div>

    <!-- JUDUL SURAT -->
    <div class="surat-title">SURAT IZIN CUTI TAHUNAN</div>
    <div class="surat-number">
        Nomor: <span style="display:inline-block; width:30px;"></span> /KPN.WI.U2/KP5.3/V/2025
    </div>

    <!-- ISI SURAT -->
    <div class="isi-surat">
        <p>1. Diberikan Cuti Tahunan Tahun {{ \Carbon\Carbon::parse($cuti->tanggal_mulai)->format('Y') }}, kepada Pegawai Negeri Sipil:</p>

        <div class="pegawai-info" style="padding-left:15px; margin-bottom:15px;">
            <p><span class="label">Nama</span>: <span class="value">{{ $user->name }}</span></p>
            <p><span class="label">NIP</span>: <span class="value">{{ $user->nip ?? '-' }}</span></p>
            <p><span class="label">Golongan</span>: <span class="value">{{ $user->golongan ?? '-' }}</span></p>
            <p><span class="label">Jabatan</span>: <span class="value">{{ $user->jabatan ?? '-' }}</span></p>
            <p><span class="label">Satuan Organisasi</span>: <span class="value">Pengadilan Negeri Lhokseumawe</span></p>
        </div>

       @php
            $diffDays = \Carbon\Carbon::parse($cuti->tanggal_mulai)
                        ->diffInDays(\Carbon\Carbon::parse($cuti->tanggal_selesai)) + 1;
            $months = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
            $startDate = \Carbon\Carbon::parse($cuti->tanggal_mulai);
            $endDate = \Carbon\Carbon::parse($cuti->tanggal_selesai);
            $startDay = $startDate->format('j');
            $endDay = $endDate->format('j');
            $month = $months[$startDate->format('n') - 1];
            $year = $startDate->format('Y');
            $numberWords = ['nol','satu','dua','tiga','empat','lima','enam','tujuh','delapan','sembilan','sepuluh'];
            $diffWords = $diffDays <= 10 ? $numberWords[$diffDays] : $diffDays;
        @endphp

        <p>
            Selama {{ $diffDays }} ({{ $diffWords }}) hari, terhitung mulai tanggal 
            <b>{{ $startDay }} s.d {{ $endDay }} {{ $month }} {{ $year }}</b>, dengan ketentuan sebagai berikut:
        </p>


        <ol type="a" style="padding-left:20px;">
            <li>Sebelum menjalankan Cuti Tahunan {{ $year }}, wajib menyerahkan pekerjaannya kepada atasan langsungnya;</li>
            <li>Setelah selesai menjalankan Cuti Tahunan {{ $year }}, wajib melaporkan diri kepada atasan langsungnya dan bekerja kembali seperti biasa.</li>
        </ol>

        <p>2. Demikianlah Surat Izin Cuti Tahunan ini dibuat untuk dapat dipergunakan sebagaimana mestinya.</p>
    </div>

    <!-- TTD -->
    <div class="ttd-section" style="justify-content: flex-end; display: flex;">
        <div style="text-align: left;">
            <!-- Tanggal -->
            <div class="ttd-date" style="margin-bottom:4px; font-size:12px;">
                Lhokseumawe, {{ \Carbon\Carbon::parse($cuti->updated_at)->format('d F Y') }}
            </div>

            <!-- Jabatan -->
            <p style="margin:0; font-size:12px;">Ketua Pengadilan Negeri Lhokseumawe</p>

            @if($showKetua && $ketua && $ketua->ttd_path)
                <div class="ttd" style="margin-top:20px;"> <!-- jarak ke ttd gambar -->
                    <img src="{{ asset('storage/'.$ketua->ttd_path) }}" alt="TTD Ketua">
                    <div class="ttd-name" style="font-size:14px;">{{ $ketua->name }}</div>
                </div>
            @else
                <p class="note" style="margin-top:20px;">(Belum ada persetujuan)</p>
            @endif
        </div>
    </div>


</body>
</html>
