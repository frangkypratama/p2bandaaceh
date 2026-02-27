<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>{{ $pemeriksaanBadan->no_ba_riksa ?? '-' }}</title>
    <style>
        /* ===== PAGE ===== */
        @page {
            size: 215mm 330mm;
            margin: 15mm;
        }

        /* ===== BASE ===== */
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 11pt;
            line-height: 1.2;
            color: #000;
        }

        p { margin: 0; }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td { vertical-align: top; }

        /* ===== HEADER ===== */
        .header-table td {
            border-bottom: 2px solid #000;
            padding-bottom: 8px;
        }

        .logo { width: 90px; }

        .header-text { text-align: center; }
        .header-text h1 { font-size: 13pt; margin: 0; }
        .header-text h2 { font-size: 11pt; margin: 0; }
        .header-text p  { font-size: 8pt; margin-top: 4px; line-height: 1.1; }

        /* ===== TITLE ===== */
        .title { text-align: center; margin: 12px 0; }
        .title h3 {
            font-size: 12pt;
            text-decoration: underline;
            margin: 0 0 4px 0;
        }
        .title p {
            font-size: 11pt;
            margin: 0;
        }

        /* ===== CONTENT TABLE ===== */
        .content-table { margin-top: 12px; }
        .content-table td { padding: 2px; line-height: 1.2; }

        .label  { width: 220px; }
        .colon  { width: 10px; }
        .value  { text-align: justify; word-wrap: break-word; }

        .full-width {
            text-align: justify;
            line-height: 1.2;
            padding: 8px 0;
        }

        /* ===== SIGNATURE ===== */
        .signature { margin-top: 20px; }
        .signature td    { padding: 2px; }
        .signature .num  { width: 20px; }
        .signature .sig-left  { width: 50%; }
        .signature .sig-right { width: 50%; }
        .name { margin-top: 60px; }
        .nip  { margin: 0; }
    </style>
</head>

