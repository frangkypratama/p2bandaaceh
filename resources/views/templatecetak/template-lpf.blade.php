<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>{{ $lpf->nomor_lpf ?? '-' }}</title>
    <style>
        @page {
            size: 215mm 330mm;
            margin: 15mm;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 11pt;
            line-height: 1.2;
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

        .section-title {
            font-weight: bold;
            margin: 10px 0 4px 0;
        }

        .content-table td {
            padding: 2px 4px;
            line-height: 1.2;
            vertical-align: top;
        }

        .label {
            width: 170px;
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
            margin-top: 30px;
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
        $lpp = $lpf->lpp;
        $lp = optional($lpp)->lp;
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
        <h3>LEMBAR PENELITIAN FORMAL (LPF)</h3>
        <p>Nomor : {{ $lpf->nomor_lpf ?? '-' }}</p>
    </div>

    <div class="section-title">A. Uraian Pelanggaran</div>
    <table class="content-table">
        <tbody>
            <tr>
                <td class="label">Jenis Pelanggaran</td>
                <td class="colon">:</td>
                <td class="value">Diduga melanggar {{ optional($lphp)->pasal ?? '-' }} {{ optional($lphp)->uu_terkait ?? '' }}</td>
            </tr>
            <tr>
                <td class="label">Tempat</td>
                <td class="colon">:</td>
                <td class="value">{{ optional($sbp)->lokasi_penindakan ?? '-' }}, Kec. {{ optional($sbp)->kecamatan_penindakan ?? '-' }}, {{ optional($sbp)->kota_penindakan ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Waktu</td>
                <td class="colon">:</td>
                <td class="value">{{ optional(optional($sbp)->tanggal_sbp)->translatedFormat('d F Y') ?? '-' }} pukul {{ optional($sbp)->waktu_penindakan ?? '-' }} WIB</td>
            </tr>
            <tr>
                <td class="label">Pelaku</td>
                <td class="colon">:</td>
                <td class="value">{{ optional($sbp)->nama_pelaku ?? '-' }} ({{ optional($sbp)->jenis_kelamin ?? '-' }}), {{ optional($sbp)->alamat_di_indonesia ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Status Penangkapan</td>
                <td class="colon">:</td>
                <td class="value">{{ $lpf->status_penangkapan ?? '-' }}</td>
            </tr>
        </tbody>
    </table>

    <div class="section-title">B. Kelengkapan Dokumen Penindakan</div>
    <table class="content-table">
        <tbody>
            <tr>
                <td class="value" colspan="3">{{ $lpf->kelengkapan_dokumen ?? '-' }}</td>
            </tr>
        </tbody>
    </table>

    <div class="section-title">C. Barang Hasil Penindakan</div>
    <table class="content-table">
        <tbody>
            <tr>
                <td class="label">Komoditi</td>
                <td class="colon">:</td>
                <td class="value">{{ optional($sbp)->jenis_barang ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Uraian Barang</td>
                <td class="colon">:</td>
                <td class="value">{{ $lpf->barang_hasil_penindakan ?? optional($sbp)->uraian_barang ?? '-' }}</td>
            </tr>
        </tbody>
    </table>

    <div class="section-title">D. Kesimpulan</div>
    <table class="content-table">
        <tbody>
            <tr>
                <td class="label">Domain Perkara</td>
                <td class="colon">:</td>
                <td class="value">{{ $lpf->domain_perkara ?? '-' }}</td>
            </tr>
            <tr>
                <td class="value" colspan="3">{{ $lpf->kesimpulan ?? '-' }}</td>
            </tr>
        </tbody>
    </table>

    <div class="section-title">E. Usulan</div>
    <table class="content-table">
        <tbody>
            <tr>
                <td class="value" colspan="3">{{ $lpf->usulan ?? '-' }}</td>
            </tr>
        </tbody>
    </table>

    <div class="section-title">F. Catatan/Disposisi Atasan</div>
    <table class="content-table">
        <tbody>
            <tr>
                <td class="value" colspan="3">{{ $lpf->catatan_disposisi ?? '-' }}</td>
            </tr>
        </tbody>
    </table>

    <table class="signature">
        <tbody>
            <tr>
                <td class="sig-left">
                    Konseptor LPF
                    <div class="name">{{ optional($lpf->konseptor)->nama ?? '-' }}<br>NIP {{ optional($lpf->konseptor)->nip_formatted ?? '-' }}</div>
                </td>
                <td class="sig-right">
                    Banda Aceh, {{ optional($lpf->tanggal_lpf)->translatedFormat('d F Y') }}<br>
                    Yang membuat LPF,<br>
                    Pemeriksa Bea Cukai
                    <div class="name">{{ optional($lpf->pemeriksa)->nama ?? '-' }}<br>NIP {{ optional($lpf->pemeriksa)->nip_formatted ?? '-' }}</div>
                </td>
            </tr>
            <tr>
                <td class="sig-left">
                    &nbsp;<br>
                    Mengetahui,<br>
                    Kepala Seksi Penindakan dan Penyidikan
                    <div class="name">{{ optional($lpf->pengampu)->nama ?? '-' }}<br>NIP {{ optional($lpf->pengampu)->nip_formatted ?? '-' }}</div>
                </td>
                <td class="sig-right">&nbsp;</td>
            </tr>
        </tbody>
    </table>
</body>

</html>
