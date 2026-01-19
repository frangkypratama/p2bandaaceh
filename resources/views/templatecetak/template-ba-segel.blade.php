<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>{{ $sbp->nomor_ba_segel ?? '-' }}</title>
    <style>
        @page {
            size: 215mm 330mm;
            margin: 15mm;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 11pt;
            line-height: 1;
            color: #000;
        }

        p {
            margin: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td {
            vertical-align: top;
        }

        /* ===== HEADER ===== */
        .header-table td {
            border-bottom: 2px solid #000;
            padding-bottom: 8px;
        }

        .logo {
            width: 90px;
        }

        .header-text {
            text-align: center;
        }

        .header-text h1 {
            font-size: 13pt;
            margin: 0;
        }

        .header-text h2 {
            font-size: 11pt;
            margin: 0;
        }

        .header-text p {
            font-size: 8pt;
            margin-top: 4px;
        }

        /* ===== TITLE ===== */
        .title {
            text-align: center;
            margin: 12px 0;
        }

        .title h3 {
            font-size: 12pt;
            text-decoration: underline;
            margin-bottom: 4px;
        }

        /* ===== CONTENT ===== */
        .content-table td {
            padding: 2px 2px;
            line-height: 1;
        }

        .num {
            width: 20px;
        }

        .label {
            width: 180px;
        }

        .colon {
            width: 10px;
        }

        .value {
            text-align: justify;
            word-wrap: break-word;
        }

        .indent {
            width: 20px;
        }

        .section-title {
            font-weight: bold;
            padding-top: 8px;
        }

        .full-width {
            text-align: justify;
            line-height: 1;
            padding: 4px 2px;
        }

        /* ===== NO NUM CLASS ===== */
        .label-compact {
            width: 180px;
            padding-left: 5px;
        }

        .colon-compact {
            width: 10px;
        }

        .value-compact {
            text-align: justify;
            word-wrap: break-word;
        }

        /* ===== SIGNATURE ===== */
        .signature {
            margin-top: 0px;
        }

        .signature td {
            padding: 2px;
        }

        .signature .num {
            width: 20px;
        }

        .signature .sig-left {
            width: 50%;
        }

        .signature .sig-right {
            width: 50%;
        }

        .name {
            margin-top: 60px;
        }
    </style>
</head>

<body>
    <table class="header-table">
        <tbody>
            <tr>
                <td class="logo"><img src="{{public_path('assets/img/logo-kemenkeu.png')}}" width="87"></td>
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

    <div class="title">
        <h3>BERITA ACARA PENYEGELAN</h3>
        <p>Nomor : {{ $sbp->nomor_ba_segel ?? '-' }}</p>
    </div>

    <table class="content-table">
        <tbody>
            <!-- INTRO TEXT -->
            <tr>
                <td colspan="4" class="full-width">
                    Pada hari ini {{ optional($sbp->tanggal_sbp)->translatedFormat('l') ?? '-' }} tanggal {{ $sbp->tanggal_sbp_terbilang ?? '-' }}, berdasarkan Surat Perintah Kepala KPPBC Tipe Madya Pabean C Banda Aceh Nomor {{ $sbp->nomor_surat_perintah ?? '-' }} tanggal {{ optional($sbp->tanggal_surat_perintah)->translatedFormat('d F Y') ?? '-' }}. Kami yang bertanda tangan di bawah ini telah melakukan penyegelan terhadap:
                </td>
            </tr>

            <!-- SARANA PENGANGKUT -->
            <tr>
                <td class="num">a.</td>
                <td colspan="3" class="section-title">Sarana pengangkut:</td>
            </tr>
            <tr>
                <td class="indent"></td>
                <td class="label">Nama dan Jenis Sarkut</td>
                <td class="colon">:</td>
                <td class="value">{{ $sbp->nama_sarkut ?? '-' }}</td>
            </tr>
            <tr>
                <td class="indent"></td>
                <td class="label">Ukuran/Kapasitas Muatan</td>
                <td class="colon">:</td>
                <td class="value">{{ $sbp->kapasitas_muatan ?? '-' }}</td>
            </tr>
            <tr>
                <td class="indent"></td>
                <td class="label">No. Voy/Penerbangan/Trayek*</td>
                <td class="colon">:</td>
                <td class="value">{{ $sbp->nomor_voyage ?? '-' }}</td>
            </tr>
            <tr>
                <td class="indent"></td>
                <td class="label">Nahkoda/Pilot/Pengemudi*</td>
                <td class="colon">:</td>
                <td class="value">{{ $sbp->nama_pengemudi ?? '-' }}</td>
            </tr>
            <tr>
                <td class="indent"></td>
                <td class="label">Nomor Identitas</td>
                <td class="colon">:</td>
                <td class="value">{{ $sbp->nomor_identitas_pengemudi ?? '-' }}</td>
            </tr>
            <tr>
                <td class="indent"></td>
                <td class="label">Bendera</td>
                <td class="colon">:</td>
                <td class="value">{{ $sbp->bendera ?? '-' }}</td>
            </tr>
            <tr>
                <td class="indent"></td>
                <td class="label">Nomor Register/Polisi*</td>
                <td class="colon">:</td>
                <td class="value">{{ $sbp->nomor_polisi ?? '-' }}</td>
            </tr>

            <!-- BARANG -->
            <tr>
                <td class="num">b.</td>
                <td colspan="3" class="section-title">Barang:</td>
            </tr>
            <tr>
                <td class="indent"></td>
                <td class="label">Jumlah/Jenis/Ukuran Nomor</td>
                <td class="colon">:</td>
                <td class="value">{{ $sbp->jumlah_kemasan ?? '-' }}</td>
            </tr>
            <tr>
                <td class="indent"></td>
                <td class="label">Peti Kemas/Kemasan</td>
                <td class="colon">:</td>
                <td class="value">{{ $sbp->jenis_kemasan ?? '-' }}</td>
            </tr>
            <tr>
                <td class="indent"></td>
                <td class="label">Jumlah/Jenis barang</td>
                <td class="colon">:</td>
                <td class="value">{{ $sbp->uraian_barang ?? '-' }}</td>
            </tr>
            <tr>
                <td class="indent"></td>
                <td class="label">Jenis/Nomor dan Tgl Dokumen</td>
                <td class="colon">:</td>
                <td class="value">{{ $sbp->nomor_dokumen ?? '-' }} / {{ optional($sbp->tanggal_dokumen)->translatedFormat('d F Y') ?? '-' }}</td>
            </tr>
            <tr>
                <td class="indent"></td>
                <td class="label">Pemilik/Importir/Eksportir/Kuasa*</td>
                <td class="colon">:</td>
                <td class="value">{{ $sbp->nama_pelaku ?? '-' }}</td>
            </tr>
            <tr>
                <td class="indent"></td>
                <td class="label">Nomor Identitas</td>
                <td class="colon">:</td>
                <td class="value">{{ $sbp->jenis_identitas ?? '-' }} {{ $sbp->nomor_identitas ?? '-' }}</td>
            </tr>

            <!-- BANGUNAN ATAU TEMPAT -->
            <tr>
                <td class="num">c.</td>
                <td colspan="3" class="section-title">Bangunan atau tempat:</td>
            </tr>
            <tr>
                <td class="indent"></td>
                <td class="label">Alamat Bangunan/Tempat</td>
                <td class="colon">:</td>
                <td class="value">{{ $sbp->alamat_tempat ?? '-' }}</td>
            </tr>
            <tr>
                <td class="indent"></td>
                <td class="label">No Reg Bangunan/NPPBKC/NPWP*</td>
                <td class="colon">:</td>
                <td class="value">{{ $sbp->nomor_registrasi ?? '-' }}</td>
            </tr>
            <tr>
                <td class="indent"></td>
                <td class="label">Nama Pemilik/Yang Menguasai*</td>
                <td class="colon">:</td>
                <td class="value">{{ $sbp->nama_pemilik_tempat ?? '-' }}</td>
            </tr>
            <tr>
                <td class="indent"></td>
                <td class="label">Nomor Identitas</td>
                <td class="colon">:</td>
                <td class="value">{{ $sbp->nomor_identitas_pemilik ?? '-' }}</td>
            </tr>

             <!-- LAPORAN & SAKSI -->
            <tr>
                <td colspan="4"><br>menggunakan segel/ tanda pengaman kertas merah sebanyak 1 (satu) nomor {{ $sbp->nomor_ba_segel ?? '-' }} tanggal {{($sbp->tanggal_sbp)->translatedFormat('d F Y') ?? '-' }} dengan penempatan/pelekatan segel/ tanda pengaman pada : barang</td>
            </tr>
            <tr>
                <td colspan="4" class="full-width">Penyegelan disaksikan oleh pengangkut/pemilik/importir/eksportir atau kuasanya/ketua lingkungan/dll*:</td>
            </tr>
            <tr>
                <td class="indent"></td>
                <td class="label">Nama</td>
                <td class="colon">:</td>
                <td class="value">{{ $sbp->nama_pelaku ?? '-' }}</td>
            </tr>
            <tr>
                <td class="indent"></td>
                <td class="label">Alamat</td>
                <td class="colon">:</td>
                <td class="value">{{ $sbp->alamat_pelaku ?? '-' }}</td>
            </tr>
            <tr>
                <td class="indent"></td>
                <td class="label">Pekerjaan</td>
                <td class="colon">:</td>
                <td class="value">{{ $sbp->pekerjaan_pelaku ?? '-' }}</td>
            </tr>
            <tr>
                <td class="indent"></td>
                <td class="label">Nomor Identitas</td>
                <td class="colon">:</td>
                <td class="value">{{ $sbp->nomor_identitas ?? '-' }}</td>
            </tr>

            <tr>
                <td colspan="4" class="full-width">Demikian Berita Acara ini dibuat dengan sebenarnya.</td>
            </tr>
        </tbody>
    </table>

    <table class="signature">
        <tbody>
            <tr>
                <td class="num"></td>
                <td class="sig-left"><br></td>
                <td class="sig-right">{{ $sbp->kota_penindakan ?? 'Banda Aceh' }}, {{ optional($sbp->tanggal_sbp)->translatedFormat('d F Y') ?? '-' }}</td>
            </tr>
            <tr>
                <td class="num"></td>
                <td class="sig-left">Pemilik/Kuasanya/Saksi*,</td>
                <td class="sig-right">Pejabat yang melakukan penegahan,</td>
            </tr>
            <tr>
                <td class="num"></td>
                <td class="sig-left">
                    <div class="name">{{ $sbp->nama_pelaku ?? '-' }}</div>
                </td>
                <td class="sig-right">
                    <div class="name">{{ optional($sbp->petugas1)->nama ?? '-' }}<br>NIP {{ optional($sbp->petugas1)->nip_formatted ?? '-' }}</div>
                </td>
            </tr>
            <tr>
                <td class="num"></td>
                <td class="sig-left"><br></td>
                <td class="sig-right">
                    <div class="name">{{ optional($sbp->petugas2)->nama ?? '-' }}<br>NIP {{ optional($sbp->petugas2)->nip_formatted ?? '-' }}</div>
                </td>
            </tr>
        </tbody>
    </table>
</body>

</html>