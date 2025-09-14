<!DOCTYPE html>
<html>
<head>
    <title>Form Cuti</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            line-height: 1.5;
            color: #1f2937;
            font-size: 13px;
        }

        /* HEADER */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 20px;
        }

        .lampiran {
            font-size: 9px;
            line-height: 1.2;
        }

        .lampiran span {
            display: block;
            margin-left: 45px; 
            margin-top: 2px;   
        }

        /* Tanggal & Kepada Yth kanan */
        .tanggal-yth {
            text-align: left;
            font-size: 11px;
            line-height: 1.4;
            width: 250px;
        }

        .tanggal-yth .tanggal {
            margin-bottom: 1px;
        }

        .tanggal-yth .kepada {
            font-weight: bold;
            margin-bottom: 1px;
        }

        .tanggal-yth .penerima {
            font-weight: bold;
        }

        /* Judul Form */
        h3 {
            text-align: center;
            margin: 30px 0 5px 0;
            font-size: 15px;
            font-weight: normal;
        }

        .form-number {
            text-align: center;
            font-size: 11px;
            margin-bottom: 20px;
        }

        /* Tabel Umum */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 13px;
        }

        table th, table td {
            padding: 6px 8px;
            border: 1px solid #999;
            text-align: left;
            vertical-align: top;
        }

        table th {
            background-color: #f3f4f6;
            font-weight: bold;
            text-align: left;
        }

        /* Tabel centang / jenis cuti */
        .jenis-cuti-table th, .jenis-cuti-table td {
            text-align: left;
            padding: 6px 8px;
            border: 1px solid #999;
        }

        .jenis-cuti-table th {
            background-color: #f3f4f6;
            font-weight: bold;
        }

        .centang {
            font-weight: bold;
            font-size: 16px;
            text-align: center;
        }

        /* Tabel Alasan Cuti */
        .alasan-cuti-table th, .alasan-cuti-table td {
            border: 1px solid #999;
            padding: 6px 8px;
            text-align: left;
            vertical-align: top;
        }

        .alasan-cuti-table th {
            background-color: #f3f4f6;
            font-weight: bold;
        }

        /* Tabel Lamanya Cuti */
        .lamanya-cuti-table th, .lamanya-cuti-table td {
            border: 1px solid #999;
            padding: 6px 8px;
            text-align: left;
        }

        .lamanya-cuti-table th {
            background-color: #f3f4f6;
            font-weight: bold;
        }

        /* Tabel Alamat Selama Cuti */
        .alamat-cuti-table th, .alamat-cuti-table td {
            border: 1px solid #999;
            padding: 6px 8px;
            text-align: left;
            vertical-align: top;
        }

        .alamat-cuti-table th {
            background-color: #f3f4f6;
            font-weight: bold;
        }

        /* Tabel Pertimbangan */
        .pertimbangan-table th, .pertimbangan-table td {
            border: 1px solid #999;
            padding: 6px 8px;
            text-align: center;
            vertical-align: middle;
        }

        .pertimbangan-table th {
            background-color: #f3f4f6;
            font-weight: bold;
            text-align: left;
        }

        /* Tabel Keputusan Pejabat */
        .keputusan-table th, .keputusan-table td {
            border: 1px solid #999;
            padding: 6px 8px;
            text-align: center;
            vertical-align: middle;
        }

        .keputusan-table th {
            background-color: #f3f4f6;
            font-weight: bold;
            text-align: left;
        }

        /* TTD */
        .ttd img {
            max-height: 80px;
            display: block;
            margin: 0 auto 5px auto;
        }

        .ttd-name {
            font-weight: bold;
            font-size: 14px;
        }

        .ttd-jabatan {
            font-size: 12px;
            color: #4b5563;
        }

        .note {
            font-style: italic;
            color: #6b7280;
        }

        .center-text {
            text-align: center;
        }

        /* Catatan tambahan */
        .catatan {
            margin-top: 20px;
            font-size: 12px;
        }

        .catatan p {
            margin: 2px 0;
        }

    </style>
