<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>{{ $sbp->nomor_sbp ?? '-' }}</title>
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
            width: 150px;
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

        /* ===== SIGNATURE ===== */
        .signature {
            margin-top: 40px;
        }

        .signature td {
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
        <h3>SURAT BUKTI PENINDAKAN</h3>
        <p>Nomor : {{ $sbp->nomor_sbp ?? '-' }}</p>
    </div>
    <table class="content-table">
        <tbody>
            <tr>
                <td class="num">1.</td>
                <td class="label">Dasar Penindakan</td>
                <td class="colon">:</td>
                <td class="value">{{ $sbp->nomor_surat_perintah ?? '-' }}</td>
            </tr>
            <tr>
                <td class="num">2.</td>
                <td class="label">Skema Penindakan</td>
                <td class="colon">:</td>
                <td class="value">{{ $sbp->skema_penindakan ?? 'Mandiri' }}</td>
            </tr>
            <tr>
                <td class="num">3.</td>
                <td colspan="3">
                    Telah dilaksanakan penindakan berupa:
                </td>
            </tr>
            <tr>
                <td class="indent"><br></td>
                <td class="label">Pemeriksaan</td>
                <td class="colon">:</td>
                <td class="value">{{ $sbp->nomor_ba_riksa ?? '-' }}</td>
            </tr>
            <tr>
                <td class="indent"><br></td>
                <td class="label">Penegahan</td>
                <td class="colon">:</td>
                <td class="value">{{ $sbp->nomor_ba_tegah ?? '-' }}</td>
            </tr>
            <tr>
                <td class="indent"><br></td>
                <td class="label">Penyegelan</td>
                <td class="colon">:</td>
                <td class="value">{{ $sbp->nomor_ba_segel ?? '-' }}</td>
            </tr>
            <tr>
                <td class="num">4.</td>
                <td class="label">Lokasi Penindakan</td>
                <td class="colon">:</td>
                <td class="value">{{ $sbp->lokasi_penindakan ?? '-' }}</td>
            </tr>
            <tr>
                <td class="indent"><br></td>
                <td class="label">Alasan Penindakan</td>
                <td class="colon">:</td>
                <td class="value">{{ $sbp->alasan_penindakan ?? '-' }}</td>
            </tr>
            <tr>
                <td class="indent"><br></td>
                <td class="label">Uraian Penindakan</td>
                <td class="colon">:</td>
                <td class="value">Telah dilakukan pemeriksaan, penindakan dan penyegelan terhadap {{ $sbp->uraian_barang ?? '-' }}</td>
            </tr>
            <tr>
                <td class="indent"><br></td>
                <td class="label">Kesimpulan</td>
                <td class="colon">:</td>
                <td class="value">Barang dibawa ke KPPBC TMP C Banda Aceh untuk ditindaklanjuti</td>
            </tr>
        </tbody>
    </table>
    <table class="signature">
        <tbody>
            <tr>
                <td class="num"><br></td>
                <td class="sig-left"><br></td>
                <td class="sig-right">{{ $sbp->tempat ?? 'Banda Aceh' }}, {{ optional($sbp->tanggal_sbp)->translatedFormat('d F Y') }}</td>
            </tr>
            <tr>
                <td class="num"></td>
                <td class="sig-left">Pemilik / Kuasa / Saksi*,</td>
                <td class="sig-right">Pejabat yang melakukan penindakan,</td>
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
            <tr>
                <td class="num"></td>
                <td colspan="2">
                    <div class="footer">{{ $sbp->catatan ?? 'Yang dimaksud dengan barang yang dikuasai negara adalah barang yang untuk sementara waktu penguasaannya berada pada negara sampai dapat ditentukan status barang yang sebenarnya. Perubahan status ini dimaksudkan agar pejabat bea dan cukai dapat memproses barang tersebut secara administrasi sampai dapat dibuktikan bahwa telah terjadi kesalahan atau sama sekali tidak terjadi kesalahan ' }}</div>
                </td>
            </tr>
        </tbody>
    </table>
</body>

</html>
