<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>{{ $pencacahan->no_ba_cacah ?? '' }}</title>
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
            font-weight: bold;
            margin-bottom: 4px;
        }

        /* ===== CONTENT ===== */
        .content-table td {
            padding: 2px 2px;
            line-height: 1;
        }

        .indent {
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

        .full-width {
            text-align: justify;
            line-height: 1.5;
            padding: 4px 2px;
        }

        /* ===== SIGNATURE ===== */
        .signature {
            margin-top: 20px;
        }

        .signature td {
            padding: 2px;
        }

        .signature .sig-left {
            width: 50%;
        }

        .signature .sig-right {
            width: 50%;
        }

        .electronic-sign {
            color: #d0cece;
            font-size: 11pt;
            margin-top: 80px;
            margin-bottom: 2px;
        }

        .name {
            margin-top: 0;
        }

        /* ===== PAGE BREAK ===== */
        .page-break {
            page-break-before: always;
            page-break-inside: avoid; /* Mencegah elemen ini terpotong di tengah halaman */
        }

        /* ===== FOTO TABLE ===== */
        .foto-table {
            width: 100%;
            table-layout: fixed;
            border-collapse: collapse;
        }

        .foto-table td {
            width: 50%;
            border: 1px solid #000;
            padding: 5mm;
            box-sizing: border-box;
            vertical-align: top;
            text-align: center;
        }

        .foto-table th {
            border: 1px solid #000;
            padding: 5px;
            text-align: center;
            font-weight: bold;
        }

        .foto-table td img {
            width: 70mm;
            height: 70mm;
            object-fit: cover;
            display: inline-block;
        }

        .foto-caption {
            font-size: 8pt;
            text-align: center;
            margin-top: 4px;
        }

        .doc-title-lampiran {
            text-align: center;
            font-weight: bold;
            margin: 10px 0;
        }
    </style>
</head>

<body>

    {{-- ===== HALAMAN 1: BERITA ACARA PENCACAHAN ===== --}}

    <table class="header-table">
        <tbody>
            <tr>
                <td class="logo"><img src="{{ public_path('assets/img/logo-kemenkeu.png') }}" width="87"></td>
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
        <h3>BERITA ACARA PENCACAHAN</h3>
        <p>Nomor : {{ $pencacahan->no_ba_cacah ?? '-' }}</p>
    </div>

    <table class="content-table">
        <tbody>
            {{-- INTRO TEXT --}}
            <tr>
                <td colspan="4" class="full-width">
                    Pada hari ini {{ optional($pencacahan->tanggal_ba_cacah)->translatedFormat('l') ?? '-' }} tanggal {{ optional($pencacahan->tanggal_ba_cacah)->translatedFormat('d F Y') ?? '-' }} bertempat di {{ $pencacahan->lokasi_cacah ?? 'KPPBC TMP C Banda Aceh' }}, berdasarkan Surat Tugas Kepala Seksi Penindakan dan Penyidikan nomor {{ $pencacahan->no_surat_tugas_pencacahan ?? '-' }} tanggal {{ optional($pencacahan->tanggal_surat_tugas_pencacahan)->translatedFormat('d F Y') ?? '-' }}, Saya :
                </td>
            </tr>

            {{-- PETUGAS 1 --}}
            <tr><td colspan="4"><br></td></tr>
            <tr>
                <td class="indent"></td>
                <td class="label">Nama</td>
                <td class="colon">:</td>
                <td class="value">{{ optional($pencacahan->petugas1)->nama ?? '-' }}</td>
            </tr>
            <tr>
                <td class="indent"></td>
                <td class="label">NIP</td>
                <td class="colon">:</td>
                <td class="value">{{ optional($pencacahan->petugas1)->nip_formatted ?? optional($pencacahan->petugas1)->nip ?? '-' }}</td>
            </tr>
            <tr>
                <td class="indent"></td>
                <td class="label">Pangkat/Gol</td>
                <td class="colon">:</td>
                <td class="value">{{ optional($pencacahan->petugas1)->pangkat ?? '-' }} / {{ optional($pencacahan->petugas1)->golongan ?? '-' }}</td>
            </tr>
            <tr>
                <td class="indent"></td>
                <td class="label">Jabatan</td>
                <td class="colon">:</td>
                <td class="value">{{ optional($pencacahan->petugas1)->jabatan ?? '-' }}</td>
            </tr>

            {{-- BERSAMA-SAMA DENGAN --}}
            <tr><td colspan="4"><br></td></tr>
            <tr>
                <td colspan="4" class="full-width">Bersama-sama dengan :</td>
            </tr>
            <tr><td colspan="4"><br></td></tr>

            {{-- PETUGAS 2 --}}
            <tr>
                <td class="indent"></td>
                <td class="label">Nama</td>
                <td class="colon">:</td>
                <td class="value">{{ optional($pencacahan->petugas2)->nama ?? '-' }}</td>
            </tr>
            <tr>
                <td class="indent"></td>
                <td class="label">NIP</td>
                <td class="colon">:</td>
                <td class="value">{{ optional($pencacahan->petugas2)->nip_formatted ?? optional($pencacahan->petugas2)->nip ?? '-' }}</td>
            </tr>
            <tr>
                <td class="indent"></td>
                <td class="label">Pangkat/Gol</td>
                <td class="colon">:</td>
                <td class="value">{{ optional($pencacahan->petugas2)->pangkat ?? '-' }} / {{ optional($pencacahan->petugas2)->golongan ?? '-' }}</td>
            </tr>
            <tr>
                <td class="indent"></td>
                <td class="label">Jabatan</td>
                <td class="colon">:</td>
                <td class="value">{{ optional($pencacahan->petugas2)->jabatan ?? '-' }}</td>
            </tr>

            {{-- URAIAN PENCACAHAN --}}
            <tr><td colspan="4"><br></td></tr>
            <tr>
                <td colspan="4" class="full-width">
                    telah melakukan pencacahan terhadap Barang Hasil Penindakan yang berasal dari penindakan {{ $pencacahan->giat ?? '' }} di wilayah {{ $pencacahan->sbp->pluck('kota_penindakan')->unique()->implode(', ') }} dengan surat bukti penindakan nomor {{ $pencacahan->sbp->pluck('nomor_sbp')->implode(', ') }}. Hasil pencacahan sebagaimana terlampir.
                </td>
            </tr>

            <tr><td colspan="4"><br></td></tr>
            <tr>
                <td colspan="4" class="full-width">
                    Atas Barang Hasil Penindakan tersebut di atas kemudian dilakukan penyimpanan di {{ $pencacahan->tempat_penyimpanan ?? 'gudang penyimpanan pada KPPBC TMP C Banda Aceh' }}.
                </td>
            </tr>

            <tr><td colspan="4"><br></td></tr>
            <tr>
                <td colspan="4" class="full-width">
                    Demikian Berita Acara Hasil Penindakan ini dibuat dengan sebenarnya dan ditandatangani pada tempat dan waktu tersebut di atas.
                </td>
            </tr>
        </tbody>
    </table>

    {{-- TANDA TANGAN HALAMAN 1 --}}
    <table class="signature">
        <tbody>
            <tr>
                <td colspan="2">Yang Melakukan Pencacahan,</td>
            </tr>
            <tr>
                <td class="sig-left">
                    <div class="electronic-sign">Ditandatangani secara elektronik</div>
                    <div class="name">
                        {{ optional($pencacahan->petugas1)->nama ?? '-' }}<br>
                        NIP {{ optional($pencacahan->petugas1)->nip_formatted ?? optional($pencacahan->petugas1)->nip ?? '-' }}
                    </div>
                </td>
                <td class="sig-right">
                    <div class="electronic-sign">Ditandatangani secara elektronik</div>
                    <div class="name">
                        {{ optional($pencacahan->petugas2)->nama ?? '-' }}<br>
                        NIP {{ optional($pencacahan->petugas2)->nip_formatted ?? optional($pencacahan->petugas2)->nip ?? '-' }}
                    </div>
                </td>
            </tr>
        </tbody>
    </table>

    {{-- BAGIAN LAMPIRAN LANSKAP DIHAPUS DARI SINI --}}

    {{-- ===== HALAMAN 3: DOKUMENTASI FOTO ===== --}}
    @if(isset($pencacahan->photos) && $pencacahan->photos->count() > 0)
        <div class="page-break">
            <div class="doc-title-lampiran">
                DOKUMENTASI<br>
                PENCACAHAN BARANG HASIL PENINDAKAN
            </div>

            <table class="foto-table">
                <thead>
                    <tr>
                        <th style="width: 5%;">No.</th>
                        <th style="width: 30%;">Nomor SBP</th>
                        <th style="width: 65%;">Dokumentasi</th>
                    </tr>
                </thead>
                <tbody>
                    @php $photoCounter = 1; @endphp
                    @foreach($pencacahan->sbp as $sbp)
                        @php
                            $photos = $pencacahan->photos->where('pencacahan_sbp_id', $sbp->pivot->id);
                        @endphp
                        @if($photos->isNotEmpty())
                            <tr>
                                <td>{{ $photoCounter++ }}</td>
                                <td>{{ $sbp->nomor_sbp ?? '-' }}</td>
                                <td>
                                    @foreach($photos as $photo)
                                        @if(Illuminate\Support\Facades\Storage::disk('public')->exists($photo->path))
                                            @php
                                                $imageData = base64_encode(Illuminate\Support\Facades\Storage::disk('public')->get($photo->path));
                                                $imageMime = Illuminate\Support\Facades\Storage::disk('public')->mimeType($photo->path);
                                            @endphp
                                            <img src="data:{{ $imageMime }};base64,{{ $imageData }}" alt="Foto Dokumentasi SBP {{ $sbp->nomor_sbp }}">
                                        @else
                                            <p>Gambar tidak ditemukan di path: {{ $photo->path }}</p>
                                        @endif
                                    @endforeach
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>

            <br>

            {{-- TANDA TANGAN DOKUMENTASI --}}
            <table class="signature">
                <tbody>
                    <tr>
                        <td colspan="2">Yang Melakukan Pencacahan,</td>
                    </tr>
                    <tr>
                        <td class="sig-left">
                            <div class="electronic-sign">Ditandatangani secara elektronik</div>
                            <div class="name">
                                {{ optional($pencacahan->petugas1)->nama ?? '-' }}<br>
                                NIP {{ optional($pencacahan->petugas1)->nip_formatted ?? optional($pencacahan->petugas1)->nip ?? '-' }}
                            </div>
                        </td>
                        <td class="sig-right">
                            <div class="electronic-sign">Ditandatangani secara elektronik</div>
                            <div class="name">
                                {{ optional($pencacahan->petugas2)->nama ?? '-' }}<br>
                                NIP {{ optional($pencacahan->petugas2)->nip_formatted ?? optional($pencacahan->petugas2)->nip ?? '-' }}
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    @endif

</body>

</html>