<!DOCTYPE html>
<html>
<head>
    <title>Surat Izin Cuti</title>
    <style>
        body {
            font-family: 'Bookman Old Style', serif;
            margin: 30px;
            line-height: 1.6;
            color: #000000;
            font-size: 12px;
        }

        /* HEADER */
        .header {
            display: flex;
            align-items: center;
            border-bottom: 2px solid #000;
            padding-bottom: 0px;
            margin-bottom: 30px;
        }

        .logo {
            flex: 0 0 80px;
        }

        .logo img {
            width: 90px;
            height: auto;
        }

        .header-text {
            flex: 1;
            text-align: center;
            line-height: 1.2;
        }

        .header-text .title {
            font-size: 15px;
            font-weight: bold;
        }

        .header-text .address {
            font-size: 9px;
            margin-top: 2px;
        }

        .header-text .address a {
            text-decoration: underline;
            color: #000000;
        }

        /* SURAT */
        .surat-title {
            text-align: center;
            font-size: 12px;
            font-weight: bold;
            margin-top: 20px;
            margin-bottom: 0px;
            text-transform: uppercase;
            text-decoration: underline;
        }

        .surat-number {
            text-align: center;
            font-size: 12px;
            margin-top: 0px;
            margin-bottom: 20px;
        }

        /* ISI SURAT */
        .isi-surat {
            margin-bottom: 20px;
        }

        .isi-surat p {
            margin: 6px;
        }

        .pegawai-info {
            margin: 6px 0 6px 30px;
        }

        .pegawai-info table {
            border-collapse: collapse;
        }

        .pegawai-info td {
            padding: 2px 5px;
            vertical-align: top;
        }

        .pegawai-info td.label {
            width: 160px;
        }

        .pegawai-info td.value {
            font-weight: normal;
        }

        .pegawai-info td.value.nama {
            font-weight: bold;
        }

        .aturan-cuti {
            padding-left: 40px;
            margin: 10px 0;
        }

        .aturan-cuti li {
            margin-bottom: 5px;
        }

        /* TTD */
        .ttd-section {
            margin-top: 40px;
            display: flex;
            justify-content: flex-end;
            text-align: center;
        }

        .ttd {
            margin-top: 10px;
        }

        .ttd img {
            max-height: 80px;
            display: block;
            margin: 0 auto 0 auto;
        }

        .ttd-name {
            font-weight: bold;
            font-size: 12px;
            margin-top: 0px;
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
                Kota Lhokseumawe, Aceh. <a href="http://www.pn-lhokseumawe.go.id">www.pn-lhokseumawe.go.id</a>, pn.lhokseumawe@gmail.com
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

        <div class="pegawai-info">
            <table>
                <tr>
                    <td class="label">Nama</td>
                    <td>:</td>
                    <td class="value nama">{{ $user->name }}</td>
                </tr>
                <tr>
                    <td class="label">NIP</td>
                    <td>:</td>
                    <td class="value">{{ $user->nip ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label">Pangkat / Gol. Ruang</td>
                    <td>:</td>
                    <td class="value">{{ $user->golongan ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label">Jabatan</td>
                    <td>:</td>
                    <td class="value">{{ $user->jabatan ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label">Satuan Organisasi</td>
                    <td>:</td>
                    <td class="value">Pengadilan Negeri Lhokseumawe</td>
                </tr>
            </table>
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

        <p style="margin-left: 24px;">
            Selama <span class="ttd-date">{{ $diffDays }}</span> (<i>{{ $diffWords }}</i>) hari, terhitung mulai tanggal <span style="font-weight: bold;" class="ttd-date">{{ $startDay }} s.d {{ $endDay }} {{ $month }} {{ $year }}</span>, dengan ketentuan sebagai berikut:
        </p>

        <ol type="a" class="aturan-cuti">
            <li>Sebelum menjalankan Cuti Tahunan {{ $year }}, wajib menyerahkan pekerjaannya kepada atasan langsungnya;</li>
            <li>Setelah selesai menjalankan Cuti Tahunan {{ $year }}, wajib melaporkan diri kepada atasan langsungnya dan bekerja kembali seperti biasa.</li>
        </ol>

        <p>2. Demikianlah Surat Izin Cuti Tahunan ini dibuat untuk dapat dipergunakan sebagaimana mestinya.</p>
    </div>

    <!-- TTD -->
    <div class="ttd-section">
        <div style="text-align: left;">
            <div class="ttd-date">
                Lhokseumawe, <span class="ttd-date">{{ \Carbon\Carbon::parse($cuti->updated_at)->format('d F Y') }}</span>
            </div>
            <p style="margin:0;">Ketua Pengadilan Negeri Lhokseumawe</p>

            @if($showKetua && $ketua && $ketua->ttd_path)
                <div class="ttd">
                    <img src="{{ asset('storage/'.$ketua->ttd_path) }}" alt="TTD Ketua">
                    <div class="ttd-name">{{ $ketua->name }}</div>
                </div>
            @else
                <p class="note">(Belum ada persetujuan)</p>
            @endif
        </div>
    </div>

</body>
</html>
