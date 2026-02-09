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
            font-size: 12pt;
            text-decoration: underline;
            margin-bottom: 4px;
        }

        /* ===== CONTENT ===== */
        .content-table td {
            padding: 2px 2px;
            line-height: 1.5;
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

        .name {
            margin-top: 60px;
        }

        .electronic-sign {
            color: #d0cece;
            font-size: 9pt;
            margin-top: 40px;
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
                <td colspan="2" class="section-title">DASAR</td>
            </tr>
            <tr>
                <td class="num"></td>
                <td colspan="2" class="value">
                    {{ $lpt->nomor_surat_perintah ?? '-' }} tanggal {{ optional($lpt->tanggal_surat_perintah)->translatedFormat('d F Y') ?? '-' }}
                </td>
            </tr>

            <!-- II. WAKTU PELAKSANAAN TUGAS -->
            <tr>
                <td class="num"><br></td>
                <td colspan="2"><br></td>
            </tr>
            <tr>
                <td class="num">II.</td>
                <td colspan="2" class="section-title">WAKTU PELAKSANAAN TUGAS</td>
            </tr>
            <tr>
                <td class="num"></td>
                <td colspan="2" class="value">
                    {{ optional($lpt->tanggal_pelaksanaan)->translatedFormat('d F Y') ?? '-' }}
                </td>
            </tr>

            <!-- III. WILAYAH TUGAS -->
            <tr>
                <td class="num"><br></td>
                <td colspan="2"><br></td>
            </tr>
            <tr>
                <td class="num">III.</td>
                <td colspan="2" class="section-title">WILAYAH TUGAS</td>
            </tr>
            <tr>
                <td class="num"></td>
                <td colspan="2" class="value">
                    {{ $lpt->wilayah_tugas ?? '-' }}
                </td>
            </tr>

            <!-- IV. PELAKSANA TUGAS -->
            <tr>
                <td class="num"><br></td>
                <td colspan="2"><br></td>
            </tr>
            <tr>
                <td class="num">IV.</td>
                <td colspan="2" class="section-title">PELAKSANA TUGAS</td>
            </tr>
            <tr>
                <td class="num"></td>
                <td colspan="2" class="value">
                    <ol>
                        @if(isset($lpt->petugas1))
                        <li>{{ $lpt->petugas1->nama ?? '-' }}</li>
                        @endif
                        @if(isset($lpt->petugas2))
                        <li>{{ $lpt->petugas2->nama ?? '-' }}</li>
                        @endif
                        @if(isset($lpt->petugas3))
                        <li>{{ $lpt->petugas3->nama ?? '-' }}</li>
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
                <td colspan="2" class="section-title">URAIAN PELAKSANAAN TUGAS</td>
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
                        <li>Telah dilaksanakan kegiatan penindakan terhadap {{ $lpt->uraian_barang ?? '-' }} yang dibawa oleh {{ $lpt->nama_pelaku ?? '-' }};</li>
                        <li>Barang tersebut dibawa oleh Penumpang bernama {{ $lpt->nama_pelaku ?? '-' }} dengan nomor {{ $lpt->jenis_identitas ?? 'Paspor' }} {{ $lpt->nomor_identitas ?? '-' }} yang berasal dari {{ $lpt->asal ?? '-' }} menuju {{ $lpt->tujuan ?? '-' }};</li>
                        <li>Yang bersangkutan tidak memberitahukan barang bawaannya dan mengaku barang tersebut {{ $lpt->tujuan_barang ?? '-' }};</li>
                        <li>Berdasarkan hasil keputusan pemeriksa barang, terhadap barang tersebut diduga masuk kategori larangan dan pembatasan;</li>
                        <li>Kemudian atas barang tersebut dilakukan penindakan ({{ $lpt->nomor_sbp ?? '-' }}) berikut dengan salinannya diberikan kepada ybs;</li>
                        <li>Selanjutnya Barang Hasil Penindakan tersebut dibawa ke KPPBC TMP C Banda Aceh untuk ditindaklanjuti;</li>
                        <li>Pelaksana Tugas mengambil dokumentasi terlampir;</li>
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
                <td colspan="2" class="section-title">TINDAK LANJUT</td>
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
                <td colspan="2" class="section-title">KESIMPULAN</td>
            </tr>
            <tr>
                <td class="num"></td>
                <td colspan="2" class="value">
                    {{ $lpt->kesimpulan ?? '-' }}
                </td>
            </tr>

            <!-- PENUTUP -->
            <tr>
                <td colspan="3"><br></td>
            </tr>
            <tr>
                <td colspan="3" class="full-width">
                    Demikian laporan dibuat dengan sebenarnya untuk mendapat keputusan lebih lanjut
                </td>
            </tr>
        </tbody>
    </table>

    <table class="signature">
        <tbody>
            <tr>
                <td class="sig-left">&nbsp;</td>
                <td class="sig-right">{{ $lpt->kota ?? 'Banda Aceh' }}, {{ optional($lpt->tanggal_lpt)->translatedFormat('d F Y') ?? '-' }}</td>
            </tr>
            <tr>
                <td class="sig-left">&nbsp;</td>
                <td class="sig-right">Pelaksana Tugas</td>
            </tr>
            <tr>
                <td class="sig-left">&nbsp;</td>
                <td class="sig-right">
                    <div class="electronic-sign">Ditandatangani secara elektronik</div>
                    <div class="name">{{ optional($lpt->petugas1)->nama ?? '-' }}<br>NIP {{ optional($lpt->petugas1)->nip_formatted ?? '-' }}</div>
                </td>
            </tr>
        </tbody>
    </table>

</body>

</html>