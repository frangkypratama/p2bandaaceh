<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Lampiran Berita Acara Pencacahan</title>
    <style>
        @page {
            size: 330mm 215mm; /* Folio Landscape */
            margin: 15mm;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 8pt;
            color: #000;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #000;
            padding: 4px 6px;
            text-align: center;
            vertical-align: middle;
            word-wrap: break-word;
        }

        /* Add a border between SBP groups */
        tbody {
             border-top: 2px solid #000;
        }
        /* Remove top border for the very first tbody */
        tbody:first-of-type {
            border-top: none;
        }

        .main-table th {
            font-weight: bold;
            border-bottom: 2px solid #000; /* Make header border thicker */
        }

        .text-left {
            text-align: left;
        }

        .doc-title-lampiran {
            text-align: center;
            font-weight: bold;
            font-size: 10pt;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

    <div class="doc-title-lampiran">
        LAMPIRAN BERITA ACARA PENCACAHAN<br>
        NOMOR: {{ $pencacahan->no_ba_cacah ?? '-' }}<br>
        TANGGAL: {{ optional($pencacahan->tanggal_ba_cacah)->translatedFormat('d F Y') ?? '-' }}
    </div>

    <table class="main-table">
        <thead class="main-header">
            <tr>
                <th rowspan="2">No</th>
                <th rowspan="2">SBP</th>
                <th rowspan="2">Kode Komoditi</th>
                <th rowspan="2">Jenis Barang</th>
                <th colspan="3">Ciri Khusus</th>
                <th rowspan="2">Subjek Cukai</th>
                <th colspan="4">Pita Cukai</th>
                <th rowspan="2">Jumlah</th>
                <th rowspan="2">Kondisi</th>
                <th rowspan="2">Ket.</th>
            </tr>
            <tr>
                <th>Merek</th>
                <th>Tipe</th>
                <th>Kadar</th>
                <th>Tahun</th>
                <th>Gol.</th>
                <th>Tarif</th>
                <th>Vol.</th>
            </tr>
        </thead>
        @forelse($pencacahan->sbp as $sbpIndex => $sbp)
            @php
                $detailsForSbp = $pencacahan->details->where('pencacahan_sbp_id', $sbp->pivot->id);
                $detailCount = $detailsForSbp->count();
            @endphp
            <tbody>
                @if ($detailCount > 0)
                    @foreach($detailsForSbp as $detail)
                        <tr>
                            @if($loop->first)
                                <td rowspan="{{ $detailCount }}">{{ $sbpIndex + 1 }}</td>
                                <td rowspan="{{ $detailCount }}">{{ $sbp->nomor_sbp }}</td>
                            @endif
                            <td>{{ optional($detail->jenisBarang)->nomor_urut ?? '-' }}</td>
                            <td class="text-left">{{ optional($detail->jenisBarang)->nama_barang ?? '-' }}</td>
                            <td>{{ $detail->merek ?? '-' }}</td>
                            <td>{{ $detail->tipe ?? '-' }}</td>
                            <td>{{ $detail->kadar ?? '-' }}</td>
                            <td>{{ $detail->subjek_cukai ?? '-' }}</td>
                            <td>{{ $detail->tahun_pita_cukai ?? '-' }}</td>
                            <td>{{ $detail->gol_pita_cukai ?? '-' }}</td>
                            <td>{{ $detail->tarif_cukai ?? '-' }}</td>
                            <td>{{ $detail->volume_pita_cukai ?? '-' }}</td>
                            <td class="text-left">{{ $detail->jumlah ?? '-' }} {{ optional($detail->satuan)->nama_satuan ?? '' }}</td>
                            <td>{{ $detail->kondisi ?? '-' }}</td>
                            <td>{{ $detail->keterangan ?? '-' }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td>{{ $sbpIndex + 1 }}</td>
                        <td>{{ $sbp->nomor_sbp }}</td>
                        <td colspan="13" class="text-center">-- Tidak ada detail barang untuk SBP ini --</td>
                    </tr>
                @endif
            </tbody>
        @empty
            <tbody>
                <tr>
                    <td colspan="15" class="text-center">Tidak ada SBP yang dilampirkan.</td>
                </tr>
            </tbody>
        @endforelse
    </table>

</body>
</html>