<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Lembar Penerimaan Perkara (LPP) Nomor {{ $lpp->nomor_lpp ?? '-' }}</title>
<style>
  /* Ukuran kertas sesuai dokumen asli: F4 / Folio 8,5 x 13 inci, font Arial 10pt */
  @page { size: 215.9mm 330.2mm; margin: 10mm 20mm 5mm 20mm; }

  * { box-sizing: border-box; }
  /* JANGAN taruh margin/padding di selector html: DomPDF memakai style elemen
     html untuk menghitung margin @page, jadi "html { margin: 0 }" akan
     menimpa margin @page yang sudah diset (jadi 0 / mepet tanpa margin). */
  body { margin: 0; padding: 0; }
  body {
    font-family: Arial, Helvetica, "Liberation Sans", sans-serif;
    font-size: 10pt;
    line-height: 1.35;
    color: #000;
  }
  .kop p { margin: 0; font-weight: bold; }
  .kop .u { text-decoration: underline; }

  .judul { text-align: center; margin: 22px 0 18px; }
  .judul p { margin: 0; }
  .judul .t { font-weight: bold; text-decoration: underline; }

  table { border-collapse: collapse; width: 100%; }
  td { vertical-align: top; padding: 0 3px; }
  .c { width: 2.5%; }             /* kolom titik dua */

  /* Tabel nomor LP & SBP */
  .ref td { padding-top: 0; padding-bottom: 1px; }
  .ref .lbl { width: 17%; }
  .ref .val { width: 50%; }
  .ref .tgl { width: 11%; }

  /* Tabel isian utama */
  .isi td { padding-top: 1px; padding-bottom: 1px; }
  .isi .h  { width: 6%; }         /* huruf A-H */
  .isi .n  { width: 4.5%; }       /* nomor 1-4 */
  .isi .l  { width: 26%; }        /* label */
  .isi .v  { width: 61%; text-align: justify; }
  .isi .sub  { padding-left: 4px; }
  .isi .sub2 { padding-left: 26px; }
  .gap td { padding-top: 8px; }

  /* Blok tanda tangan */
  /* Blok tanda tangan (kota/tanggal s.d. nama & NIP) satu kesatuan - kalau
     tidak muat di sisa halaman, seluruh blok didorong utuh ke halaman baru. */
  .ttd { margin-top: 36px; page-break-inside: avoid; }
  .ttd td { padding: 1px 3px; }
  .ttd .k1 { width: 31%; }
  .ttd .k2 { width: 34%; }
  .ttd .k3 { width: 35%; }
  .ttd .space td { height: 64px; }
</style>
</head>
<body>
@php
    $lp = $lpp->lp;
    $lphp = optional($lp)->lphp;
    $sbp = optional($lphp)->sbp;
