<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>{{ $lphp->nomor_lphp ?? '-' }}</title>
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

        /* ===== FOOTER ===== */
        .footer {
            margin-top: 30px;
            font-size: 9pt;
            font-style: italic;
            text-align: justify;
        }
    </style>
</head>

<body>
    @php
        $sbp = $lphp->sbp;
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
        <h3>LEMBAR PENENTUAN HASIL PENINDAKAN</h3>
        <p>Nomor : {{ $lphp->nomor_lphp ?? '-' }}</p>
    </div>

    <table class="content-table">
        <tbody>
            <tr>
                <td class="num">1.</td>
                <td class="label">Nomor SBP</td>
                <td class="colon">:</td>
                <td class="value">{{ optional($sbp)->nomor_sbp ?? '-' }}</td>
                <td class="label" style="width:60px">Tanggal</td>
                <td class="colon">:</td>
                <td class="value">{{ optional(optional($sbp)->tanggal_sbp)->translatedFormat('d F Y') ?? '-' }}</td>
            </tr>
            <tr>
                <td class="num">2.</td>
                <td class="label">Dugaan Pelanggaran</td>
                <td class="colon">:</td>
                <td class="value" colspan="4">{{ $lphp->dugaan_pelanggaran ?? '-' }}</td>
            </tr>
            <tr>
                <td class="num">3.</td>
                <td class="label">Kegiatan Penindakan</td>
                <td class="colon">:</td>
                <td class="value" colspan="4">{{ $lphp->uraian_kegiatan ?? '-' }}</td>
            </tr>
            <tr>
                <td class="sub">a.</td>
                <td class="label" colspan="6">Sarana Pengangkut</td>
            </tr>
            <tr>
                <td class="sub"></td>
                <td class="label">Jenis</td>
                <td class="colon">:</td>
                <td class="value">-</td>
                <td class="label" style="width:60px">No. Pol/Voy/Flight</td>
                <td class="colon">:</td>
                <td class="value">-</td>
            </tr>
            <tr>
                <td class="sub"></td>
                <td class="label">Nomor Petikemas</td>
                <td class="colon">:</td>
                <td class="value">-</td>
                <td class="label" style="width:60px">Ukuran</td>
                <td class="colon">:</td>
                <td class="value">-</td>
            </tr>
            <tr>
                <td class="sub">b.</td>
                <td class="label" colspan="6">Barang</td>
            </tr>
            <tr>
                <td class="sub"></td>
                <td class="label">Komoditi/Jenis</td>
                <td class="colon">:</td>
                <td class="value" colspan="4">{{ optional($sbp)->jenis_barang ?? '-' }}</td>
            </tr>
            <tr>
                <td class="sub"></td>
                <td class="label">Jumlah</td>
                <td class="colon">:</td>
                <td class="value" colspan="4">{{ optional($sbp)->uraian_barang ?? '-' }}</td>
            </tr>
            <tr>
                <td class="sub">c.</td>
                <td class="label" colspan="6">Bangunan / Tempat</td>
            </tr>
            <tr>
                <td class="sub"></td>
                <td class="label">Alamat</td>
                <td class="colon">:</td>
                <td class="value" colspan="4">-</td>
            </tr>
            <tr>
                <td class="sub"></td>
                <td class="label">No Reg Bangunan / NPPBKC/ dll</td>
                <td class="colon">:</td>
                <td class="value" colspan="4">-</td>
            </tr>
            <tr>
                <td class="sub"></td>
                <td class="label">Pemilik / yang menguasai</td>
                <td class="colon">:</td>
                <td class="value" colspan="4">-</td>
            </tr>
            <tr>
                <td class="sub">d.</td>
                <td class="label" colspan="6">Orang</td>
            </tr>
            <tr>
                <td class="sub"></td>
                <td class="label">Nama</td>
                <td class="colon">:</td>
                <td class="value">{{ optional($sbp)->nama_pelaku ?? '-' }}</td>
                <td class="label" style="width:60px">Tanggal Lahir</td>
                <td class="colon">:</td>
                <td class="value">{{ optional($lphp->tanggal_lahir)->translatedFormat('d F Y') ?? '-' }}</td>
            </tr>
            <tr>
                <td class="sub"></td>
                <td class="label">Jenis Kelamin</td>
                <td class="colon">:</td>
                <td class="value">{{ optional($sbp)->jenis_kelamin ?? '-' }}</td>
                <td class="label" style="width:60px">Identitas</td>
                <td class="colon">:</td>
                <td class="value">{{ optional($sbp)->nomor_identitas ?? '-' }}</td>
            </tr>
            <tr>
                <td class="sub"></td>
                <td class="label">Alamat</td>
                <td class="colon">:</td>
                <td class="value">{{ optional($sbp)->alamat_di_indonesia ?? '-' }}</td>
                <td class="label" style="width:60px">Kewarganegaraan</td>
                <td class="colon">:</td>
                <td class="value">{{ $lphp->kewarganegaraan ?? 'Indonesia' }}</td>
            </tr>
            <tr>
                <td class="num">4.</td>
                <td class="label">SB Penindakan</td>
                <td class="colon">:</td>
                <td class="value">{{ optional($sbp)->nomor_sbp ?? '-' }}</td>
                <td class="label" style="width:60px">Tanggal</td>
                <td class="colon">:</td>
                <td class="value">{{ optional($sbp)->waktu_penindakan ?? '-' }} WIB</td>
            </tr>
            <tr>
                <td class="num">5.</td>
                <td class="label" colspan="6">Analisis hasil penindakan:</td>
            </tr>
            <tr>
                <td class="num"></td>
                <td class="value" colspan="6">
                    Berdasarkan hasil penindakan, dilakukan analisis hasil penindakan dengan kesimpulan bahwa
                    terhadap barang, sarana pengangkut, dan/atau bangunan/tempat yang dilakukan penindakan
                    patut diduga melanggar ketentuan {{ $lphp->pasal ?? '-' }} {{ $lphp->uu_terkait ?? '-' }}
                </td>
            </tr>
        </tbody>
    </table>

    <table class="signature">
        <tbody>
            <tr>
                <td class="sig-left">&nbsp;</td>
                <td class="sig-right">{{ optional($sbp)->kota_penindakan ?? 'Banda Aceh' }}, {{ optional($lphp->tanggal_lphp)->translatedFormat('d F Y') }}</td>
            </tr>
            <tr>
                <td class="sig-left">&nbsp;</td>
                <td class="sig-right">Konseptor LPHP</td>
            </tr>
            <tr>
                <td class="sig-left">&nbsp;</td>
                <td class="sig-right">
                    <div class="name">{{ optional($lphp->konseptor)->nama ?? '-' }}<br>NIP {{ optional($lphp->konseptor)->nip_formatted ?? '-' }}</div>
                </td>
            </tr>
        </tbody>
    </table>

    <table class="signature">
        <tbody>
            <tr>
                <td class="sig-left">Pengampu Pejabat Penyusun LPHP</td>
                <td class="sig-right">Pemeriksa Bea dan Cukai Ahli Pertama</td>
            </tr>
            <tr>
                <td class="sig-left">
                    <div class="name">{{ optional($lphp->pengampu)->nama ?? '-' }}<br>NIP {{ optional($lphp->pengampu)->nip_formatted ?? '-' }}</div>
                </td>
                <td class="sig-right">
                    <div class="name">{{ optional($lphp->pemeriksa)->nama ?? '-' }}<br>NIP {{ optional($lphp->pemeriksa)->nip_formatted ?? '-' }}</div>
                </td>
            </tr>
        </tbody>
    </table>

    <table class="content-table" style="margin-top: 20px;">
        <tbody>
            <tr>
                <td class="label">Catatan</td>
                <td class="colon">:</td>
                <td class="value">{{ $lphp->catatan ?? '' }}</td>
            </tr>
        </tbody>
    </table>
</body>

</html>
