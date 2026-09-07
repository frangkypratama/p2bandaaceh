<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>{{ $lp->nomor_lp ?? '-' }}</title>
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
            padding: 3px 2px;
            line-height: 1.3;
        }

        .num {
            width: 20px;
        }

        .sub {
            width: 15px;
        }

        .label {
            width: 150px;
        }

        .colon {
            width: 10px;
        }

        .value {
            text-align: justify;
            word-wrap: break-word;
        }

        /* ===== SIGNATURE ===== */
        .signature {
            margin-top: 40px;
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
    @php
        $lphp = $lp->lphp;
        $sbp = optional($lphp)->sbp;
    @endphp

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
        <h3>LAPORAN PELANGGARAN</h3>
        <p>Nomor : {{ $lp->nomor_lp ?? '-' }}</p>
    </div>

    <table class="content-table">
        <tbody>
            <tr>
                <td class="num">1.</td>
                <td class="label">LPHP</td>
                <td class="colon">:</td>
                <td class="value">{{ optional($lphp)->nomor_lphp ?? '-' }}</td>
                <td class="label" style="width:60px">Tanggal</td>
                <td class="colon">:</td>
                <td class="value">{{ optional(optional($lphp)->tanggal_lphp)->translatedFormat('d F Y') ?? '-' }}</td>
            </tr>
            <tr>
                <td class="num">2.</td>
                <td class="label">SB Penindakan</td>
                <td class="colon">:</td>
                <td class="value">{{ optional($sbp)->nomor_sbp ?? '-' }}</td>
                <td class="label" style="width:60px">Tanggal</td>
                <td class="colon">:</td>
                <td class="value">{{ optional(optional($sbp)->tanggal_sbp)->translatedFormat('d F Y') ?? '-' }}</td>
            </tr>
            <tr>
                <td class="num">3.</td>
                <td class="label">Uraian Penindakan</td>
                <td class="colon">:</td>
                <td class="value" colspan="4">
                    Dilakukan pemeriksaan terhadap {{ optional($lphp)->nama_tempat ?? '-' }} yang diindikasikan {{ optional($sbp)->alasan_penindakan ?? '-' }}
                </td>
            </tr>
            <tr>
                <td class="sub"></td>
                <td class="label">Dugaan Pelanggaran</td>
                <td class="colon">:</td>
                <td class="value">{{ optional($lphp)->uu_terkait ?? '-' }}</td>
                <td class="label" style="width:60px">Pasal</td>
                <td class="colon">:</td>
                <td class="value">{{ optional($lphp)->pasal ?? '-' }}</td>
            </tr>
            <tr>
                <td class="sub"></td>
                <td class="label">Uraian Modus</td>
                <td class="colon">:</td>
                <td class="value" colspan="4">{{ optional($sbp)->alasan_penindakan ?? '-' }}</td>
            </tr>
            <tr>
                <td class="sub"></td>
                <td class="label">Locus</td>
                <td class="colon">:</td>
                <td class="value" colspan="4">Kec. {{ optional($sbp)->kecamatan_penindakan ?? '-' }}, {{ optional($sbp)->kota_penindakan ?? '-' }}</td>
            </tr>
            <tr>
                <td class="sub"></td>
                <td class="label">Tempus</td>
                <td class="colon">:</td>
                <td class="value">Kec. {{ optional($sbp)->kecamatan_penindakan ?? '-' }}, {{ optional($sbp)->kota_penindakan ?? '-' }}</td>
                <td class="label" style="width:60px">Pukul</td>
                <td class="colon">:</td>
                <td class="value">{{ optional($sbp)->waktu_penindakan ?? '-' }} WIB</td>
            </tr>
            <tr>
                <td class="num">4.</td>
                <td class="label" colspan="6">Diduga dilakukan oleh:</td>
            </tr>
            <tr>
                <td class="sub"></td>
                <td class="label">Nama</td>
                <td class="colon">:</td>
                <td class="value">{{ optional($sbp)->nama_pelaku ?? '-' }}</td>
                <td class="label" style="width:60px">Jenis Kelamin</td>
                <td class="colon">:</td>
                <td class="value">{{ optional($sbp)->jenis_kelamin ?? '-' }}</td>
            </tr>
            <tr>
                <td class="sub"></td>
                <td class="label">Nomor Identitas</td>
                <td class="colon">:</td>
                <td class="value">{{ optional($sbp)->nomor_identitas ?? '-' }}</td>
                <td class="label" style="width:60px">Alamat</td>
                <td class="colon">:</td>
                <td class="value">{{ optional($sbp)->alamat_di_indonesia ?? '-' }}</td>
            </tr>
            <tr>
                <td class="num">5.</td>
                <td class="label" colspan="6">Barang Hasil Penindakan:</td>
            </tr>
            <tr>
                <td class="sub"></td>
                <td class="label">Komoditi / Jenis Barang</td>
                <td class="colon">:</td>
                <td class="value" colspan="4">{{ optional($sbp)->jenis_barang ?? '-' }}</td>
            </tr>
            <tr>
                <td class="sub"></td>
                <td class="label">Jumlah Barang</td>
                <td class="colon">:</td>
                <td class="value" colspan="4">{{ optional($sbp)->jumlah_barang ?? '-' }} {{ optional($sbp)->jenis_satuan ?? '' }} ({{ optional($sbp)->uraian_barang ?? '-' }})</td>
            </tr>
            <tr>
                <td class="sub"></td>
                <td class="label">Barang Lain Terkait</td>
                <td class="colon">:</td>
                <td class="value" colspan="4">-</td>
            </tr>
        </tbody>
    </table>

    <table class="signature">
        <tbody>
            <tr>
                <td class="sig-left">&nbsp;</td>
                <td class="sig-right">{{ optional($sbp)->kota_penindakan ?? 'Banda Aceh' }}, {{ optional($lp->tanggal_lp)->translatedFormat('d F Y') }}</td>
            </tr>
            <tr>
                <td class="sig-left">&nbsp;</td>
                <td class="sig-right">Pejabat Penerbit LP</td>
            </tr>
            <tr>
                <td class="sig-left">&nbsp;</td>
                <td class="sig-right">
                    <div class="name">{{ optional($lp->pejabatPenerbit)->nama ?? '-' }}<br>NIP {{ optional($lp->pejabatPenerbit)->nip_formatted ?? '-' }}</div>
                </td>
            </tr>
        </tbody>
    </table>
</body>

</html>
