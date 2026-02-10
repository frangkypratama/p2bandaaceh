<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>{{ $lpt->nomor_lpt ?? '-' }}</title>
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
            font-size: 11pt;
            text-decoration: underline;
            margin-bottom: 4px;
        }

        /* ===== CONTENT ===== */
        .content-table td {
            padding: 2px 2px;
            line-height: 1;
        }

        .num {
            width: 30px;
            text-align: center;
        }

        .label {
            padding-left: 10px;
        }

        .value {
            text-align: justify;
            word-wrap: break-word;
            padding: 2px 2px;
        }

        .section-title {
            font-weight: bold;
            padding-top: 8px;
        }

        .full-width {
            text-align: justify;
            line-height: 1.5;
            padding: 4px 2px;
        }

        /* ===== LIST STYLES ===== */
        ol {
            margin: 0;
            padding-left: 20px;
        }

        ol li {
            text-align: justify;
            line-height: 1.5;
            padding: 2px 0;
        }

        /* ===== SIGNATURE ===== */
        .signature {
            margin-top: 20px;
        }

        .signature td {
            padding: 2px;
        }

        .signature .sig-left {
            width: 50%;
        }

        .signature .sig-right {
            width: 50%;
        }

        .electronic-sign {
            color: #d0cece;
            font-size: 9pt;
            margin-top: 60px;
            margin-bottom: 2px;
        }

        .name {
            margin-top: 0;
            margin-bottom: 20px;
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
                    <p>Jalan Soekarno Hatta Nomor 3a, Geuceu Menara, Banda Aceh 23241;<br>TELEPON (0651) 43137; FAKSIMILE (0651) 43136; LAMAN www.beacukai.go.id; PUSAT KONTAK LAYANAN 1500225; SUREL <a href="mailto:kpbc.bandaaceh@customs.go.id">kpbc.bandaaceh@customs.go.id</a></p>
                </td>
            </tr>
        </tbody>
    </table>

    <div class="title">
        <h3>LAPORAN PELAKSANAAN TUGAS</h3>
        <p>Nomor : {{ $lpt->nomor_lpt ?? '-' }}</p>
    </div>

    <table class="content-table">
        <tbody>
            <!-- I. DASAR -->
            <tr>
                <td class="num">I.</td>
                <td colspan="2" class="value">DASAR</td>
            </tr>
            <tr>
                <td class="num"></td>
                <td colspan="2" class="value">
                    Surat Perintah Nomor: {{ $lpt->sbp->nomor_surat_perintah ?? '-' }} tanggal {{ optional($lpt->sbp->tanggal_surat_perintah)->translatedFormat('d F Y') ?? '-' }}
                </td>
            </tr>

            <!-- II. WAKTU PELAKSANAAN TUGAS -->
            <tr>
                <td class="num"><br></td>
                <td colspan="2"><br></td>
            </tr>
            <tr>
                <td class="num">II.</td>
                <td colspan="2" class="value">WAKTU PELAKSANAAN TUGAS</td>
            </tr>
            <tr>
                <td class="num"></td>
                <td colspan="2" class="value">
                    {{ optional($lpt->sbp->tanggal_sbp)->translatedFormat('d F Y') }} pukul {{ optional(new \Carbon\Carbon($lpt->sbp->waktu_penindakan))->format('H:i') }} WIB
                </td>
            </tr>

            <!-- III. WILAYAH TUGAS -->
            <tr>
                <td class="num"><br></td>
                <td colspan="2"><br></td>
            </tr>
            <tr>
                <td class="num">III.</td>
                <td colspan="2" class="value">WILAYAH TUGAS</td>
            </tr>
            <tr>
                <td class="num"></td>
                <td colspan="2" class="value">
                    {{ $lpt->sbp->lokasi_penindakan ?? '-' }}
                </td>
            </tr>

            <!-- IV. PELAKSANA TUGAS -->
            <tr>
                <td class="num"><br></td>
                <td colspan="2"><br></td>
            </tr>
            <tr>
                <td class="num">IV.</td>
                <td colspan="2" class="value">PELAKSANA TUGAS</td>
            </tr>
            <tr>
                <td class="num"></td>
                <td colspan="2" class="value">
                    <ol>
                        @if(isset($lpt->sbp->petugas1))
                        <li>{{ $lpt->sbp->petugas1->nama ?? '-' }}</li>
                        @endif
                        @if(isset($lpt->sbp->petugas2))
                        <li>{{ $lpt->sbp->petugas2->nama ?? '-' }}</li>
                        @endif
                    </ol>
                </td>
            </tr>

            <!-- V. URAIAN PELAKSANAAN TUGAS -->
            <tr>
                <td class="num"><br></td>
                <td colspan="2"><br></td>
            </tr>
            <tr>
                <td class="num">V.</td>
                <td colspan="2" class="value">URAIAN PELAKSANAAN TUGAS</td>
            </tr>
            <tr>
                <td class="num"></td>
                <td colspan="2" class="value">
                    <ol>
                        @if(isset($lpt->uraian_tugas) && is_array($lpt->uraian_tugas))
                            @foreach($lpt->uraian_tugas as $uraian)
                            <li>{{ $uraian }}</li>
                            @endforeach
                        @else
                        <li>Telah dilaksanakan kegiatan penindakan terhadap barang berupa <strong>{{ $lpt->sbp->uraian_barang ?? 'N/A' }}</strong> yang dibawa oleh Sdr. <strong>{{ $lpt->sbp->nama_pelaku ?? 'N/A' }}</strong>.</li>
                        <li>Penumpang tersebut memiliki identitas berupa {{ $lpt->sbp->jenis_identitas ?? 'N/A' }} dengan nomor {{ $lpt->sbp->nomor_identitas ?? 'N/A' }}.</li>
                        <li>Penindakan dilakukan pada lokasi {{ $lpt->sbp->lokasi_penindakan ?? 'N/A' }} dengan alasan {{ ($lpt->sbp->alasan_penindakan) ?? 'N/A' }}.</li>
                        <li>Atas barang tersebut diterbitkan Surat Bukti Penindakan (SBP) dengan nomor <strong>{{ $lpt->sbp->nomor_sbp ?? 'N/A' }}</strong> tanggal <strong>{{ $lpt->sbp->tanggal_sbp->translatedFormat('d F Y') }}</strong> dan salinannya telah diserahkan kepada yang bersangkutan.</li>
                        <li>Barang Hasil Penindakan (BHP) selanjutnya dibawa ke KPPBC TMP C Banda Aceh untuk proses lebih lanjut.</li>
                        <li>Dokumentasi kegiatan terlampir.</li>
                        @endif
                    </ol>
                </td>
            </tr>

            <!-- VI. TINDAK LANJUT -->
            <tr>
                <td class="num"><br></td>
                <td colspan="2"><br></td>
            </tr>
            <tr>
                <td class="num">VI.</td>
                <td colspan="2" class="value">TINDAK LANJUT</td>
            </tr>
            <tr>
                <td class="num"></td>
                <td colspan="2" class="value">
                    {{ $lpt->tindak_lanjut ?? 'Dilakukan penindakan terhadap barang tersebut dan dibawa ke KPPBC TMP C Banda Aceh untuk ditindaklanjuti' }}
                </td>
            </tr>

            <!-- VII. KESIMPULAN -->
            <tr>
                <td class="num"><br></td>
                <td colspan="2"><br></td>
            </tr>
            <tr>
                <td class="num">VII.</td>
                <td colspan="2" class="value">KESIMPULAN</td>
            </tr>
            <tr>
                <td class="num"></td>
                <td colspan="2" class="value">
                    {{ $lpt->kesimpulan ?? 'Telah dilakukan penindakan sesuai dengan ketentuan yang berlaku.' }}
                </td>
            </tr>

            <!-- PENUTUP -->
            <tr>
                <td colspan="3"><br></td>
            </tr>
            <tr>
                <td colspan="3" class="full-width">
                    Demikian laporan dibuat dengan sebenarnya untuk mendapat keputusan lebih lanjut.
                </td>
            </tr>
        </tbody>
    </table>

    <table class="signature">
        <tbody>
            <tr>
                <td class="sig-left">&nbsp;</td>
                <td class="sig-right">{{ $lpt->sbp->kota_penindakan ?? 'Banda Aceh' }}, {{ optional($lpt->tanggal_lpt)->translatedFormat('d F Y') ?? '-' }}</td>
            </tr>
            <tr>
                <td class="sig-left">&nbsp;</td>
                <td class="sig-right">Pelaksana Tugas</td>
            </tr>
            
            @if(isset($lpt->sbp->petugas1))
            <tr>
                <td class="sig-left">&nbsp;</td>
                <td class="sig-right">
                    <div class="electronic-sign">Ditandatangani secara elektronik</div>
                    <div class="name">{{ optional($lpt->sbp->petugas1)->nama ?? '-' }}<br>NIP {{ optional($lpt->sbp->petugas1)->nip_formatted ?? '-' }}</div>
                </td>
            </tr>
            @endif

            @if(isset($lpt->sbp->petugas2))
            <tr>
                <td class="sig-left">&nbsp;</td>
                <td class="sig-right">
                    <div class="electronic-sign">Ditandatangani secara elektronik</div>
                    <div class="name">{{ optional($lpt->sbp->petugas2)->nama ?? '-' }}<br>NIP {{ optional($lpt->sbp->petugas2)->nip_formatted ?? '-' }}</div>
                </td>
            </tr>
            @endif
        </tbody>
    </table>

</body>

</html>