<body>
    <!-- HEADER -->
    <table class="header-table">
        <tbody>
            <tr>
                <td class="logo"><img src="{{ public_path('assets/img/logo-kemenkeu.png') }}" width="87"></td>
                <td class="header-text">
                    <h1>KEMENTERIAN KEUANGAN REPUBLIK INDONESIA</h1>
                    <h2>DIREKTORAT JENDERAL BEA DAN CUKAI</h2>
                    <h2>KANTOR WILAYAH DIREKTORAT JENDERAL BEA DAN CUKAI ACEH</h2>
                    <h2>KANTOR PENGAWASAN DAN PELAYANAN BEA DAN CUKAI TIPE MADYA PABEAN C BANDA ACEH</h2>
                    <p>Jalan Soekarno Hatta Nomor 3a, Geuceu Menara, Banda Aceh 23241;<br>TELEPON (0651) 43137; FAKSIMILE (0651) 43136; LAMAN www.beacukai.go.id; PUSAT KONTAK LAYANAN 1500225; SUREL bcaceh@customs.go.id</p>
                </td>
            </tr>
        </tbody>
    </table>

    <!-- TITLE -->
    <div class="title">
        <h3>BERITA ACARA PEMERIKSAAN BADAN</h3>
        <p>Nomor : {{ $pemeriksaanBadan->no_ba_riksa ?? '-' }}</p>
    </div>

    <!-- INTRO -->
    <p class="full-width">
        Pada hari ini {{ optional($pemeriksaanBadan->tgl_ba_riksa)->translatedFormat('l') ?? '-' }} tanggal {{ $pemeriksaanBadan->tanggal_ba_riksa_terbilang }}, berdasarkan Surat Perintah Kepala KPPBC Tipe Madya Pabean C Banda Aceh Nomor {{ $pemeriksaanBadan->no_surat_perintah ?? '-' }} tanggal {{ optional($pemeriksaanBadan->tgl_surat_perintah)->translatedFormat('d F Y') ?? '-' }}. Kami yang bertanda tangan di bawah ini telah melakukan pemeriksaan terhadap:
    </p>

    <!-- CONTENT -->
    <table class="content-table">
        <tbody>
            <!-- DATA DIRI -->
            <tr>
                <td class="label">Nama</td>
                <td class="colon">:</td>
                <td class="value">{{ $pemeriksaanBadan->nama ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Tempat dan Tanggal Lahir</td>
                <td class="colon">:</td>
                <td class="value">{{ $pemeriksaanBadan->tempat_lahir ?? '-' }}, {{ optional($pemeriksaanBadan->tanggal_lahir)->translatedFormat('d F Y') ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Jenis Kelamin</td>
                <td class="colon">:</td>
                <td class="value">{{ $pemeriksaanBadan->jenis_kelamin ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Kewarganegaraan</td>
                <td class="colon">:</td>
                <td class="value">{{ $pemeriksaanBadan->kewarganegaraan ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Alamat Tempat Tinggal</td>
                <td class="colon">:</td>
                <td class="value">{{ $pemeriksaanBadan->alamat_tinggal ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Alamat Sesuai Identitas</td>
                <td class="colon">:</td>
                <td class="value">{{ $pemeriksaanBadan->alamat_pada_identitas ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Jenis/Nomor Identitas</td>
                <td class="colon">:</td>
                <td class="value">{{ $pemeriksaanBadan->jenis_identitas ?? '-' }} / {{ $pemeriksaanBadan->no_identitas ?? '-' }}</td>
            </tr>
            <tr><td colspan="3" style="height: 8px;"></td></tr>

            <!-- DATA PERJALANAN -->
            <tr>
                <td class="label">Datang Dari</td>
                <td class="colon">:</td>
                <td class="value">{{ $pemeriksaanBadan->datang_dari ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Tujuan Ke</td>
                <td class="colon">:</td>
                <td class="value">{{ $pemeriksaanBadan->tujuan_ke ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Rekan Seperjalanan</td>
                <td class="colon">:</td>
                <td class="value">{{ $pemeriksaanBadan->rekan_perjalanan ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Nama dan Jenis Sarkut</td>
                <td class="colon">:</td>
                <td class="value">{{ $pemeriksaanBadan->nama_sarkut ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">No. Register Sarkut</td>
                <td class="colon">:</td>
                <td class="value">{{ $pemeriksaanBadan->no_register ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Dokumen Barang Yang Dibawa</td>
                <td class="colon">:</td>
                <td class="value">
                    @if($pemeriksaanBadan->jenis_dokumen_barang || $pemeriksaanBadan->nomor_dokumen_barang)
                        {{ $pemeriksaanBadan->jenis_dokumen_barang }} / {{ $pemeriksaanBadan->nomor_dokumen_barang }} / {{ optional($pemeriksaanBadan->tgl_dokumen_barang)->translatedFormat('d F Y') }}
                    @else
                        -
                    @endif
                </td>
            </tr>
            <tr><td colspan="3" style="height: 8px;"></td></tr>

            <!-- HASIL PEMERIKSAAN -->
            <tr>
                <td class="label">Lokasi Pemeriksaan</td>
                <td class="colon">:</td>
                <td class="value">{{ $pemeriksaanBadan->lokasi_pemeriksaan ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Jenis Pemeriksaan</td>
                <td class="colon">:</td>
                <td class="value">{{ $pemeriksaanBadan->jenis_pemeriksaan ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Hasil Pemeriksaan</td>
                <td class="colon">:</td>
                <td class="value">{{ $pemeriksaanBadan->hasil_pemeriksaan ?? '-' }}</td>
            </tr>
        </tbody>
    </table>

    <!-- PENUTUP -->
    <p class="full-width">
        Demikian Berita Acara ini dibuat dengan sebenarnya.
    </p>

    <!-- SIGNATURE -->
    <table class="signature">
        <tbody>
            <tr>
                <td class="num"><br></td>
                <td class="sig-left"><br></td>
                <td class="sig-right">Banda Aceh, {{ optional($pemeriksaanBadan->tgl_ba_riksa)->translatedFormat('d F Y') ?? '-' }}</td>
            </tr>
            <tr>
                <td class="num"><br></td>
                <td class="sig-left">Orang yang diperiksa,</td>
                <td class="sig-right">Pejabat yang melakukan pemeriksaan,</td>
            </tr>
            <tr>
                <td class="num"><br></td>
                <td class="sig-left">
                    <div class="name">{{ $pemeriksaanBadan->nama ?? '-' }}</div>
                </td>
                <td class="sig-right">
                    <div class="name">{{ optional($pemeriksaanBadan->petugas1)->nama ?? '-' }}<br>NIP {{ optional($pemeriksaanBadan->petugas1)->nip_formatted ?? '-' }}</div>
                </td>
            </tr>
            <tr>
                <td class="num"><br></td>
                <td class="sig-left"><br></td>
                <td class="sig-right">
                    <div class="name">{{ optional($pemeriksaanBadan->petugas2)->nama ?? '-' }}<br>NIP {{ optional($pemeriksaanBadan->petugas2)->nip_formatted ?? '-' }}</div>
                </td>
            </tr>
        </tbody>
    </table>
</body>

</html>