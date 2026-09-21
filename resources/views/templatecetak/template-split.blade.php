<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>{{ $split->nomor_split ?? '-' }}</title>
    <style>
        @page {
            size: 215mm 330mm;
            margin: 15mm;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 11pt;
            line-height: 1.3;
            color: #000;
        }

        p {
            margin: 0 0 6px 0;
            text-align: justify;
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

        .dasar-table td {
            padding: 1px 4px;
        }

        .dasar-label {
            width: 90px;
        }

        .diperintahkan {
            text-align: center;
            font-weight: bold;
            letter-spacing: 3px;
            margin: 14px 0;
        }

        .kepada-table td {
            padding: 1px 4px;
        }

        .kepada-label {
            width: 120px;
        }

        .untuk-table td {
            padding: 4px;
            vertical-align: top;
        }

        .untuk-num {
            width: 20px;
        }

        .penutup {
            margin-top: 14px;
        }

        .signature {
            margin-top: 24px;
            page-break-inside: avoid;
        }

        .signature-right {
            width: 55%;
            margin-left: 45%;
        }

        .name {
            margin-top: 60px;
        }
    </style>
</head>

<body>
    @php
        $lpf = $split->lpf;
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
        <h3>SURAT PERINTAH PENELITIAN (SPLIT)</h3>
        <p>Nomor : {{ $split->nomor_split ?? '-' }}</p>
    </div>

    <table class="dasar-table">
        <tbody>
            <tr>
                <td class="dasar-label">D a s a r</td>
                <td style="width:10px">:</td>
                <td style="white-space: pre-line; text-align: justify;">{{ $split->dasar }}</td>
            </tr>
            <tr>
                <td class="dasar-label">Pertimbangan</td>
                <td>:</td>
                <td style="white-space: pre-line; text-align: justify;">{{ $split->pertimbangan }}</td>
            </tr>
        </tbody>
    </table>

    <div class="diperintahkan">D I P E R I N T A H K A N</div>

    <table class="kepada-table">
        <tbody>
            <tr>
                <td class="kepada-label" rowspan="4">Kepada</td>
                <td style="width:10px" rowspan="4">:</td>
                <td class="kepada-label">Nama</td>
                <td style="width:10px">:</td>
                <td>{{ optional($split->petugas1)->nama ?? '-' }}</td>
            </tr>
            <tr>
                <td class="kepada-label">NIP</td>
                <td>:</td>
                <td>{{ optional($split->petugas1)->nip_formatted ?? '-' }}</td>
            </tr>
            <tr>
                <td class="kepada-label">Pangkat/Gol</td>
                <td>:</td>
                <td>{{ optional($split->petugas1)->pangkat ?? '-' }} / {{ optional($split->petugas1)->golongan ?? '-' }}</td>
            </tr>
            <tr>
                <td class="kepada-label">Jabatan</td>
                <td>:</td>
                <td>{{ optional($split->petugas1)->jabatan ?? '-' }}</td>
            </tr>
            <tr>
                <td colspan="2">&nbsp;</td>
                <td class="kepada-label">Nama</td>
                <td>:</td>
                <td>{{ optional($split->petugas2)->nama ?? '-' }}</td>
            </tr>
            <tr>
                <td colspan="2"></td>
                <td class="kepada-label">NIP</td>
                <td>:</td>
                <td>{{ optional($split->petugas2)->nip_formatted ?? '-' }}</td>
            </tr>
            <tr>
                <td colspan="2"></td>
                <td class="kepada-label">Pangkat/Gol</td>
                <td>:</td>
                <td>{{ optional($split->petugas2)->pangkat ?? '-' }} / {{ optional($split->petugas2)->golongan ?? '-' }}</td>
            </tr>
            <tr>
                <td colspan="2"></td>
                <td class="kepada-label">Jabatan</td>
                <td>:</td>
                <td>{{ optional($split->petugas2)->jabatan ?? '-' }}</td>
            </tr>
        </tbody>
    </table>

    <table class="untuk-table">
        <tbody>
            <tr>
                <td class="untuk-num">Untuk</td>
                <td style="width:10px">:</td>
                <td>
                    <p>Melakukan tugas penelitian berupa mencari, mengumpulkan bahan keterangan, dan menemukan bukti permulaan yang cukup atas perkara yang diduga dilakukan oleh:</p>
                    <table style="margin: 4px 0 8px 0;">
                        <tr>
                            <td style="width:120px">Nama</td>
                            <td style="width:10px">:</td>
                            <td>{{ optional($sbp)->nama_pelaku ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td>Alamat</td>
                            <td>:</td>
                            <td>{{ optional($sbp)->alamat_di_indonesia ?? '-' }}</td>
                        </tr>
                    </table>
                    <p style="white-space: pre-line;">{{ $split->uraian_tugas }}</p>
                </td>
            </tr>
        </tbody>
    </table>

    <p class="penutup">Demikian surat perintah ini dibuat untuk dilaksanakan dengan penuh tanggung jawab.</p>

    <table class="signature">
        <tbody>
            <tr>
                <td class="signature-right">
                    Dikeluarkan di : Banda Aceh<br>
                    Pada tanggal : {{ optional($split->tanggal_split)->translatedFormat('d F Y') }}<br>
                    Kepala Seksi Penindakan dan Penyidikan<br>
                    Kantor Pengawasan dan Pelayanan Bea dan Cukai<br>
                    Tipe Madya Pabean C Banda Aceh
                    <div class="name">{{ optional($split->penerbit)->nama ?? '-' }}<br>NIP {{ optional($split->penerbit)->nip_formatted ?? '-' }}</div>
                </td>
            </tr>
        </tbody>
    </table>
</body>

</html>
