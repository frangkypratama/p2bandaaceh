<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Berkas Penyidikan - {{ $lp->nomor_lp ?? '-' }}</title>
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

        .page {
            page-break-after: always;
        }

        .page:last-child {
            page-break-after: auto;
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
        $lphp = optional($lp)->lphp;
        $sbp = optional($lphp)->sbp;
    @endphp

    {{-- ===================== 1. LP ===================== --}}
    <div class="page">
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
                    <td class="label">LPHP</td>
                    <td class="colon">:</td>
                    <td class="value">{{ optional($lphp)->nomor_lphp ?? '-' }}</td>
                    <td class="label" style="width:60px">Tanggal</td>
                    <td class="colon">:</td>
                    <td class="value">{{ optional(optional($lphp)->tanggal_lphp)->translatedFormat('d F Y') ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label">SB Penindakan</td>
                    <td class="colon">:</td>
                    <td class="value">{{ optional($sbp)->nomor_sbp ?? '-' }}</td>
                    <td class="label" style="width:60px">Tanggal</td>
                    <td class="colon">:</td>
                    <td class="value">{{ optional(optional($sbp)->tanggal_sbp)->translatedFormat('d F Y') ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label">Uraian Penindakan</td>
                    <td class="colon">:</td>
                    <td class="value" colspan="4">{{ optional($lphp)->uraian_kegiatan ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label">Dugaan Pelanggaran</td>
                    <td class="colon">:</td>
                    <td class="value">{{ optional($lphp)->uu_terkait ?? '-' }}</td>
                    <td class="label" style="width:60px">Pasal</td>
                    <td class="colon">:</td>
                    <td class="value">{{ optional($lphp)->pasal ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label">Locus</td>
                    <td class="colon">:</td>
                    <td class="value" colspan="4">Kec. {{ optional($sbp)->kecamatan_penindakan ?? '-' }}, {{ optional($sbp)->kota_penindakan ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label">Tempus</td>
                    <td class="colon">:</td>
                    <td class="value">{{ optional(optional($sbp)->tanggal_sbp)->translatedFormat('d F Y') ?? '-' }}</td>
                    <td class="label" style="width:60px">Pukul</td>
                    <td class="colon">:</td>
                    <td class="value">{{ optional($sbp)->waktu_penindakan ?? '-' }} WIB</td>
                </tr>
                <tr>
                    <td class="label">Diduga dilakukan oleh</td>
                    <td class="colon">:</td>
                    <td class="value" colspan="4">{{ optional($sbp)->nama_pelaku ?? '-' }} ({{ optional($sbp)->nomor_identitas ?? '-' }})</td>
                </tr>
                <tr>
                    <td class="label">Komoditi/Barang</td>
                    <td class="colon">:</td>
                    <td class="value" colspan="4">{{ optional($sbp)->jenis_barang ?? '-' }} - {{ optional($lphp)->uraian_brg_lphp_lp ?? '-' }}</td>
                </tr>
            </tbody>
        </table>

        <table class="signature">
            <tbody>
                <tr>
                    <td class="sig-left">&nbsp;</td>
                    <td class="sig-right">
                        Banda Aceh, {{ optional($lp->tanggal_lp)->translatedFormat('d F Y') }}<br>
                        Pejabat Penerbit LP
                        <div class="name">{{ optional($lp->pejabatPenerbit)->nama ?? '-' }}<br>NIP {{ optional($lp->pejabatPenerbit)->nip_formatted ?? '-' }}</div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    {{-- ===================== 2. LPP ===================== --}}
    <div class="page">
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
                    <td class="value" colspan="3">{{ $lp->nomor_lp ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label">A. Asal Perkara</td>
                    <td class="colon">:</td>
                    <td class="value" colspan="3">{{ $lpp->asal_perkara ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label">B. Jenis Penindakan</td>
                    <td class="colon">:</td>
                    <td class="value" colspan="3">{{ $lpp->jenis_penindakan ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label">C. Jenis Perkara</td>
                    <td class="colon">:</td>
                    <td class="value" colspan="3">{{ optional($lphp)->dugaan_pelanggaran ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label">D. Status Pelanggaran</td>
                    <td class="colon">:</td>
                    <td class="value" colspan="3">{{ $lpp->status_pelanggaran ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label">E. Uraian Pelanggaran</td>
                    <td class="colon">:</td>
                    <td class="value" colspan="3">{{ $lpp->uraian_pelanggaran ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label">F. Barang Hasil Penindakan</td>
                    <td class="colon">:</td>
                    <td class="value" colspan="3">{{ optional($sbp)->jenis_barang ?? '-' }} - {{ optional($sbp)->uraian_barang ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label">G. Dokumen Barang</td>
                    <td class="colon">:</td>
                    <td class="value" colspan="3">{{ $lpp->dokumen_barang ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label">H. Catatan Atasan</td>
                    <td class="colon">:</td>
                    <td class="value" colspan="3">{{ $lpp->catatan_atasan ?? '-' }}</td>
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
                        Yang membuat LPP,<br>Pemeriksa Bea Cukai
                        <div class="name">{{ optional($lpp->pemeriksa)->nama ?? '-' }}<br>NIP {{ optional($lpp->pemeriksa)->nip_formatted ?? '-' }}</div>
                    </td>
                </tr>
                <tr>
                    <td class="sig-left">
                        &nbsp;<br>Mengetahui,<br>Kepala Seksi Penindakan dan Penyidikan
                        <div class="name">{{ optional($lpp->pengampu)->nama ?? '-' }}<br>NIP {{ optional($lpp->pengampu)->nip_formatted ?? '-' }}</div>
                    </td>
                    <td class="sig-right">&nbsp;</td>
                </tr>
            </tbody>
        </table>
    </div>

    {{-- ===================== 3. SPLIT ===================== --}}
    <div class="page">
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
            <h3>SURAT PERINTAH PENELITIAN (SPLIT)</h3>
            <p>Nomor : {{ $split->nomor_split ?? '-' }}</p>
        </div>

        <table class="content-table">
            <tbody>
                <tr>
                    <td class="label">Dasar</td>
                    <td class="colon">:</td>
                    <td class="value">{{ $split->dasar }}</td>
                </tr>
                <tr>
                    <td class="label">Pertimbangan</td>
                    <td class="colon">:</td>
                    <td class="value">{{ $split->pertimbangan }}</td>
                </tr>
                <tr>
                    <td class="label">Diperintahkan Kepada</td>
                    <td class="colon">:</td>
                    <td class="value">
                        1. {{ optional($split->petugas1)->nama ?? '-' }} (NIP {{ optional($split->petugas1)->nip_formatted ?? '-' }}) - {{ optional($split->petugas1)->jabatan ?? '-' }}<br>
                        2. {{ optional($split->petugas2)->nama ?? '-' }} (NIP {{ optional($split->petugas2)->nip_formatted ?? '-' }}) - {{ optional($split->petugas2)->jabatan ?? '-' }}
                    </td>
                </tr>
                <tr>
                    <td class="label">Untuk</td>
                    <td class="colon">:</td>
                    <td class="value">{{ $split->uraian_tugas }}</td>
                </tr>
            </tbody>
        </table>

        <table class="signature">
            <tbody>
                <tr>
                    <td class="sig-left">&nbsp;</td>
                    <td class="sig-right">
                        Dikeluarkan di : Banda Aceh<br>
                        Pada tanggal : {{ optional($split->tanggal_split)->translatedFormat('d F Y') }}<br>
                        Kepala Seksi Penindakan dan Penyidikan
                        <div class="name">{{ optional($split->penerbit)->nama ?? '-' }}<br>NIP {{ optional($split->penerbit)->nip_formatted ?? '-' }}</div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    {{-- ===================== 4. LPF ===================== --}}
    <div class="page">
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

        <div class="section-title">A-B. Uraian Pelanggaran &amp; Kelengkapan Dokumen</div>
        <table class="content-table">
            <tbody>
                <tr>
                    <td class="label">Status Penangkapan</td>
                    <td class="colon">:</td>
                    <td class="value">{{ $lpf->status_penangkapan ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label">Kelengkapan Dokumen</td>
                    <td class="colon">:</td>
                    <td class="value">{{ $lpf->kelengkapan_dokumen ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label">Barang Hasil Penindakan</td>
                    <td class="colon">:</td>
                    <td class="value">{{ $lpf->barang_hasil_penindakan ?? '-' }}</td>
                </tr>
            </tbody>
        </table>

        <div class="section-title">D-F. Kesimpulan, Usulan &amp; Disposisi</div>
        <table class="content-table">
            <tbody>
                <tr>
                    <td class="label">Domain Perkara</td>
                    <td class="colon">:</td>
                    <td class="value">{{ $lpf->domain_perkara ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label">Kesimpulan</td>
                    <td class="colon">:</td>
                    <td class="value">{{ $lpf->kesimpulan ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label">Usulan</td>
                    <td class="colon">:</td>
                    <td class="value">{{ $lpf->usulan ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label">Catatan/Disposisi</td>
                    <td class="colon">:</td>
                    <td class="value">{{ $lpf->catatan_disposisi ?? '-' }}</td>
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
                        Yang membuat LPF,<br>Pemeriksa Bea Cukai
                        <div class="name">{{ optional($lpf->pemeriksa)->nama ?? '-' }}<br>NIP {{ optional($lpf->pemeriksa)->nip_formatted ?? '-' }}</div>
                    </td>
                </tr>
                <tr>
                    <td class="sig-left">
                        &nbsp;<br>Mengetahui,<br>Kepala Seksi Penindakan dan Penyidikan
                        <div class="name">{{ optional($lpf->pengampu)->nama ?? '-' }}<br>NIP {{ optional($lpf->pengampu)->nip_formatted ?? '-' }}</div>
                    </td>
                    <td class="sig-right">&nbsp;</td>
                </tr>
            </tbody>
        </table>
    </div>

    {{-- ===================== 5. LHP ===================== --}}
    <div class="page">
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
                    <td class="label">Nomor SPLIT</td>
                    <td class="colon">:</td>
                    <td class="value">{{ $split->nomor_split ?? '-' }}</td>
                </tr>
            </tbody>
        </table>

        <div class="section-title">A. Uraian Pelanggaran</div>
        <table class="content-table">
            <tbody>
                <tr>
                    <td class="label">Jenis Pelanggaran</td>
                    <td class="colon">:</td>
                    <td class="value">{{ $lhp->jenis_pelanggaran ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label">Pelaku</td>
                    <td class="colon">:</td>
                    <td class="value">{{ optional($sbp)->nama_pelaku ?? '-' }} ({{ optional($sbp)->nomor_identitas ?? '-' }})</td>
                </tr>
            </tbody>
        </table>

        <div class="section-title">B. Modus Pelanggaran</div>
        <table class="content-table">
            <tbody><tr><td class="value" colspan="3">{{ $lhp->modus_pelanggaran ?? '-' }}</td></tr></tbody>
        </table>

        <div class="section-title">C. Pemenuhan Unsur Pasal</div>
        <table class="content-table">
            <tbody><tr><td class="value" colspan="3">{{ $lhp->pemenuhan_unsur_pasal ?? '-' }}</td></tr></tbody>
        </table>

        <div class="section-title">D. Kesimpulan</div>
        <table class="content-table">
            <tbody><tr><td class="value" colspan="3">{{ $lhp->kesimpulan ?? '-' }}</td></tr></tbody>
        </table>

        <div class="section-title">E-G. Alternatif, Informasi Lain &amp; Catatan Atasan</div>
        <table class="content-table">
            <tbody>
                <tr><td class="value" colspan="3">{{ $lhp->alternatif_penyelesaian ?? '-' }}</td></tr>
                <tr><td class="value" colspan="3">{{ $lhp->informasi_lainnya ?? '-' }}</td></tr>
                <tr><td class="value" colspan="3">{{ $lhp->catatan_atasan ?? '-' }}</td></tr>
            </tbody>
        </table>

        <table class="signature">
            <tbody>
                <tr>
                    <td class="sig-left">
                        Konseptor LHP
                        <div class="name">{{ optional($lhp->konseptor)->nama ?? '-' }}<br>NIP {{ optional($lhp->konseptor)->nip_formatted ?? '-' }}</div>
                    </td>
                    <td class="sig-right">
                        Banda Aceh, {{ optional($lhp->tanggal_lhp)->translatedFormat('d F Y') }}<br>
                        Yang membuat LHP,<br>Pemeriksa Bea Cukai
                        <div class="name">{{ optional($lhp->pemeriksa)->nama ?? '-' }}<br>NIP {{ optional($lhp->pemeriksa)->nip_formatted ?? '-' }}</div>
                    </td>
                </tr>
                <tr>
                    <td class="sig-left">
                        &nbsp;<br>Mengetahui,<br>Kepala Seksi Penindakan dan Penyidikan
                        <div class="name">{{ optional($lhp->pengampu)->nama ?? '-' }}<br>NIP {{ optional($lhp->pengampu)->nip_formatted ?? '-' }}</div>
                    </td>
                    <td class="sig-right">&nbsp;</td>
                </tr>
            </tbody>
        </table>
    </div>
</body>

</html>
