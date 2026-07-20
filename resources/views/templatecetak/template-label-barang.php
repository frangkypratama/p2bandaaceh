<?php
/** @var \App\Models\Sbp|null $sbp */
$sbp = $sbp ?? null;
$tanggal = optional($sbp)->tanggal_sbp;
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title><?php echo e(optional($sbp)->nomor_sbp ?? 'Label Barang'); ?></title>
    <style>
        @page {
            size: 215mm 330mm;
            margin: 15mm;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 8pt;
            line-height: 1.15;
            color: #000000;
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

        /* ===== BOX ===== */
        .label-box {
            width: 12cm;
            height: 8cm;
            margin: 0 auto;
            padding: 3mm 5mm 4mm;
            border: 3px double #000000;
            border-radius: 8px;
            background: #ffffff;
        }

        /* ===== HEADER ===== */
        .header-band {
            padding-bottom: 5px;
            margin: 0 0 4px 0;
            border-bottom: 1.5px solid #000000;
        }

        .header-table td {
            vertical-align: middle;
        }

        .logo {
            width: 40px;
        }

        .logo-right {
            text-align: right;
        }

        .header-text {
            text-align: center;
        }

        .header-text h1 {
            font-size: 11.5pt;
            margin: 0;
            color: #000000;
        }

        /* ===== NOMOR ===== */
        .nomor-box {
            text-align: center;
            margin: 3px 0 4px;
        }

        .nomor-box .val {
            display: inline-block;
            padding: 2px 12px;
            font-family: 'Courier New', monospace;
            font-size: 11pt;
            font-weight: bold;
            letter-spacing: 1px;
            color: #000000;
            background: #f0f0f0;
            border: 1px solid #000000;
            border-radius: 4px;
        }

        /* ===== CONTENT ===== */
        .content-table td {
            padding: 2px 4px;
            font-size: 7.5pt;
        }

        .content-table tr:nth-child(even) td {
            background: #f2f2f2;
        }

        .label {
            width: 76px;
            font-weight: bold;
            color: #000000;
        }

        .colon {
            width: 8px;
        }

        .value {
            word-wrap: break-word;
        }

        /* ===== FOOTER ===== */
        .petugas-row td {
            padding-top: 5px;
            border-top: 1px dashed #000000;
            font-style: italic;
            background: #ffffff !important;
        }
    </style>
</head>

<body>
    <div class="label-box">
        <div class="header-band">
            <table class="header-table">
                <tbody>
                    <tr>
                        <td class="logo"><img src="<?php echo public_path('assets/img/logo-kemenkeu.png'); ?>" width="36" height="34"></td>
                        <td class="header-text">
                            <h1>KPPBC TMP C Banda Aceh</h1>
                        </td>
                        <td class="logo logo-right"><img src="<?php echo public_path('assets/img/logo-bc-banda-aceh.png'); ?>" width="36" height="36"></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="nomor-box">
            <span class="val"><?php echo e(optional($sbp)->nomor_sbp ?? '-'); ?></span>
        </div>

        <table class="content-table">
            <tbody>
                <tr>
                    <td class="label">Jenis Barang</td>
                    <td class="colon">:</td>
                    <td class="value"><?php echo e(optional($sbp)->jenis_barang ?? '-'); ?></td>
                </tr>
                <tr>
                    <td class="label">Jumlah</td>
                    <td class="colon">:</td>
                    <td class="value"><?php echo e(optional($sbp)->jumlah_barang ?? '-'); ?> <?php echo e(optional($sbp)->jenis_satuan ?? ''); ?></td>
                </tr>
                <tr>
                    <td class="label">Uraian Barang</td>
                    <td class="colon">:</td>
                    <td class="value"><?php echo e(optional($sbp)->uraian_barang ?? '-'); ?></td>
                </tr>
                <tr>
                    <td class="label">Kondisi Barang</td>
                    <td class="colon">:</td>
                    <td class="value"><?php echo e(optional($sbp)->kondisi_barang ?? '-'); ?></td>
                </tr>
                <tr>
                    <td class="label">Pemilik / Pelaku</td>
                    <td class="colon">:</td>
                    <td class="value"><?php echo e(optional($sbp)->nama_pelaku ?? '-'); ?></td>
                </tr>
                <tr>
                    <td class="label">Lokasi Penindakan</td>
                    <td class="colon">:</td>
                    <td class="value"><?php echo e(optional($sbp)->lokasi_penindakan ?? '-'); ?></td>
                </tr>
                <tr>
                    <td class="label">Tanggal SBP</td>
                    <td class="colon">:</td>
                    <td class="value"><?php echo $tanggal ? e($tanggal->translatedFormat('d F Y')) : '-'; ?></td>
                </tr>
                <tr class="petugas-row">
                    <td class="label">Petugas</td>
                    <td class="colon">:</td>
                    <td class="value"><?php echo e(optional($sbp)->nama_petugas_1 ?? '-'); ?> &amp; <?php echo e(optional($sbp)->nama_petugas_2 ?? '-'); ?></td>
                </tr>
            </tbody>
        </table>
    </div>
</body>

</html>
