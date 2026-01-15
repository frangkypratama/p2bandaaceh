<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Bukti Penindakan</title>
    <style>
        /* ===== SETTING KERTAS F4 ===== */
        @page {
            size: 210mm 330mm; /* F4 */
            margin: 30mm 25mm 30mm 25mm;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 11pt;
            line-height: 1.4;
        }

        .center { text-align: center; }
        .bold { font-weight: bold; }
        .uppercase { text-transform: uppercase; }

        hr {
            border: 1px solid #000;
            margin: 8px 0 2px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td {
            vertical-align: top;
            padding: 4px 2px;
        }

        .kop {
            font-size: 11pt;
        }

        .content-table td:first-child {
            width: 28px;
        }

        .signature-table td {
            width: 50%;
            text-align: center;
            padding-top: 50px;
        }

        @media print {
            body { margin: 0; }
        }
    </style>
</head>
<body>

<div class="center kop">
    <div class="bold uppercase">Kementerian Keuangan Republik Indonesia</div>
    <div class="bold uppercase">Direktorat Jenderal Bea dan Cukai</div>
    <br>
    <div class="bold uppercase">Kantor Wilayah Direktorat Jenderal Bea dan Cukai Aceh</div>
    <div class="bold uppercase">Kantor Pengawasan dan Pelayanan Bea dan Cukai Tipe Madya Pabean C Banda Aceh</div>
    <div>Jalan Soekarno Hatta Nomor 3A, Geuceu Menara, Banda Aceh 23241</div>
    <div>Telepon (0651) 43137; Faksimile (0651) 43136</div>
    <div>Laman www.beacukai.go.id; Pusat Kontak Layanan 1500225</div>
    <div>Surel bcaceh@customs.go.id</div>
</div>

<hr>

<div style="margin-top:20px; margin-bottom:10px;">
    <div class="center uppercase bold" style="font-size:14pt;">Surat Bukti Penindakan</div>
</div>

<p class="center" style="margin-bottom:20px;">Nomor : <span class="bold">{{ $sbp->nomor_sbp }}</span></p>

<table class="content-table">
    <tr>
        <td>1.</td>
        <td>Dasar Penindakan</td>
        <td>: Surat Perintah Nomor {{ $sbp->nomor_surat_perintah }}</td>
    </tr>
    <tr>
        <td>2.</td>
        <td>Skema Penindakan</td>
        <td>: Mandiri</td>
    </tr>
    <tr>
        <td>3.</td>
        <td colspan="2">Telah dilaksanakan penindakan berupa:</td>
    </tr>
    <tr>
        <td></td>
        <td>Pemeriksaan</td>
        <td>: {{ $sbp->nomor_pemeriksaan ?? '-' }}</td>
    </tr>
    <tr>
        <td></td>
        <td>Penegahan</td>
        <td>: {{ $sbp->nomor_penegahan ?? '-' }}</td>
    </tr>
    <tr>
        <td></td>
        <td>Penyegelan</td>
        <td>: {{ $sbp->nomor_penyegelan ?? '-' }}</td>
    </tr>
    <tr>
        <td>4.</td>
        <td>Lokasi Penindakan</td>
        <td>: {{ $sbp->lokasi_penindakan }}</td>
    </tr>
    <tr>
        <td></td>
        <td>Alasan Penindakan</td>
        <td>: {{ $sbp->alasan_penindakan }}</td>
    </tr>
    <tr>
        <td></td>
        <td>Uraian Penindakan</td>
        <td>: {{ $sbp->uraian_barang }}</td>
    </tr>
    <tr>
        <td></td>
        <td>Kesimpulan</td>
        <td>: Barang dibawa ke KPPBC TMP C Banda Aceh untuk ditindaklanjuti</td>
    </tr>
</table>

<br>
<p>Aceh Besar, {{ \Carbon\Carbon::parse($sbp->tanggal_sbp)->translatedFormat('d F Y') }}</p>

<table class="signature-table">
    <tr>
        <td>
            Pemilik / Kuasanya / Saksi<br><br><br>
            <u>{{ $sbp->nama_pelaku }}</u>
        </td>
        <td>
            Pejabat yang Melakukan Penindakan<br><br><br>
            <u>{{ $sbp->nama_petugas_1 }}</u><br>
            NIP. {{ $sbp->nip_petugas_1 ?? '-' }}
        </td>
    </tr>
    <tr>
        <td></td>
        <td>
            <br><br>
            <u>{{ $sbp->nama_petugas_2 }}</u><br>
            NIP. {{ $sbp->nip_petugas_2 ?? '-' }}
        </td>
    </tr>
</table>

<br><br>
<p style="font-size:10pt; text-align:justify;">
Yang dimaksud dengan "barang yang dikuasai negara" adalah barang yang untuk sementara waktu penguasaannya berada pada negara sampai dapat ditentukan status barang yang sebenarnya.
</p>

</body>
</html>
```