</head>
<body onload="window.print()">

    <!-- HEADER -->
    <div class="header">
        <div class="lampiran">
            Lampiran II : SURAT EDARAN SEKRETARIS MAHKAMAH AGUNG
            <span>REPUBLIK INDONESIA</span>
            <span>NOMOR 13 TAHUN 2019</span>
        </div>
        <div></div>
    </div>

    <!-- Tanggal & Kepada Yth di kanan -->
    <div style="display:flex; justify-content:flex-end; margin-bottom: 20px;">
        <div class="tanggal-yth">
            <div class="tanggal">
                Lhokseumawe, {{ \Carbon\Carbon::parse($cuti->updated_at)->format('d F Y') }}
            </div>
            <div class="kepada">
                KEPADA YTH :
            </div>
            <div class="penerima">
                BAPAK KETUA PENGADILAN NEGERI LHOKSEUMAWE DI LHOKSEUMAWE
            </div>
        </div>
    </div>

    <!-- Judul Form -->
    <h3>FORMULIR PERMINTAAN DAN PEMBERIAN CUTI</h3>
    <div class="form-number">Nomor: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/KPN.WI.U2/KP5.3/V/2025</div>

    <!-- Tabel Data Pegawai -->
    <table>
        <tr>
            <th colspan="4">I. DATA PEGAWAI</th>
        </tr>
        <tr>
            <td>Nama</td>
            <td>{{ $user->name }}</td>
            <td>NIP</td>
            <td>{{ $user->nip ?? '-' }}</td>
        </tr>
        <tr>
            <td>Jabatan</td>
            <td>{{ $user->jabatan ?? '-' }}</td>
            <td>Gol.Ruang</td>
            <td>{{ $user->golongan ?? '-' }}</td>
        </tr>
        <tr>
            <td>Unit Kerja</td>
            <td>{{ $user->unit_kerja ?? 'Pengadilan Negeri Lhokseumawe' }}</td>
            <td>Masa Kerja</td>
            <td>
                @php
                    $tanggalMasuk = \Carbon\Carbon::parse($user->tanggal_masuk ?? now());
                    $tanggalCuti = \Carbon\Carbon::parse($cuti->tanggal_mulai);
                    $masaKerja = $tanggalMasuk->diff($tanggalCuti);
                @endphp
                {{ $masaKerja->y }} tahun {{ $masaKerja->m }} bulan {{ $masaKerja->d }} hari
            </td>
        </tr>
    </table>

    <!-- Tabel Jenis Cuti -->
    <table class="jenis-cuti-table">
        <tr>
            <th colspan="4">II. JENIS CUTI YANG DI AMBIL **</th>
        </tr>
        <tr>
            <td>1. Cuti Tahunan</td>
            <td class="centang">@if($cuti->jenis_cuti == 'tahunan') &#10003; @endif</td>
            <td>2. Cuti Besar</td>
            <td class="centang">@if($cuti->jenis_cuti == 'besar') &#10003; @endif</td>
        </tr>
        <tr>
            <td>3. Cuti Sakit</td>
            <td class="centang">@if($cuti->jenis_cuti == 'sakit') &#10003; @endif</td>
            <td>4. Cuti Melahirkan</td>
            <td class="centang">@if($cuti->jenis_cuti == 'melahirkan') &#10003; @endif</td>
        </tr>
        <tr>
            <td>5. Cuti Karena Alasan Penting</td>
            <td class="centang">@if($cuti->jenis_cuti == 'alasan_penting') &#10003; @endif</td>
            <td>6. Cuti di luar Tanggungan Negara</td>
            <td class="centang">@if($cuti->jenis_cuti == 'cltn') &#10003; @endif</td>
        </tr>
    </table>

    <!-- Tabel Alasan Cuti -->
    <table class="alasan-cuti-table">
        <tr>
            <th>III. ALASAN CUTI</th>
        </tr>
        <tr>
            <td>{{ $cuti->alasan }}</td>
        </tr>
    </table>

    <!-- Tabel Lamanya Cuti -->
    @php
        $startDate = \Carbon\Carbon::parse($cuti->tanggal_mulai);
        $endDate = \Carbon\Carbon::parse($cuti->tanggal_selesai);
        $diffDays = $startDate->diffInDays($endDate) + 1;
        $numberWords = ['nol','satu','dua','tiga','empat','lima','enam','tujuh','delapan','sembilan','sepuluh'];
        $diffWords = $diffDays <= 10 ? $numberWords[$diffDays] : $diffDays;
    @endphp
    <table class="lamanya-cuti-table">
        <tr>
            <th colspan="6">IV. LAMANYA CUTI</th>
        </tr>
        <tr>
            <td>Selama</td>
            <td>{{ $diffDays }} ({{ $diffWords }}) hari</td>
            <td>Mulai tanggal</td>
            <td class="bold">{{ $startDate->format('j F Y') }}</td>
            <td class="bold">s.d</td>
            <td class="bold">{{ $endDate->format('j F Y') }}</td>
        </tr>
    </table>

    <!-- V. CATATAN CUTI -->
    @php
        $sisaTahunan = $sisaCuti['tahunan'] ?? [];
        $sisaBesar = $sisaCuti['besar'] ?? 0;
        $sisaSakit = $sisaCuti['sakit'] ?? 0;
        $sisaMelahirkan = $sisaCuti['melahirkan'] ?? 0;
        $sisaAlasanPenting = $sisaCuti['alasan_penting'] ?? 0;
        $sisaDiluarNegara = $sisaCuti['cltn'] ?? 0;
    @endphp
    <table>
        <tr>
            <th colspan="6">V. CATATAN CUTI ***</th>
        </tr>
        <tr>
            <td colspan="3">1. Cuti Tahunan</td>
            <td rowspan="2">PARAF PETUGAS CUTI</td>
            <td>2. Cuti Besar</td>
            <td>{{ $sisaBesar }}</td>
        </tr>
        <tr>
            <td>Tahun</td>
            <td>Sisa</td>
            <td>Keterangan </td>
            <td>3. Cuti Sakit</td>
            <td>{{ $sisaSakit }}</td>
        </tr>
        <tr>
            <td>2023</td>
            <td>{{ $sisaTahunan['2023'] ?? 0 }}</td>
            <td> </td>
            <td rowspan="4"></td>
            <td>4. Cuti Melahirkan</td>
            <td>{{ $sisaMelahirkan }}</td>
        </tr>
        <tr>
            <td>2024</td>
            <td>{{ $sisaTahunan['2024'] ?? 0 }}</td>
            <td> </td>
            <td>5. Cuti Karena Alasan Penting</td>
            <td>{{ $sisaAlasanPenting }}</td>
        </tr>
        <tr>
            <td>2025</td>
            <td>{{ $sisaTahunan['2025'] ?? 0 }}</td>
            <td> </td>
            <td>6. Cuti di Luar Tanggungan Negara</td>
            <td>{{ $sisaDiluarNegara }}</td>
        </tr>
    </table>
    <br>
    <br>

    <!-- VI. ALAMAT SELAMA MENJALANKAN CUTI -->
    <table class="alamat-cuti-table">
        <tr>
            <th colspan="3">VI. Alamat Selama Menjalankan Cuti</th>
        </tr>
        <tr>
            <td style="width: 65%;"></td>
            <td style="width: 10%;">Telp</td>
            <td style="width: 25%;">{{ $user->no_telp ?? '-' }}</td>
        </tr>
        <tr>
            <td class="center-text">Banda Aceh</td>
            <td colspan="2" style="padding-left: 40px; vertical-align: top; text-align: center;">
                Hormat saya,<br><br><br>
                @if($showUserTTD && $user && $user->ttd_path)
                    <img src="{{ asset('storage/'.$user->ttd_path) }}" alt="TTD User" style="height:80px; margin-bottom:5px;"><br>
                @endif
                <b>{{ $user->name }}</b><br>
                NIP. {{ $user->nip ?? '-' }}
            </td>
        </tr>
    </table>


    <!-- VII. PERTIMBANGAN ATASAN LANGSUNG -->
    <table class="pertimbangan-table">
        <tr>
            <th colspan="4">VII. Pertimbangan Atasan Langsung **</th>
        </tr>
        <tr>
            <th>DISETUJUI</th>
            <th>PERUBAHAN ****</th>
            <th>DITANGGUHKAN ***</th>
            <th>TIDAK DISETUJUI ****</th>
        </tr>
        <tr>
            <td>@if($cuti->status == 'disetujui') &#10003; @endif</td>
            <td>@if($cuti->status == 'perubahan') &#10003; @endif</td>
            <td>@if($cuti->status == 'ditangguhkan') &#10003; @endif</td>
            <td>@if($cuti->status == 'tidak_disetujui') &#10003; @endif</td>
        </tr>
        <tr>
            <td colspan="3"></td>
            <td class="center-text">
                @if($showAtasan && $atasan)
                    @if($atasan->ttd_path)
                        <img src="{{ asset('storage/'.$atasan->ttd_path) }}" alt="TTD Atasan" style="height:80px; margin-bottom:5px;"><br>
                    @endif
                    <b>{{ $atasan->name }}</b><br>
                    NIP. {{ $atasan->nip ?? '-' }}
                @endif
            </td>
        </tr>
    </table>

    <!-- VIII. KEPUTUSAN PEJABAT YANG BERWENANG MEMBERIKAN CUTI -->
    <table class="keputusan-table">
        <tr>
            <th colspan="4">VIII. Keputusan Pejabat yang Berwenang Memberikan Cuti **</th>
        </tr>
        <tr>
            <th>DISETUJUI</th>
            <th>PERUBAHAN ****</th>
            <th>DITANGGUHKAN ***</th>
            <th>TIDAK DISETUJUI ****</th>
        </tr>
        <tr>
            <td>@if($cuti->status == 'disetujui') &#10003; @endif</td>
            <td>@if($cuti->status == 'perubahan') &#10003; @endif</td>
            <td>@if($cuti->status == 'ditangguhkan') &#10003; @endif</td>
            <td>@if($cuti->status == 'tidak_disetujui') &#10003; @endif</td>
        </tr>
        <tr>
            <td colspan="3"></td>
            <td class="center-text">
                @if($showKetua && $ketua)
                    @if($ketua->ttd_path)
                        <img src="{{ asset('storage/'.$ketua->ttd_path) }}" alt="TTD Ketua" style="height:80px; margin-bottom:5px;"><br>
                    @endif
                    <b>{{ $ketua->name }}</b><br>
                    NIP. {{ $ketua->nip ?? '-' }}
                @endif
            </td>
        </tr>
    </table>

    <!-- CATATAN -->
    <div class="catatan">
        <p>Catatan :</p>
        <p>* Coret yang tidak perlu</p>
        <p>** Pilih salah satu dengan memberikan tanda centang (&#10003;)</p>
        <p>*** Disisi oleh pejabat yang menandatangani bidang kepegawaian cuti</p>
        <p>**** Diberi tanda centang</p>
    </div>

</body>
</html>