@endphp

  <div class="kop">
    <p>Kementerian Keuangan Republik Indonesia</p>
    <p>Direktorat Jenderal Bea dan Cukai</p>
    <p>Kantor Wilayah Direktorat Jenderal Bea dan Cukai Aceh</p>
    <p class="u">Kantor Pengawasan dan Pelayanan Bea dan Cukai Tipe Madya Pabean C Banda Aceh</p>
  </div>

  <div class="judul">
    <p class="t">LEMBAR PENERIMAAN PERKARA (LPP)</p>
    <p>Nomor {{ $lpp->nomor_lpp ?? '-' }}</p>
  </div>

  <table class="ref">
    <tr>
      <td class="lbl">LP/Surat Nomor</td><td class="c">:</td><td class="val">{{ optional($lp)->nomor_lp ?? '-' }}</td>
      <td class="tgl">Tanggal</td><td class="c">:</td><td>{{ optional(optional($lp)->tanggal_lp)->translatedFormat('d F Y') ?? '-' }}</td>
    </tr>
    <tr>
      <td class="lbl">SBP Nomor</td><td class="c">:</td><td class="val">{{ optional($sbp)->nomor_sbp ?? '-' }}</td>
      <td class="tgl">Tanggal</td><td class="c">:</td><td>{{ optional(optional($sbp)->tanggal_sbp)->translatedFormat('d F Y') ?? '-' }}</td>
    </tr>
  </table>

  <table class="isi">
    <tr><td class="h">A.</td><td colspan="2">Asal Perkara</td><td class="c">:</td><td class="v">{{ $lpp->asal_perkara ?? '-' }}</td></tr>
    <tr><td class="h">B.</td><td colspan="2">Jenis Penindakan</td><td class="c">:</td><td class="v">{{ $lpp->jenis_penindakan ?? '-' }}</td></tr>
    <tr><td class="h">C.</td><td colspan="2">Jenis Perkara</td><td class="c">:</td><td class="v">{{ optional($lphp)->dugaan_pelanggaran ?? '-' }}</td></tr>
    <tr><td class="h">D.</td><td colspan="2">Status Pelanggaran</td><td class="c">:</td><td class="v">{{ $lpp->status_pelanggaran ?? '-' }}</td></tr>
    <tr><td class="h">E.</td><td colspan="2">Uraian Pelanggaran</td><td class="c">:</td><td class="v">{{ $lpp->uraian_pelanggaran ?? '-' }}</td></tr>

    <tr><td class="h"></td><td class="n">1.</td><td class="l">Jenis Pelanggaran</td><td class="c">:</td><td class="v">Diduga melanggar {{ optional($lphp)->pasal ?? '-' }} {{ optional($lphp)->uu_terkait ?? '' }}</td></tr>
    <tr class="gap"><td class="h"></td><td class="n">2.</td><td class="l">Modus Operandi</td><td class="c">:</td><td class="v">{{ optional($sbp)->alasan_penindakan ?? '-' }}</td></tr>

    <tr><td class="h"></td><td class="n">3.</td><td class="l">Lokasi</td><td class="c"></td><td class="v"></td></tr>
    <tr><td class="h"></td><td class="n"></td><td class="l sub">a.&nbsp;&nbsp;Tempat</td><td class="c">:</td><td class="v">{{ optional($sbp)->lokasi_penindakan ?? '-' }}, Kec. {{ optional($sbp)->kecamatan_penindakan ?? '-' }}, {{ optional($sbp)->kota_penindakan ?? '-' }}</td></tr>
    <tr><td class="h"></td><td class="n"></td><td class="l sub">b.&nbsp;&nbsp;Tanggal</td><td class="c">:</td><td class="v">{{ optional($sbp)->waktu_penindakan ?? '-' }} WIB</td></tr>

    <tr><td class="h"></td><td class="n">4.</td><td class="l">Pelaku Pelanggaran</td><td class="c"></td><td class="v"></td></tr>
    @if(optional($lphp)->pelaku_tidak_ditemukan)
    <tr><td class="h"></td><td class="n"></td><td class="l sub">a.&nbsp;&nbsp;Nama</td><td class="c">:</td><td class="v">Pelaku tidak ditemukan</td></tr>
    <tr><td class="h"></td><td class="n"></td><td class="l sub2">Umur</td><td class="c">:</td><td class="v">-</td></tr>
    <tr><td class="h"></td><td class="n"></td><td class="l sub2">Jenis Kelamin</td><td class="c">:</td><td class="v">-</td></tr>
    <tr><td class="h"></td><td class="n"></td><td class="l sub2">Alamat</td><td class="c">:</td><td class="v">-</td></tr>
    <tr><td class="h"></td><td class="n"></td><td class="l sub2">Keterangan</td><td class="c">:</td><td class="v">-</td></tr>
    @else
    <tr><td class="h"></td><td class="n"></td><td class="l sub">a.&nbsp;&nbsp;Nama</td><td class="c">:</td><td class="v">{{ optional($sbp)->nama_pelaku ?? '-' }}</td></tr>
    <tr><td class="h"></td><td class="n"></td><td class="l sub2">Umur</td><td class="c">:</td><td class="v">-</td></tr>
    <tr><td class="h"></td><td class="n"></td><td class="l sub2">Jenis Kelamin</td><td class="c">:</td><td class="v">{{ optional($sbp)->jenis_kelamin ?? '-' }}</td></tr>
    <tr><td class="h"></td><td class="n"></td><td class="l sub2">Alamat</td><td class="c">:</td><td class="v">{{ optional($sbp)->alamat_di_indonesia ?? '-' }}</td></tr>
    <tr><td class="h"></td><td class="n"></td><td class="l sub2">Keterangan</td><td class="c">:</td><td class="v">-</td></tr>
    @endif

    <tr><td class="h">F.</td><td colspan="2">Barang Hasil Penindakan</td><td class="c"></td><td class="v"></td></tr>
    <tr><td class="h"></td><td class="n">1.</td><td class="l">Komoditi</td><td class="c">:</td><td class="v">{{ optional($sbp)->jenis_barang ?? '-' }}</td></tr>
    <tr><td class="h"></td><td class="n">2.</td><td class="l">Jumlah</td><td class="c">:</td><td class="v">{{ optional($sbp)->jumlah_barang ?? '-' }} {{ optional($sbp)->jenis_satuan ?? '' }}</td></tr>
    <tr><td class="h"></td><td class="n">3.</td><td class="l">Detail Uraian Barang</td><td class="c">:</td><td class="v">{{ optional($sbp)->uraian_barang ?? '-' }}</td></tr>

    <tr class="gap"><td class="h">G.</td><td colspan="2">Dokumen Barang</td><td class="c">:</td><td class="v">{{ $lpp->dokumen_barang ?? '-' }}</td></tr>
    <tr><td class="h">H.</td><td colspan="2">Catatan Atasan Pembuat LPP</td><td class="c">:</td><td class="v">{{ $lpp->catatan_atasan ?? '-' }}</td></tr>
  </table>

  <table class="ttd">
    <tr><td class="k1"></td><td class="k2"></td><td class="k3">Banda Aceh, {{ optional($lpp->tanggal_lpp)->translatedFormat('d F Y') ?? '-' }}</td></tr>
    <tr><td class="k1"></td><td class="k2"></td><td class="k3">Yang membuat LPP,</td></tr>
    <tr><td class="k1">Konseptor LPP</td><td class="k2"></td><td class="k3">Pemeriksa Bea Cukai Ahli Pertama</td></tr>
    <tr class="space"><td></td><td></td><td></td></tr>
    <tr><td class="k1">{{ optional($lpp->konseptor)->nama ?? '-' }}</td><td class="k2"></td><td class="k3">{{ optional($lpp->pemeriksa)->nama ?? '-' }}</td></tr>
    <tr><td class="k1">NIP {{ optional($lpp->konseptor)->nip_formatted ?? '-' }}</td><td class="k2"></td><td class="k3">NIP {{ optional($lpp->pemeriksa)->nip_formatted ?? '-' }}</td></tr>
    <tr><td class="k1"></td><td class="k2">Mengetahui,</td><td class="k3"></td></tr>
    <tr><td class="k1"></td><td class="k2">Kepala Seksi Penindakan dan Penyidikan</td><td class="k3"></td></tr>
    <tr class="space"><td></td><td></td><td></td></tr>
    <tr><td class="k1"></td><td class="k2">{{ optional($lpp->pengampu)->nama ?? '-' }}</td><td class="k3"></td></tr>
    <tr><td class="k1"></td><td class="k2">NIP {{ optional($lpp->pengampu)->nip_formatted ?? '-' }}</td><td class="k3"></td></tr>
  </table>

</body>
</html>
