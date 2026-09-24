<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Lembar Hasil Penelitian (LHP) Nomor {{ $lhp->nomor_lhp ?? '-' }}</title>
<style>
  /* Kertas sesuai dokumen asli: 215 x 330 mm, margin 1,5 / 2,5 / 2,5 / 2,5 cm, Arial 10pt */
  @page { size: 215.05mm 330.06mm; margin: 15mm 25mm 25mm 25mm; }
  * { box-sizing: border-box; }
  /* JANGAN taruh margin/padding di selector html: DomPDF memakai style elemen
     html untuk menghitung margin @page, jadi "html { margin: 0 }" akan
     menimpa margin @page yang sudah diset (jadi 0 / mepet tanpa margin). */
  body { margin: 0; padding: 0; font-family: Arial, Helvetica, "Liberation Sans", sans-serif; font-size: 10pt; line-height: 1.25; color: #000; }
  p { margin: 0; }
  table { border-collapse: collapse; width: 100%; }
  td { vertical-align: top; padding: 0 3px; }
  .just { text-align: justify; }
  .center { text-align: center; }

  /* Kop surat dengan logo */
  .kop { position: relative; min-height: 2.57cm; padding-left: 2.9cm; border-bottom: 1.5pt solid #000; padding-bottom: 6px; }
  .kop img { position: absolute; left: 0.05cm; top: 0; width: 2.77cm; height: 2.57cm; }
  .kop p { text-align: center; font-weight: bold; font-size: 11pt; line-height: 1.2; }
  .kop .k1 { font-size: 13pt; }
  .kop .alamat { font-weight: normal; font-size: 7pt; margin-top: 2px; }

  .judul { text-align: center; margin: 22px 0 16px; }
  .judul .t { font-weight: bold; text-decoration: underline; font-size: 11pt; }

  .ref { width: 101.5%; margin-left: -1px; }
  .ref .c1 { width: 17.9%; } .ref .c2 { width: 3%; text-align: center; } .ref .c3 { width: 31.3%; } .ref .c4 { width: 19.4%; } .ref .c5 { width: 3%; text-align: center; }

  .bag { font-weight: bold; margin: 16px 0 3px; }
  .uraian { width: 98.1%; }
  .uraian .c1 { width: 4.6%; } .uraian .c2 { width: 4.6%; } .uraian .c3 { width: 33.7%; } .uraian .c4 { width: 3.1%; }

  .kotak td { border: 1px solid #000; padding: 3px 5px; }
  .kotak .k1 td { height: 1.45em; }
  .kotak .k4 td { height: 5.2em; }
  .kotak-text { text-align: left; white-space: pre-line; }

  .demikian { margin: 16px 0 18px; }
  /* Blok tanda tangan (kota/tanggal s.d. nama & NIP) satu kesatuan - kalau
     tidak muat di sisa halaman, seluruh blok didorong utuh ke halaman baru. */
  .ttd { page-break-inside: avoid; }
  .ttd td { padding: 1px 3px; }
  .ttd .spasi td { height: 64px; }
</style>
</head>
<body>
@php
    $split = $lhp->split;
    $lpf = optional($split)->lpf;
    $lpp = optional($lpf)->lpp;
    $lp = optional($lpp)->lp;
    $lphp = optional($lp)->lphp;
    $sbp = optional($lphp)->sbp;
@endphp
<div>

  <div class="kop">
    <img src="{{ public_path('assets/img/logo-kemenkeu.png') }}" alt="Logo Kementerian Keuangan">
    <p class="k1">KEMENTERIAN KEUANGAN REPUBLIK INDONESIA</p>
    <p>DIREKTORAT JENDERAL BEA DAN CUKAI</p>
    <p>KANTOR WILAYAH DIREKTORAT JENDERAL BEA DAN CUKAI ACEH</p>
    <p>KANTOR PENGAWASAN DAN PELAYANAN BEA DAN CUKAI</p>
    <p>TIPE MADYA PABEAN C BANDA ACEH</p>
    <p class="alamat">Jalan Soekarno Hatta Nomor 3a, Geuceu Menara, Banda Aceh 23241; TELEPON (0651) 43137; FAKSIMILE (0651) 43136; LAMAN www.beacukai.go.id; PUSAT KONTAK LAYANAN 1500225; SUREL bcaceh@customs.go.id</p>
  </div>

  <div class="judul">
    <p class="t">LEMBAR HASIL PENELITIAN (LHP)</p>
    <p>NOMOR: {{ $lhp->nomor_lhp ?? '-' }}</p>
  </div>

  <table class="ref">
    <tr><td class="c1">Nomor LP/LP-1</td><td class="c2">:</td><td class="c3">{{ optional($lp)->nomor_lp ?? '-' }}</td><td class="c4">Tanggal LP/LP-1</td><td class="c5">:</td><td>{{ optional(optional($lp)->tanggal_lp)->translatedFormat('d F Y') ?? '-' }}</td></tr>
    <tr><td class="c1">Nomor SPLIT</td><td class="c2">:</td><td class="c3">{{ optional($split)->nomor_split ?? '-' }}</td><td class="c4">Tanggal SPLIT</td><td class="c5">:</td><td>{{ optional(optional($split)->tanggal_split)->translatedFormat('d F Y') ?? '-' }}</td></tr>
  </table>

  <p class="bag">A. URAIAN PELANGGARAN</p>
  <table class="uraian">
    <tr><td colspan="3">Jenis Pelanggaran</td><td class="c4">:</td><td>{{ $lhp->jenis_pelanggaran ?? '-' }}</td></tr>
    <tr><td colspan="3">Locus</td><td class="c4">:</td><td>{{ optional($sbp)->lokasi_penindakan ?? '-' }}, Kec. {{ optional($sbp)->kecamatan_penindakan ?? '-' }}, {{ optional($sbp)->kota_penindakan ?? '-' }}</td></tr>
    <tr><td colspan="5">Tempus</td></tr>
    <tr><td class="c1">a.</td><td colspan="2">Tanggal</td><td class="c4">:</td><td>{{ optional(optional($sbp)->tanggal_sbp)->translatedFormat('d F Y') ?? '-' }}</td></tr>
    <tr><td class="c1">b.</td><td colspan="2">Waktu</td><td class="c4">:</td><td>{{ optional($sbp)->waktu_penindakan ?? '-' }} WIB</td></tr>

    <tr><td colspan="5">PELAKU PELANGGARAN</td></tr>
    <tr><td class="c1">a.</td><td colspan="4">Pelanggaran Administrasi</td></tr>
    @if(optional($lphp)->pelaku_tidak_ditemukan)
    <tr><td class="c1"></td><td colspan="2">Nama Pelanggar</td><td class="c4">:</td><td>Pelaku tidak ditemukan</td></tr>
    <tr><td class="c1"></td><td colspan="2">Tempat/Tanggal Lahir</td><td class="c4">:</td><td>-</td></tr>
    <tr><td class="c1"></td><td colspan="2">NIK/No.Paspor</td><td class="c4">:</td><td>-</td></tr>
    <tr><td class="c1"></td><td colspan="2">NPWP</td><td class="c4">:</td><td>-</td></tr>
    <tr><td class="c1"></td><td colspan="2">Nomor Telepon</td><td class="c4">:</td><td>-</td></tr>
    <tr><td class="c1"></td><td colspan="2">Nomor Rekening</td><td class="c4">:</td><td>-</td></tr>
    <tr><td class="c1"></td><td colspan="2">Jenis Kelamin</td><td class="c4">:</td><td>-</td></tr>
    <tr><td class="c1"></td><td colspan="2">Alamat</td><td class="c4">:</td><td>-</td></tr>
    @else
    <tr><td class="c1"></td><td colspan="2">Nama Pelanggar</td><td class="c4">:</td><td>{{ optional($sbp)->nama_pelaku ?? '-' }}</td></tr>
    <tr><td class="c1"></td><td colspan="2">Tempat/Tanggal Lahir</td><td class="c4">:</td><td>-</td></tr>
    <tr><td class="c1"></td><td colspan="2">NIK/No.Paspor</td><td class="c4">:</td><td>{{ optional($sbp)->nomor_identitas ?? '-' }}</td></tr>
    <tr><td class="c1"></td><td colspan="2">NPWP</td><td class="c4">:</td><td>-</td></tr>
    <tr><td class="c1"></td><td colspan="2">Nomor Telepon</td><td class="c4">:</td><td>{{ optional($sbp)->no_hp ?? '-' }}</td></tr>
    <tr><td class="c1"></td><td colspan="2">Nomor Rekening</td><td class="c4">:</td><td>-</td></tr>
    <tr><td class="c1"></td><td colspan="2">Jenis Kelamin</td><td class="c4">:</td><td>{{ optional($sbp)->jenis_kelamin ?? '-' }}</td></tr>
    <tr><td class="c1"></td><td colspan="2">Alamat</td><td class="c4">:</td><td>{{ optional($sbp)->alamat_di_indonesia ?? '-' }}</td></tr>
    @endif
    <tr><td class="c1"></td><td colspan="2">Pengulangan Pelanggaran</td><td class="c4">:</td><td>-</td></tr>
    <tr><td class="c1">b</td><td colspan="4">Pelanggaran Pidana Dengan Pelaku Tidak Dikenal</td></tr>
    <tr><td class="c1"></td><td colspan="4">Saksi-saksi</td></tr>
    @if($lhp->saksi_saksi)
    <tr><td class="c1"></td><td colspan="4" class="just" style="white-space: pre-line;">{{ $lhp->saksi_saksi }}</td></tr>
    @else
    <tr><td class="c1"></td><td class="c2">a)</td><td class="c3">Nama</td><td class="c4">:</td><td>-</td></tr>
    <tr><td class="c1"></td><td class="c2"></td><td class="c3">NIK/No. Passport</td><td class="c4">:</td><td>-</td></tr>
    <tr><td class="c1"></td><td class="c2"></td><td class="c3">Nomor Telepon</td><td class="c4">:</td><td>-</td></tr>
    <tr><td class="c1"></td><td class="c2"></td><td class="c3">Jenis Kelamin</td><td class="c4">:</td><td>-</td></tr>
    <tr><td class="c1"></td><td class="c2"></td><td class="c3">Alamat</td><td class="c4">:</td><td>-</td></tr>
    @endif

    <tr><td colspan="5">URAIAN BARANG</td></tr>
    <tr><td class="c1">a.</td><td colspan="2">Komoditas</td><td class="c4">:</td><td>{{ optional($sbp)->jenis_barang ?? '-' }}</td></tr>
    <tr><td class="c1">b.</td><td colspan="2">Uraian Barang</td><td class="c4">:</td><td>{{ optional($sbp)->uraian_barang ?? '-' }}</td></tr>
    <tr><td class="c1">c.</td><td colspan="2">Merk/type</td><td class="c4">:</td><td>-</td></tr>
    <tr><td class="c1">d.</td><td colspan="2">Kondisi</td><td class="c4">:</td><td>-</td></tr>
    <tr><td class="c1">e.</td><td colspan="2">Kemasan</td><td class="c4">:</td><td>-</td></tr>
    @if($lhp->uraian_barang_tambahan)
    <tr><td class="c1"></td><td colspan="4" class="just" style="white-space: pre-line;">{{ $lhp->uraian_barang_tambahan }}</td></tr>
    @endif

    <tr><td colspan="5">SARANA PENGANGKUT</td></tr>
    <tr><td class="c1">a.</td><td colspan="2">Pengangkut</td><td class="c4">:</td><td>-</td></tr>
    <tr><td class="c1">b.</td><td colspan="2">Jenis Sarana Pengangkut</td><td class="c4">:</td><td>-</td></tr>
    <tr><td class="c1">c.</td><td colspan="2">Nomor Polisi/Nomor Voyage</td><td class="c4">:</td><td>-</td></tr>
    <tr><td class="c1">d.</td><td colspan="2">Bukti Kepemilikan</td><td class="c4">:</td><td>-</td></tr>
    <tr><td class="c1">e.</td><td colspan="2">Nomor Kontainer</td><td class="c4">:</td><td>-</td></tr>
    <tr><td class="c1">f.</td><td colspan="2">Surat Jalan</td><td class="c4">:</td><td>-</td></tr>
    @if($lhp->sarana_pengangkut)
    <tr><td class="c1"></td><td colspan="4" class="just" style="white-space: pre-line;">{{ $lhp->sarana_pengangkut }}</td></tr>
    @endif

    <tr><td colspan="5">DOKUMEN-DOKUMEN</td></tr>
    <tr><td class="c1">a.</td><td colspan="2">&bull;&nbsp;Dokumen Pabean/Cukai</td><td class="c4">:</td><td>-</td></tr>
    <tr><td class="c1"></td><td colspan="2">&bull;&nbsp;Nomor/Tanggal</td><td class="c4">:</td><td>-</td></tr>
    <tr><td class="c1"></td><td colspan="2">&bull;&nbsp;Masa Berlaku</td><td class="c4">:</td><td>-</td></tr>
    <tr><td class="c1">b.</td><td colspan="2">&bull;&nbsp;Dokumen Pelengkap</td><td class="c4">:</td><td>-</td></tr>
    <tr><td class="c1"></td><td colspan="2">&bull;&nbsp;Nomor/Tanggal</td><td class="c4">:</td><td>-</td></tr>
    <tr><td class="c1"></td><td colspan="2">&bull;&nbsp;Masa Berlaku</td><td class="c4">:</td><td>-</td></tr>
    <tr><td class="c1">c.</td><td colspan="2">Kantor Pendaftaran</td><td class="c4">:</td><td>-</td></tr>
    @if($lhp->dokumen_dokumen)
    <tr><td class="c1"></td><td colspan="4" class="just" style="white-space: pre-line;">{{ $lhp->dokumen_dokumen }}</td></tr>
    @endif
  </table>

  <p class="bag">B. MODUS PELANGGARAN</p>
  <table class="kotak"><tr><td class="kotak-text">{{ $lhp->modus_pelanggaran ?: '' }}</td></tr></table>

  <p class="bag">C. PEMENUHAN UNSUR PASAL</p>
  <table class="kotak"><tr><td class="kotak-text">{{ $lhp->pemenuhan_unsur_pasal ?: '' }}</td></tr></table>

  <p class="bag">D. KESIMPULAN</p>
  <table class="kotak"><tr class="k1"><td class="kotak-text">{{ $lhp->kesimpulan ?: '' }}</td></tr></table>

  <p class="bag">E. ALTERNATIF PENYELESAIAN PERKARA</p>
  <table class="kotak"><tr class="k1"><td class="kotak-text">{{ $lhp->alternatif_penyelesaian ?: '' }}</td></tr></table>

  <p class="bag">F. INFORMASI LAINNYA</p>
  <table class="kotak"><tr class="k4"><td class="kotak-text">{{ $lhp->informasi_lainnya ?: '' }}</td></tr></table>

  <p class="bag">G. CATATAN ATASAN</p>
  <table class="kotak"><tr class="k4"><td class="kotak-text">{{ $lhp->catatan_atasan ?: '' }}</td></tr></table>

  <p class="demikian">Demikian lembar hasil penelitian ini dibuat dengan kekuatan sumpah jabatan</p>

  <table class="ttd">
    <tr><td style="width:31.8%"></td><td style="width:33.3%"></td><td>Banda Aceh, {{ optional($lhp->tanggal_lhp)->translatedFormat('d F Y') ?? '-' }}</td></tr>
    <tr><td></td><td></td><td>Yang membuat LHP,</td></tr>
    <tr><td>Konseptor LHP</td><td></td><td>Pemeriksa Bea Cukai Ahli Pertama</td></tr>
    <tr class="spasi"><td></td><td></td><td></td></tr>
    <tr><td>{{ optional($lhp->konseptor)->nama ?? '-' }}</td><td></td><td>{{ optional($lhp->pemeriksa)->nama ?? '-' }}</td></tr>
    <tr><td>NIP {{ optional($lhp->konseptor)->nip_formatted ?? '-' }}</td><td></td><td>NIP {{ optional($lhp->pemeriksa)->nip_formatted ?? '-' }}</td></tr>
    <tr><td></td><td>Mengetahui,</td><td></td></tr>
    <tr><td></td><td>Kepala Seksi Penindakan dan Penyidikan</td><td></td></tr>
    <tr class="spasi"><td></td><td></td><td></td></tr>
    <tr><td></td><td>{{ optional($lhp->pengampu)->nama ?? '-' }}</td><td></td></tr>
    <tr><td></td><td>NIP {{ optional($lhp->pengampu)->nip_formatted ?? '-' }}</td><td></td></tr>
  </table>

</div>
</body>
</html>
