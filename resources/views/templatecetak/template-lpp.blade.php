<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>{{ $lpp->nomor_lpp ?? '-' }}</title>
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

        tr {
            page-break-inside: avoid;
        }

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

        .title {
            text-align: center;
            margin: 12px 0;
        }

        .title h3 {
            font-size: 12pt;
            text-decoration: underline;
            margin-bottom: 4px;
        }

        .content-table td {
            padding: 1px 2px;
            line-height: 1;
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
            white-space: pre-line;
        }

        .signature {
            margin-top: 40px;
            page-break-inside: avoid;
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
        $lp = $lpp->lp;
        $lphp = optional($lp)->lphp;
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
        <h3>LEMBAR PENERIMAAN PERKARA (LPP)</h3>
        <p>Nomor {{ $lpp->nomor_lpp ?? '-' }}</p>
    </div>

    <table class="content-table">
        <tbody>
            <tr>
                <td class="label">LP/Surat Nomor</td>
                <td class="colon">:</td>
                <td class="value">{{ optional($lp)->nomor_lp ?? '-' }}</td>
                <td class="label" style="width:60px">Tanggal</td>
                <td class="colon">:</td>
                <td class="value">{{ optional(optional($lp)->tanggal_lp)->translatedFormat('d F Y') ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">SBP Nomor</td>
                <td class="colon">:</td>
                <td class="value">{{ optional($sbp)->nomor_sbp ?? '-' }}</td>
                <td class="label" style="width:60px">Tanggal</td>
                <td class="colon">:</td>
                <td class="value">{{ optional(optional($sbp)->tanggal_sbp)->translatedFormat('d F Y') ?? '-' }}</td>
            </tr>
            <tr>
                <td class="num">A.</td>
                <td class="label" colspan="2">Asal Perkara</td>
                <td class="colon">:</td>
                <td class="value" colspan="2">{{ $lpp->asal_perkara ?? '-' }}</td>
            </tr>
            <tr>
                <td class="num">B.</td>
                <td class="label" colspan="2">Jenis Penindakan</td>
                <td class="colon">:</td>
                <td class="value" colspan="2">{{ $lpp->jenis_penindakan ?? '-' }}</td>
            </tr>
            <tr>
                <td class="num">C.</td>
                <td class="label" colspan="2">Jenis Perkara</td>
                <td class="colon">:</td>
                <td class="value" colspan="2">{{ optional($lphp)->dugaan_pelanggaran ?? '-' }}</td>
            </tr>
            <tr>
                <td class="num">D.</td>
                <td class="label" colspan="2">Status Pelanggaran</td>
                <td class="colon">:</td>
                <td class="value" colspan="2">{{ $lpp->status_pelanggaran ?? '-' }}</td>
            </tr>
            <tr>
                <td class="num">E.</td>
                <td class="label" colspan="2">Uraian Pelanggaran</td>
                <td class="colon">:</td>
                <td class="value" colspan="2">{{ $lpp->uraian_pelanggaran ?? '-' }}</td>
            </tr>
            <tr>
                <td></td>
                <td class="sub">1.</td>
                <td class="label">Jenis Pelanggaran</td>
                <td class="colon">:</td>
                <td class="value" colspan="2">Diduga melanggar {{ optional($lphp)->pasal ?? '-' }} {{ optional($lphp)->uu_terkait ?? '' }}</td>
            </tr>
            <tr>
                <td></td>
                <td class="sub">2.</td>
                <td class="label">Modus Operandi</td>
                <td class="colon">:</td>
                <td class="value" colspan="2">{{ optional($sbp)->alasan_penindakan ?? '-' }}</td>
            </tr>
            <tr>
                <td></td>
                <td class="sub">3.</td>
                <td class="label">Lokasi</td>
                <td class="colon"></td>
                <td class="value" colspan="2"></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td class="label">Tempat</td>
                <td class="colon">:</td>
                <td class="value" colspan="2">{{ optional($sbp)->lokasi_penindakan ?? '-' }}, Kec. {{ optional($sbp)->kecamatan_penindakan ?? '-' }}, {{ optional($sbp)->kota_penindakan ?? '-' }}</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td class="label">Tanggal</td>
                <td class="colon">:</td>
                <td class="value" colspan="2">{{ optional(optional($sbp)->tanggal_sbp)->translatedFormat('d F Y') ?? '-' }} pukul {{ optional($sbp)->waktu_penindakan ?? '-' }} WIB</td>
            </tr>
            <tr>
                <td></td>
                <td class="sub">4.</td>
                <td class="label">Pelaku Pelanggaran</td>
                <td class="colon"></td>
                <td class="value" colspan="2"></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td class="label">Nama</td>
                <td class="colon">:</td>
                <td class="value" colspan="2">{{ optional($sbp)->nama_pelaku ?? '-' }}</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td class="label">Jenis Kelamin</td>
                <td class="colon">:</td>
                <td class="value" colspan="2">{{ optional($sbp)->jenis_kelamin ?? '-' }}</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td class="label">Alamat</td>
                <td class="colon">:</td>
                <td class="value" colspan="2">{{ optional($sbp)->alamat_di_indonesia ?? '-' }}</td>
            </tr>
            <tr>
                <td class="num">F.</td>
                <td class="label" colspan="2">Barang Hasil Penindakan</td>
                <td class="colon"></td>
                <td class="value" colspan="2"></td>
            </tr>
            <tr>
                <td></td>
                <td class="sub">1.</td>
                <td class="label">Komoditi</td>
                <td class="colon">:</td>
                <td class="value" colspan="2">{{ optional($sbp)->jenis_barang ?? '-' }}</td>
            </tr>
            <tr>
                <td></td>
                <td class="sub">2.</td>
                <td class="label">Jumlah</td>
                <td class="colon">:</td>
                <td class="value" colspan="2">{{ optional($sbp)->jumlah_barang ?? '-' }} {{ optional($sbp)->jenis_satuan ?? '' }}</td>
            </tr>
            <tr>
                <td></td>
                <td class="sub">3.</td>
                <td class="label">Detail Uraian Barang</td>
                <td class="colon">:</td>
                <td class="value" colspan="2">{{ optional($sbp)->uraian_barang ?? '-' }}</td>
            </tr>
            <tr>
                <td class="num">G.</td>
                <td class="label" colspan="2">Dokumen Barang</td>
                <td class="colon">:</td>
                <td class="value" colspan="2">{{ $lpp->dokumen_barang ?? '-' }}</td>
            </tr>
            <tr>
                <td class="num">H.</td>
                <td class="label" colspan="2">Catatan Atasan Pembuat LPP</td>
                <td class="colon">:</td>
                <td class="value" colspan="2">{{ $lpp->catatan_atasan ?? '-' }}</td>
            </tr>
        </tbody>
    </table>

    <table class="signature">
        <tbody>
            <tr>
                <td class="sig-left">
                    Konseptor LPP
                    <div class="name">{{ optional($lpp->konseptor)->nama ?? '-' }}<br>NIP {{ optional($lpp->konseptor)->nip_formatted ?? '-' }}</div>
                </td>
                <td class="sig-right">
                    Banda Aceh, {{ optional($lpp->tanggal_lpp)->translatedFormat('d F Y') }}<br>
                    Yang membuat LPP,<br>
                    Pemeriksa Bea Cukai
                    <div class="name">{{ optional($lpp->pemeriksa)->nama ?? '-' }}<br>NIP {{ optional($lpp->pemeriksa)->nip_formatted ?? '-' }}</div>
                </td>
            </tr>
            <tr>
                <td class="sig-left">
                    &nbsp;<br>
                    Mengetahui,<br>
                    Kepala Seksi Penindakan dan Penyidikan
                    <div class="name">{{ optional($lpp->pengampu)->nama ?? '-' }}<br>NIP {{ optional($lpp->pengampu)->nip_formatted ?? '-' }}</div>
                </td>
                <td class="sig-right">&nbsp;</td>
            </tr>
        </tbody>
    </table>
</body>

</html>
