<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>{{ $lpt->nomor_lpt ?? '-' }}</title>
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

        p { margin: 0; }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td { vertical-align: top; }

        /* ===== HEADER ===== */
        .header-table td {
            border-bottom: 2px solid #000;
            padding-bottom: 8px;
        }
        .header-text { text-align: center; }
        .header-text h1 { font-size: 13pt; margin: 0; }
        .header-text h2 { font-size: 11pt; margin: 0; }
        .header-text p { font-size: 8pt; margin-top: 4px; }

        /* ===== TITLE ===== */
        .title { text-align: center; margin: 12px 0; }
        .title h3 { font-size: 11pt; text-decoration: underline; margin-bottom: 4px; }

        /* ===== CONTENT ===== */
        .content-table td { padding: 2px 2px; line-height: 1; }
        .num { width: 30px; text-align: center; }
        .value { text-align: justify; word-wrap: break-word; padding: 2px 2px; }
        .full-width { text-align: justify; line-height: 1.5; padding: 4px 2px; }

        /* ===== LIST ===== */
        ol { margin: 0; padding-left: 20px; }
        ol li { text-align: justify; line-height: 1.5; padding: 2px 0; }

        /* ===== SIGNATURE ===== */
        .signature { margin-top: 20px; }
        .signature td { padding: 2px; }
        .signature .sig-left { width: 50%; }
        .signature .sig-right { width: 50%; }
        .electronic-sign { color: #d0cece; font-size: 11pt; margin-top: 120px; margin-bottom: 2px; }
        .name { margin-top: 0; margin-bottom: 20px; }

        /* ===== PAGE BREAK ===== */
        .page-break { page-break-before: always; }

        /* ===== FOTO TABLE ===== */
        .foto-table {
            page-break-before: always;
            width: 100%;
            table-layout: fixed;
            border-collapse: collapse;
        }
        .foto-table tr {
            /* No specific height, will adapt to content */
        }
        .foto-table td {
            width: 50%;
            height: 85mm; /* Cell height for 7cm image + padding + caption */
            border: 2px solid #000;
            padding: 5mm;
            box-sizing: border-box;
            vertical-align: top;
            text-align: center; /* Center the image and caption */
        }
        .foto-table td img {
            width: 70mm;   /* 7cm */
            height: 70mm;  /* 7cm */
            object-fit: cover; /* This prevents stretching */
            display: inline-block;
        }
        .foto-caption {
            font-size: 8pt;
            text-align: center;
            margin-top: 4px;
        }
    </style>
</head>

<body>

    {{-- ===== HEADER ===== --}}
    <table class="header-table">
        <tbody>
            <tr>
                <td style="width:90px"><img src="{{ public_path('assets/img/logo-kemenkeu.png') }}" width="87"></td>
                <td class="header-text">
                    <h1>KEMENTERIAN KEUANGAN REPUBLIK INDONESIA</h1>
                    <h2>DIREKTORAT JENDERAL BEA DAN CUKAI</h2>
                    <h2>KANTOR WILAYAH DIREKTORAT JENDERAL BEA DAN CUKAI ACEH</h2>
                    <h2>KANTOR PENGAWASAN DAN PELAYANAN BEA DAN CUKAI TIPE MADYA PABEAN C BANDA ACEH</h2>
                    <p>Jalan Soekarno Hatta Nomor 3a, Geuceu Menara, Banda Aceh 23241;<br>
                    TELEPON (0651) 43137; FAKSIMILE (0651) 43136; LAMAN www.beacukai.go.id;
                    PUSAT KONTAK LAYANAN 1500225; SUREL bc.bandaaceh@customs.go.id</p>
                </td>
            </tr>
        </tbody>
    </table>

    {{-- ===== JUDUL ===== --}}
    <div class="title">
        <h3>LAPORAN PELAKSANAAN TUGAS</h3>
        <p>Nomor : {{ $lpt->nomor_lpt ?? '-' }}</p>
    </div>

    {{-- ===== ISI LAPORAN ===== --}}
    <table class="content-table">
        <tbody>

            {{-- I. DASAR --}}
            <tr>
                <td class="num">I.</td>
                <td colspan="2" class="value">DASAR</td>
            </tr>
            <tr>
                <td class="num"></td>
                <td colspan="2" class="value">
                    Surat Perintah Nomor: {{ $lpt->sbp->nomor_surat_perintah ?? '-' }}
                    tanggal {{ optional($lpt->sbp->tanggal_surat_perintah)->translatedFormat('d F Y') ?? '-' }}
                </td>
            </tr>

            <tr><td class="num"><br></td><td colspan="2"><br></td></tr>

            {{-- II. WAKTU PELAKSANAAN TUGAS --}}
            <tr>
                <td class="num">II.</td>
                <td colspan="2" class="value">WAKTU PELAKSANAAN TUGAS</td>
            </tr>
            <tr>
                <td class="num"></td>
                <td colspan="2" class="value">
                    {{ optional($lpt->sbp->tanggal_sbp)->translatedFormat('d F Y') }}
                   </td>
            </tr>

            <tr><td class="num"><br></td><td colspan="2"><br></td></tr>

            {{-- III. WILAYAH TUGAS --}}
            <tr>
                <td class="num">III.</td>
                <td colspan="2" class="value">WILAYAH TUGAS</td>
            </tr>
            <tr>
                <td class="num"></td>
                <td colspan="2" class="value">{{ $lpt->sbp->lokasi_penindakan ?? '-' }}</td>
            </tr>

            <tr><td class="num"><br></td><td colspan="2"><br></td></tr>

            {{-- IV. PELAKSANA TUGAS --}}
            <tr>
                <td class="num">IV.</td>
                <td colspan="2" class="value">PELAKSANA TUGAS</td>
            </tr>
            <tr>
                <td class="num"></td>
                <td colspan="2" class="value">
                    <ol>
                        @if(isset($lpt->sbp->petugas1))
                            <li>{{ $lpt->sbp->petugas1->nama ?? '-' }}</li>
                        @endif
                        @if(isset($lpt->sbp->petugas2))
                            <li>{{ $lpt->sbp->petugas2->nama ?? '-' }}</li>
                        @endif
                    </ol>
                </td>
            </tr>

            <tr><td class="num"><br></td><td colspan="2"><br></td></tr>

            {{-- V. URAIAN PELAKSANAAN TUGAS --}}
            <tr>
                <td class="num">V.</td>
                <td colspan="2" class="value">URAIAN PELAKSANAAN TUGAS</td>
            </tr>
            <tr>
                <td class="num"></td>
                <td colspan="2" class="value">
                    <ol>
                        @if(isset($lpt->uraian_tugas) && is_array($lpt->uraian_tugas))
                            @foreach($lpt->uraian_tugas as $uraian)
                                <li>{{ $uraian }}</li>
                            @endforeach
                        @else
                            <li>
                                Telah dilaksanakan kegiatan penindakan terhadap barang berupa
                                <strong>{{ $lpt->sbp->uraian_barang ?? 'N/A' }}</strong>
                                yang dibawa oleh Sdr. <strong>{{ $lpt->sbp->nama_pelaku ?? 'N/A' }}</strong>.
                            </li>
                            <li>
                                Penumpang tersebut memiliki identitas berupa
                                {{ $lpt->sbp->jenis_identitas ?? 'N/A' }}
                                dengan nomor {{ $lpt->sbp->nomor_identitas ?? 'N/A' }}.
                            </li>
                            <li>
                                Penindakan dilakukan pada lokasi {{ $lpt->sbp->lokasi_penindakan ?? 'N/A' }}
                                dengan alasan {{ $lpt->sbp->alasan_penindakan ?? 'N/A' }}.
                            </li>
                            <li>
                                Atas barang tersebut diterbitkan Surat Bukti Penindakan (SBP) dengan nomor
                                <strong>{{ $lpt->sbp->nomor_sbp ?? 'N/A' }}</strong>
                                tanggal <strong>{{ optional($lpt->sbp->tanggal_sbp)->translatedFormat('d F Y') }}</strong>
                                dan salinannya telah diserahkan kepada yang bersangkutan.
                            </li>
                            <li>
                                Barang Hasil Penindakan (BHP) selanjutnya dibawa ke KPPBC TMP C Banda Aceh
                                untuk proses lebih lanjut.
                            </li>
                            <li>Dokumentasi kegiatan terlampir.</li>
                        @endif
                    </ol>
                </td>
            </tr>

            <tr><td class="num"><br></td><td colspan="2"><br></td></tr>

            {{-- VI. TINDAK LANJUT --}}
            <tr>
                <td class="num">VI.</td>
                <td colspan="2" class="value">TINDAK LANJUT</td>
            </tr>
            <tr>
                <td class="num"></td>
                <td colspan="2" class="value">
                    {{ $lpt->tindak_lanjut ?? 'Dilakukan penindakan terhadap barang tersebut dan dibawa ke KPPBC TMP C Banda Aceh untuk ditindaklanjuti' }}
                </td>
            </tr>

            <tr><td class="num"><br></td><td colspan="2"><br></td></tr>

            {{-- VII. KESIMPULAN --}}
            <tr>
                <td class="num">VII.</td>
                <td colspan="2" class="value">KESIMPULAN</td>
            </tr>
            <tr>
                <td class="num"></td>
                <td colspan="2" class="value">
                    Telah dilakukan pemeriksaan, penindakan, penegahan dan penyegelan terhadap
                    {{ $lpt->sbp->uraian_barang ?? 'N/A' }}, kemudian barang-barang dibawa ke
                    KPPBC TMP C Banda Aceh untuk ditindaklanjuti.
                </td>
            </tr>

        </tbody>
    </table>

    {{-- ===== HALAMAN 2: Penutup & Tanda Tangan ===== --}}
    <div class="page-break">
        <table class="content-table">
            <tbody>
                <tr><td colspan="3"><br></td></tr>
                <tr>
                    <td colspan="3" class="full-width">Demikian laporan dibuat dengan sebenarnya.</td>
                </tr>
            </tbody>
        </table>

        <table class="signature">
            <tbody>
                <tr>
                    <td class="sig-left">&nbsp;</td>
                    <td class="sig-right">
                        {{ $lpt->sbp->kota_penindakan ?? 'Banda Aceh' }},
                        {{ optional($lpt->tanggal_lpt)->translatedFormat('d F Y') ?? '-' }}
                    </td>
                </tr>
                <tr>
                    <td class="sig-left">&nbsp;</td>
                    <td class="sig-right">Pelaksana Tugas</td>
                </tr>

                @if(isset($lpt->sbp->petugas1))
                <tr>
                    <td class="sig-left">&nbsp;</td>
                    <td class="sig-right">
                        <div class="electronic-sign">Ditandatangani secara elektronik</div>
                        <div class="name">
                            {{ optional($lpt->sbp->petugas1)->nama ?? '-' }}<br>
                            NIP {{ optional($lpt->sbp->petugas1)->nip_formatted ?? '-' }}
                        </div>
                    </td>
                </tr>
                @endif

                @if(isset($lpt->sbp->petugas2))
                <tr>
                    <td class="sig-left">&nbsp;</td>
                    <td class="sig-right">
                        <div class="electronic-sign">Ditandatangani secara elektronik</div>
                        <div class="name">
                            {{ optional($lpt->sbp->petugas2)->nama ?? '-' }}<br>
                            NIP {{ optional($lpt->sbp->petugas2)->nip_formatted ?? '-' }}
                        </div>
                    </td>
                </tr>
                @endif

            </tbody>
        </table>
    </div>

    {{-- ===== HALAMAN 3: Dokumentasi Foto ===== --}}
    @if ($lpt->photos->isNotEmpty())
        <table class="foto-table">
            <tbody>
                @foreach ($lpt->photos->chunk(2) as $chunk)
                    <tr>
                        @foreach ($chunk as $photo)
                            <td>
                                @if(isset($photo->file_path) && Illuminate\Support\Facades\Storage::disk('public')->exists($photo->file_path))
                                    @php
                                        $imageData = base64_encode(Illuminate\Support\Facades\Storage::disk('public')->get($photo->file_path));
                                        $imageMime = Illuminate\Support\Facades\Storage::disk('public')->mimeType($photo->file_path);
                                    @endphp
                                    <img src="data:{{ $imageMime }};base64,{{ $imageData }}" alt="Foto Dokumentasi">
                                @else
                                    <p>Gambar tidak ditemukan.</p>
                                @endif
                                <p class="foto-caption">{{ $photo->caption ?? 'Dokumentasi' }}</p>
                            </td>
                        @endforeach
                        {{-- Tambahkan sel kosong jika jumlah foto ganjil di baris terakhir --}}
                        @if ($chunk->count() < 2)
                            <td></td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

</body>
</html>
