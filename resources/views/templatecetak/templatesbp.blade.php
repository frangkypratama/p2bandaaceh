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

{{-- HEADER --}}
<table class="header-table">
    <tr>
        <td class="logo">
            <img src="{{ public_path('logo/logo-bc.png') }}" width="87">
        </td>
        <td class="header-text">
            <h1>KEMENTERIAN KEUANGAN REPUBLIK INDONESIAS</h1>
            <h2>DIREKTORAT JENDERAL BEA DAN CUKAI</h2>
            <h2>KANTOR WILAYAH DJBC ACEH</h2>
            <h2>KPPBC TMP C BANDA ACEH</h2>
            <p>
                Jalan Soekarno Hatta Nomor 3a Banda Aceh 23241<br>
                Telp. (0651) 43137 | Fax (0651) 43136
            </p>
        </td>
    </tr>
</table>

{{-- TITLE --}}
<div class="title">
    <h3>SURAT BUKTI PENINDAKAN</h3>
    <p>Nomor : {{ $sbp->nomor_sbp ?? '-' }}</p>
</div>

{{-- CONTENT --}}
<table class="content-table">
    <tr>
        <td class="num">1.</td>
        <td class="label">Dasar Penindakan</td>
        <td class="colon">:</td>
        <td class="value">{{ $sbp->dasar_penindakan ?? '-' }}</td>
    </tr>

    <tr>
        <td class="num">2.</td>
        <td class="label">Skema Penindakan</td>
        <td class="colon">:</td>
        <td class="value">{{ $sbp->skema_penindakan ?? 'Mandiri' }}</td>
    </tr>

    <tr>
        <td class="num">3.</td>
        <td class="label">Pelaksanaan</td>
        <td class="colon">:</td>
        <td class="value">Telah dilakukan penindakan berupa:</td>
    </tr>

    <tr>
        <td></td>
        <td class="label">Pemeriksaan</td>
        <td class="colon">:</td>
        <td class="value">{{ $sbp->ba_pemeriksaan ?? '-' }}</td>
    </tr>

    <tr>
        <td></td>
        <td class="label">Penegahan</td>
        <td class="colon">:</td>
        <td class="value">{{ $sbp->ba_penegahan ?? '-' }}</td>
    </tr>

    <tr>
        <td></td>
        <td class="label">Penyegelan</td>
        <td class="colon">:</td>
        <td class="value">{{ $sbp->ba_penyegelan ?? '-' }}</td>
    </tr>

    <tr>
        <td class="num">4.</td>
        <td class="label">Lokasi Penindakan</td>
        <td class="colon">:</td>
        <td class="value">{{ $sbp->lokasi_penindakan ?? '-' }}</td>
    </tr>

    <tr>
        <td></td>
        <td class="label">Alasan Penindakan</td>
        <td class="colon">:</td>
        <td class="value">{{ $sbp->alasan_penindakan ?? '-' }}</td>
    </tr>

    <tr>
        <td></td>
        <td class="label">Uraian Penindakan</td>
        <td class="colon">:</td>
        <td class="value">{{ $sbp->uraian_penindakan ?? '-' }}</td>
    </tr>

    <tr>
        <td></td>
        <td class="label">Kesimpulan</td>
        <td class="colon">:</td>
        <td class="value">{{ $sbp->kesimpulan ?? '-' }}</td>
    </tr>
</table>

{{-- SIGNATURE --}}
<table class="signature">
    <tr>
        <td>
            Pemilik / Kuasa / Saksi*,<br>
            <div class="name">{{ $sbp->nama_saksi ?? '-' }}</div>
        </td>
        <td>
            {{ $sbp->tempat ?? '-' }},
            {{ optional($sbp->tanggal)->translatedFormat('d F Y') }}<br>
            Pejabat yang melakukan penindakan,
            
                <div class="name">
                    {{ $sbp->nama_petugas_1 ?? '-' }}<br>
                    NIP. {{ $sbp->nama_petugas_1 ?? '-' }}
                </div>
        </td>
    </tr>
</table>

{{-- FOOTER --}}
<div class="footer">
    {{ $sbp->catatan ?? '-' }}
</div>

</body>
</html>
