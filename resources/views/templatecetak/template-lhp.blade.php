<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>{{ $lhp->nomor_lhp ?? '-' }}</title>
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
        $split = $lhp->split;
        $lpf = optional($split)->lpf;
        $lpp = optional($lpf)->lpp;
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
        <h3>LEMBAR HASIL PENELITIAN (LHP)</h3>
        <p>NOMOR: {{ $lhp->nomor_lhp ?? '-' }}</p>
    </div>

    <table class="content-table">
        <tbody>
            <tr>
                <td class="label">Nomor LP</td>
                <td class="colon">:</td>
                <td class="value">{{ optional($lp)->nomor_lp ?? '-' }}</td>
                <td class="label" style="width:80px">Tanggal</td>
                <td class="colon">:</td>
                <td class="value">{{ optional(optional($lp)->tanggal_lp)->translatedFormat('d F Y') ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Nomor SPLIT</td>
                <td class="colon">:</td>
                <td class="value">{{ optional($split)->nomor_split ?? '-' }}</td>
                <td class="label" style="width:80px">Tanggal</td>
                <td class="colon">:</td>
                <td class="value">{{ optional(optional($split)->tanggal_split)->translatedFormat('d F Y') ?? '-' }}</td>
            </tr>
        </tbody>
    </table>

    <div class="section-title">A. URAIAN PELANGGARAN</div>
    <table class="content-table">
        <tbody>
            <tr>
                <td class="label">Jenis Pelanggaran</td>
                <td class="colon">:</td>
                <td class="value" colspan="3">{{ $lhp->jenis_pelanggaran ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Locus</td>
                <td class="colon">:</td>
                <td class="value" colspan="3">{{ optional($sbp)->lokasi_penindakan ?? '-' }}, Kec. {{ optional($sbp)->kecamatan_penindakan ?? '-' }}, {{ optional($sbp)->kota_penindakan ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Tempus</td>
                <td class="colon">:</td>
                <td class="value" colspan="3">{{ optional(optional($sbp)->tanggal_sbp)->translatedFormat('d F Y') ?? '-' }} pukul {{ optional($sbp)->waktu_penindakan ?? '-' }} WIB</td>
            </tr>
            <tr>
                <td class="label" colspan="2">Pelaku Pelanggaran</td>
                <td class="value" colspan="3"></td>
            </tr>
            <tr>
                <td class="label">Nama Pelanggar</td>
                <td class="colon">:</td>
                <td class="value" colspan="3">{{ optional($sbp)->nama_pelaku ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">NIK/No. Paspor</td>
                <td class="colon">:</td>
                <td class="value">{{ optional($sbp)->nomor_identitas ?? '-' }}</td>
                <td class="label" style="width:100px">Jenis Kelamin</td>
                <td class="colon">:</td>
                <td class="value">{{ optional($sbp)->jenis_kelamin ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Alamat</td>
                <td class="colon">:</td>
                <td class="value" colspan="3">{{ optional($sbp)->alamat_di_indonesia ?? '-' }}</td>
            </tr>
            @if($lhp->pelaku_administrasi)
            <tr>
                <td class="value" colspan="6">{{ $lhp->pelaku_administrasi }}</td>
            </tr>
            @endif
            @if($lhp->saksi_saksi)
            <tr>
                <td class="label" colspan="2">Saksi-Saksi (Pelaku Tidak Dikenal)</td>
                <td class="value" colspan="3"></td>
            </tr>
            <tr>
                <td class="value" colspan="6">{{ $lhp->saksi_saksi }}</td>
            </tr>
            @endif
            <tr>
                <td class="label" colspan="2">Uraian Barang</td>
                <td class="value" colspan="3"></td>
            </tr>
            <tr>
                <td class="label">Komoditas</td>
                <td class="colon">:</td>
                <td class="value" colspan="3">{{ optional($sbp)->jenis_barang ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Uraian Barang</td>
                <td class="colon">:</td>
                <td class="value" colspan="3">{{ optional($sbp)->uraian_barang ?? '-' }}</td>
            </tr>
            @if($lhp->uraian_barang_tambahan)
            <tr>
                <td class="value" colspan="6">{{ $lhp->uraian_barang_tambahan }}</td>
            </tr>
            @endif
            @if($lhp->sarana_pengangkut)
            <tr>
                <td class="label" colspan="2">Sarana Pengangkut</td>
                <td class="value" colspan="3"></td>
            </tr>
            <tr>
                <td class="value" colspan="6">{{ $lhp->sarana_pengangkut }}</td>
            </tr>
            @endif
            @if($lhp->dokumen_dokumen)
            <tr>
                <td class="label" colspan="2">Dokumen-Dokumen</td>
                <td class="value" colspan="3"></td>
            </tr>
            <tr>
                <td class="value" colspan="6">{{ $lhp->dokumen_dokumen }}</td>
            </tr>
            @endif
        </tbody>
    </table>

    <div class="section-title">B. MODUS PELANGGARAN</div>
    <table class="content-table">
        <tbody>
            <tr><td class="value" colspan="3">{{ $lhp->modus_pelanggaran ?? '-' }}</td></tr>
        </tbody>
    </table>

    <div class="section-title">C. PEMENUHAN UNSUR PASAL</div>
    <table class="content-table">
        <tbody>
            <tr><td class="value" colspan="3">{{ $lhp->pemenuhan_unsur_pasal ?? '-' }}</td></tr>
        </tbody>
    </table>

    <div class="section-title">D. KESIMPULAN</div>
    <table class="content-table">
        <tbody>
            <tr><td class="value" colspan="3">{{ $lhp->kesimpulan ?? '-' }}</td></tr>
        </tbody>
    </table>

    <div class="section-title">E. ALTERNATIF PENYELESAIAN PERKARA</div>
    <table class="content-table">
        <tbody>
            <tr><td class="value" colspan="3">{{ $lhp->alternatif_penyelesaian ?? '-' }}</td></tr>
        </tbody>
    </table>

    <div class="section-title">F. INFORMASI LAINNYA</div>
    <table class="content-table">
        <tbody>
            <tr><td class="value" colspan="3">{{ $lhp->informasi_lainnya ?? '-' }}</td></tr>
        </tbody>
    </table>

    <div class="section-title">G. CATATAN ATASAN</div>
    <table class="content-table">
        <tbody>
            <tr><td class="value" colspan="3">{{ $lhp->catatan_atasan ?? '-' }}</td></tr>
        </tbody>
    </table>

    <p style="margin-top: 10px;">Demikian lembar hasil penelitian ini dibuat dengan kekuatan sumpah jabatan</p>

    <table class="signature">
        <tbody>
            <tr>
                <td class="sig-left">
                    Konseptor LHP
                    <div class="name">{{ optional($lhp->konseptor)->nama ?? '-' }}<br>NIP {{ optional($lhp->konseptor)->nip_formatted ?? '-' }}</div>
                </td>
                <td class="sig-right">
                    Banda Aceh, {{ optional($lhp->tanggal_lhp)->translatedFormat('d F Y') }}<br>
                    Yang membuat LHP,<br>
                    Pemeriksa Bea Cukai
                    <div class="name">{{ optional($lhp->pemeriksa)->nama ?? '-' }}<br>NIP {{ optional($lhp->pemeriksa)->nip_formatted ?? '-' }}</div>
                </td>
            </tr>
            <tr>
                <td class="sig-left">
                    &nbsp;<br>
                    Mengetahui,<br>
                    Kepala Seksi Penindakan dan Penyidikan
                    <div class="name">{{ optional($lhp->pengampu)->nama ?? '-' }}<br>NIP {{ optional($lhp->pengampu)->nip_formatted ?? '-' }}</div>
                </td>
                <td class="sig-right">&nbsp;</td>
            </tr>
        </tbody>
    </table>
</body>

</html>
