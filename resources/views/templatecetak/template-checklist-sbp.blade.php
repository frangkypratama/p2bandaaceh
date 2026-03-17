<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Checklist Kelengkapan Berkas Penindakan</title>
    <style>
        @page {
            size: 215mm 330mm;
            margin: 15mm;
        }
            
        body {
            font-family: Arial, sans-serif;
            font-size: 11pt;
            line-height: 1;
            padding: 0;
            margin: 0;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        th, td {
            border: 1px solid #000;
            padding: 5px;
            text-align: left;
            vertical-align: middle;
            line-height: 1;
        }
        
        th {
            background-color: #f0f0f0;
            font-weight: bold;
            text-align: center;
        }
        
        .header-title {
            text-align: center;
            font-weight: bold;
            background-color: #f0f0f0;
        }
        
        .info-row {
            background-color: #f9f9f9;
        }
        
        .info-label {
            text-align: center;
            font-weight: bold;
            width: 60%;
        }
        
        .info-value {
            text-align: center;
            font-weight: bold;
            width: 40%;
        }
        
        .col-no {
            width: 5%;
            text-align: center;
        }
        
        .col-nama {
            width: 60%;
        }
        
        .col-status {
            width: 20%;
            text-align: center;
        }
        
        .col-ket {
            width: 15%;
            text-align: center;
        }
        
        .row-number {
            text-align: center;
        }
        
        @media print {
            body {
                padding: 0;
                margin: 0;
            }
        }
    </style>
</head>
<body>
    <table>
        <thead>
            <tr>
                <th colspan="4" class="header-title">CHECKLIST KELENGKAPAN BERKAS PENINDAKAN</th>
            </tr>
            <tr class="info-row">
                <th class="info-label" colspan="2">NOMOR SURAT BUKTI PENINDAKAN</th>
                <th class="info-value" colspan="2">{{$sbp->nomor_sbp ?? '-' }}</th>
            </tr>
            <tr class="info-row">
                <th class="info-label" colspan="2">TANGGAL SURAT BUKTI PENINDAKAN</th>
                <th class="info-value" colspan="2">{{ optional($sbp->tanggal_sbp)->translatedFormat('d F Y') }}</th>
            </tr>
            <tr>
                <th class="col-no">NO</th>
                <th class="col-nama">NAMA BERKAS</th>
                <th class="col-status">ADA/TIDAK ADA</th>
                <th class="col-ket">KETERANGAN</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($checklistItems as $item)
            <tr>
                <td class="row-number">{{ $loop->iteration }}</td>
                <td>{{ $item['nama'] }}</td>
                <td class="col-status" style="font-weight: bold; font-size: 11pt; text-align: center;">
                    @if($item['status'])
                        V
                    @endif
                </td>
                <td class="col-ket"></td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
