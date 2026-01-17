<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Surat Bukti Penindakan</title>
    <style>
        @page {
            size: 215mm 330mm;
            margin: 15mm;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 11pt;
            line-height: 1.5;
            color: #000;
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
            padding: 4px 2px;
            font-size: 10.5pt;
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

        /* ===== SIGNATURE ===== */
        .signature {
            margin-top: 40px;
        }

        .signature td {
            width: 50%;
            font-size: 10.5pt;
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
                <td class="logo"><img src="{{'assets/img/logo-kemenkeu.png'}}" width="87"></td>
                <td class="header-text">
                    <h1>KEMENTERIAN KEUANGAN REPUBLIK INDONESIA</h1>
                    <h2>DIREKTORAT JENDERAL BEA DAN CUKAI</h2>
                    <h2>KANTOR WILAYAH DJBC ACEH</h2>
                    <h2>KPPBC TMP C BANDA ACEH</h2>
                    <p>Jalan Soekarno Hatta Nomor 3a Banda Aceh 23241<br>Telp. (0651) 43137 | Fax (0651) 43136</p>
                </td>
            </tr>
        </tbody>
    </table>

    <div class="title">
        <h3>SURAT BUKTI PENINDAKAN</h3>
        <p>Nomor : {{ $sbp->nomor_sbp ?? '-' }}</p>
    </div>
    <p>{{-- CONTENT --}}</p>
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
                <td class="value ">{{ $sbp->skema_penindakan ?? 'Mandiri' }}</td>
            </tr>
            <tr>
                <td class="num">3.</td>
                <td class="label">Pelaksanaan</td>
                <td class="colon">:</td>
                <td class="value">Telah dilakukan penindakan berupa:</td>
            </tr>
            <tr>
                <td><br></td>
                <td class="label">Pemeriksaan</td>
                <td class="colon">:</td>
                <td class="value">{{ $sbp->nomor_ba_riksa ?? '-' }}</td>
            </tr>
            <tr>
                <td><br></td>
                <td class="label">Penegahan</td>
                <td class="colon">:</td>
                <td class="value">{{ $sbp->nomor_ba_tegah ?? '-' }}</td>
            </tr>
            <tr>
                <td><br></td>
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
                <td><br></td>
                <td class="label">Alasan Penindakan</td>
                <td class="colon">:</td>
                <td class="value">{{ $sbp->alasan_penindakan ?? '-' }}</td>
            </tr>
            <tr>
                <td><br></td>
                <td class="label">Uraian Penindakan</td>
                <td class="colon">:</td>
                <td class="value">Telah dilakukan pemeriksaan, penindakan dan penyegelan terhadap {{ $sbp->uraian_barang ?? '-' }}</td>
            </tr>
            <tr>
                <td><br></td>
                <td class="label">Kesimpulan</td>
                <td class="colon">:</td>
                <td class="value">Barang dibawa ke KPPBC TMP C Banda Aceh untuk ditindaklanjuti</td>
            </tr>
        </tbody>
    </table>
    <p>{{-- SIGNATURE --}}</p>
    <table class="signature fr-table-selection-hover">
        <tbody>
            <tr>
                <td style="null"><br></td>
                <td style="null">{{ $sbp->tempat ?? 'Banda Aceh' }}, {{ optional($sbp->tanggal_sbp)->translatedFormat('d F Y') }}<br></td>
            </tr>
            <tr>
                <td style="null">Pemilik / Kuasa / Saksi*,<br></td>
                <td style="null">Pejabat yang melakukan penindakan,<br></td>
            </tr>
            <tr>
                <td><br>
                    <div class="name">{{ $sbp->nama_pelaku ?? '-' }}</div>
                </td>
                <td><br>
                    <div class="name">{{ $sbp->nama_petugas_1 ?? '-' }}<br>NIP. {{ $sbp->nama_petugas_1 ?? '-' }}</div>
                </td>
            </tr>
            <tr>
                <td><br></td>
                <td>
                    <div class="name">{{ $sbp->nama_petugas_2 ?? '-' }}<br>NIP. {{ $sbp->nama_petugas_2 ?? '-' }}</div>
                </td>
            </tr>
            <tr>
                <td style="width: 100%;" colspan="2">
                    <p>{{-- FOOTER --}}</p>
                    <div class="footer">{{ $sbp->catatan ?? 'Yang dimaksud dengan &quot;barang yang dikuasai negara&quot; adalah barang yang untuk
sementara waktu penguasaannya berada pada negara sampai dapat ditentukan
status barang yang sebenarnya. Perubahan status ini dimaksudkan agar pejabat
bea dan cukai dapat memproses barang tersebut secara administrasi sampai
dapat dibuktikan bahwa telah terjadi kesalahan atau sama sekali tidak terjadi
kesalahan.
' }}</div>
                </td>
            </tr>
        </tbody>
    </table>
</body>

</html>