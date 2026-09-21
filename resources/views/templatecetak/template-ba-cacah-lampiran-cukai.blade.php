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

        .doc-title-lampiran-wrap {
            width: 100%;
            border: none;
            margin-bottom: 10px;
        }

        .doc-title-lampiran-wrap td {
            border: none;
            padding: 0;
        }

        .doc-title-lampiran {
            text-align: left;
            font-weight: normal;
            font-size: 9pt;
        }

        .doc-title-lampiran-info td {
            border: none;
            padding: 0 4px 0 0;
            text-align: left;
            vertical-align: top;
        }
    </style>
</head>
<body>

    <table class="doc-title-lampiran-wrap">
        <tr>
            <td style="width: 60%;"></td>
            <td class="doc-title-lampiran">
                <div>Lampiran Berita Acara Pencacahan</div>
                <table class="doc-title-lampiran-info">
                    <tr>
                        <td style="width: 55px;">Nomor</td>
                        <td style="width: 10px;">:</td>
                        <td>{{ $pencacahan->no_ba_cacah ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td>Tanggal</td>
                        <td>:</td>
                        <td>{{ optional($pencacahan->tanggal_ba_cacah)->translatedFormat('d F Y') ?? '-' }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    @php
        // DomPDF tidak mendukung page-break-inside/before pada tbody atau tr di dalam sebuah
        // <table> (penanganan break ditekan selama reflow tabel), sehingga satu grup SBP yang
        // memakai rowspan (kolom No & SBP) bisa terpotong di tengah halaman dan kehilangan sel
        // rowspan-nya. Solusinya: pecah jadi beberapa <table> terpisah per halaman (page-break
        // pada elemen <table> didukung dengan baik), dengan rowspan dihitung ulang per tabel.
        //
        // Estimasi jumlah baris yang muat per halaman (folio landscape, font 8pt), dengan margin
        // aman. Halaman pertama sedikit lebih kecil karena ada blok judul lampiran di atas tabel.
        $rowsPerPageFirst = 24;
        $rowsPerPageNext = 26;

        $pageChunks = [];
        $currentChunk = [];
        $currentPageRows = 0;
        $isFirstPage = true;

        foreach ($sbpList as $sbpIndex => $sbp) {
            $detailsForSbp = $detailsList->where('pencacahan_sbp_id', $sbp->pivot->id);
            $detailCount = $detailsForSbp->count();
            $rowsForGroup = max($detailCount, 1);
            $pageCapacity = $isFirstPage ? $rowsPerPageFirst : $rowsPerPageNext;

            if ($currentPageRows > 0 && ($currentPageRows + $rowsForGroup) > $pageCapacity) {
                $pageChunks[] = $currentChunk;
                $currentChunk = [];
                $currentPageRows = 0;
                $isFirstPage = false;
            }

            $currentChunk[] = [
                'sbpIndex' => $sbpIndex,
                'sbp' => $sbp,
                'details' => $detailsForSbp,
                'count' => $detailCount,
            ];
            $currentPageRows += $rowsForGroup;
        }

        if (!empty($currentChunk)) {
            $pageChunks[] = $currentChunk;
        }

        if (empty($pageChunks)) {
            $pageChunks[] = [];
        }
    @endphp

    @foreach($pageChunks as $chunkIndex => $chunk)
        <table class="main-table" @if($chunkIndex > 0) style="page-break-before: always;" @endif>
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
            @forelse($chunk as $item)
                @php
                    $sbpIndex = $item['sbpIndex'];
                    $sbp = $item['sbp'];
                    $detailsForSbp = $item['details'];
                    $detailCount = $item['count'];
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
                                <td class="text-left">{{ $detail->jumlah_tampil }}</td>
                                <td>{{ $detail->kondisi_barang ?? '-' }}</td>
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
    @endforeach

</body>
</html>
