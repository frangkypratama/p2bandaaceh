<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>{{ $bast->nomor_bast ?? '-' }}</title>
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
            width: 180px;
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

        .section-title {
            font-weight: bold;
            padding-top: 8px;
        }

        .full-width {
            text-align: justify;
            line-height: 1;
            padding: 4px 2px;
        }

        /* ===== NO NUM CLASS ===== */
        .label-compact {
            width: 180px;
            padding-left: 5px;
        }

        .colon-compact {
            width: 10px;
        }

        .value-compact {
            text-align: justify;
            word-wrap: break-word;
        }

        /* ===== SIGNATURE ===== */
        .signature {
            margin-top: 0px;
        }

        .signature td {
            padding: 2px;
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
        <h3>BERITA ACARA SERAH TERIMA</h3>
        <p>Nomor : {{ $bast->nomor_bast ?? '-' }}</p>
    </div>

    <table class="content-table">
        <tbody>
            <!-- INTRO TEXT -->
            <tr>
                <td colspan="4" class="full-width">
                    Pada hari ini {{ optional($bast->tanggal_bast)->translatedFormat('l') ?? '-' }} tanggal {{ App\Helpers\TerbilangHelper::ucfirst(App\Helpers\TerbilangHelper::terbilang(optional($bast->tanggal_bast)->format('d'))) }} bulan {{ optional($bast->tanggal_bast)->translatedFormat('F') }} tahun {{ App\Helpers\TerbilangHelper::ucfirst(App\Helpers\TerbilangHelper::terbilang(optional($bast->tanggal_bast)->format('Y'))) }}, saya yang bertanda tangan di bawah ini bertindak untuk dan atas nama Direktorat Jenderal Bea dan Cukai telah menyerahkan:
                </td>
            </tr>

            <!-- SARANA PENGANGKUT -->
            <tr>
                <td class="num">a.</td>
                <td colspan="3" class="section-title">Sarana pengangkut:</td>
            </tr>
            <tr>
                <td class="indent"></td>
                <td class="label">Nama dan Jenis Sarkut</td>
                <td class="colon">:</td>
                <td class="value">{{ $sbp->nama_sarkut ?? '-' }}</td>
            </tr>
            <tr>
                <td class="indent"></td>
                <td class="label">Nomor Register/Polisi*</td>
                <td class="colon">:</td>
                <td class="value">{{ $sbp->nomor_polisi ?? '-' }}</td>
            </tr>

            <!-- BARANG -->
            <tr>
                <td class="num">b.</td>
                <td colspan="3" class="section-title">Barang:</td>
            </tr>
            <tr>
                <td class="indent"></td>
                <td class="label">Jumlah/No Peti Kemas</td>
                <td class="colon">:</td>
                <td class="value">{{ $sbp->jumlah_kemasan ?? '-' }}</td>
            </tr>
            <tr>
                <td class="indent"></td>
                <td class="label">Jumlah/Jenis barang</td>
                <td class="colon">:</td>
                <td class="value">{{ $sbp->uraian_barang ?? '-' }}</td>
            </tr>

            <!-- DOKUMEN -->
            <tr>
                <td class="num">c.</td>
                <td colspan="3" class="section-title">Dokumen:</td>
            </tr>
            <tr>
                <td class="indent"></td>
                <td class="label">Jenis/No Dokumen</td>
                <td class="colon">:</td>
                <td class="value">{{ $bast->jenis_dokumen ?? '-' }}</td>
            </tr>
            <tr>
                <td class="indent"></td>
                <td class="label">Tanggal Dokumen</td>
                <td class="colon">:</td>
                <td class="value">{{ optional($bast->tanggal_dokumen)->translatedFormat('d F Y') ?? '-' }}</td>
            </tr>

            <!-- ORANG -->
            <tr>
                <td class="num">d.</td>
                <td colspan="3" class="section-title">Orang:</td>
            </tr>
            <tr>
                <td class="indent"></td>
                <td class="label">Nama</td>
                <td class="colon">:</td>
                <td class="value">{{ $sbp->nama_pelaku ?? '-' }}</td>
            </tr>
            <tr>
                <td class="indent"></td>
                <td class="label">Nomor Identitas</td>
                <td class="colon">:</td>
                <td class="value">{{ $sbp->nomor_identitas ?? '-' }}</td>
            </tr>

            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>

            <!-- DISERAHKAN KEPADA -->
            <tr>
                <td colspan="4" class="full-width">Diserahkan kepada:</td>
            </tr>
            <tr>
                <td class="indent"></td>
                <td class="label">Nama</td>
                <td class="colon">:</td>
                <td class="value">{{ $bast->petugas_eksternal ?? '-' }}</td>
            </tr>
            <tr>
                <td class="indent"></td>
                <td class="label">NIP/No Identitas</td>
                <td class="colon">:</td>
                <td class="value">{{ $bast->nip_nrp_petugas_eksternal ?? '-' }}</td>
            </tr>
            <tr>
                <td class="indent"></td>
                <td class="label">Instansi</td>
                <td class="colon">:</td>
                <td class="value">{{ $bast->instansi_eksternal ?? '-' }}</td>
            </tr>

            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>

            <tr>
                <td colspan="4" class="full-width">Penyerahan dilaksanakan dalam rangka:</td>
            </tr>
            <tr>
                <td class="indent"></td>
                <td colspan="3" class="value">{{ $bast->dalam_rangka ?? '-' }}</td>
            </tr>

            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>

            <tr>
                <td colspan="4" class="full-width">Demikian Berita Acara ini dibuat dengan sebenarnya.</td>
            </tr>

            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </tbody>
    </table>

    <table class="signature">
        <tbody>
            <tr>
                <td class="num"></td>
                <td class="sig-left"></td>
                <td class="sig-right">{{ $sbp->kota_penindakan ?? 'Banda Aceh' }}, {{ optional($bast->tanggal_bast)->translatedFormat('d F Y') ?? '-' }}</td>
            </tr>
            <tr>
                <td class="num"></td>
                <td class="sig-left">Yang menerima,</td>
                <td class="sig-right">Yang menyerahkan,</td>
            </tr>
            <tr>
                <td class="num"></td>
                <td class="sig-left">
                    <div class="name">{{ $bast->petugas_eksternal ?? '-' }}<br>NIP {{ $bast->nip_nrp_petugas_eksternal ?? '-' }}</div>
                </td>
                <td class="sig-right">
                    <div class="name">{{ optional($sbp->petugas1)->nama ?? '-' }}<br>NIP {{ optional($sbp->petugas1)->nip_formatted ?? '-' }}</div>
                </td>
            </tr>
        </tbody>
    </table>
</body>

</html>