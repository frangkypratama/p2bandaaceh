<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Lembar Penelitian Formal (LPF) Nomor {{ $lpf->nomor_lpf ?? '-' }}</title>
<style>
  /* Kertas sesuai dokumen asli: F4 / Folio 8,5 x 13 inci, Arial 10pt */
  @page { size: 215.9mm 330.2mm; margin: 10mm 20mm 5mm 20mm; }
  * { box-sizing: border-box; }
  /* JANGAN taruh margin/padding di selector html: DomPDF memakai style elemen
     html untuk menghitung margin @page, jadi "html { margin: 0 }" akan
     menimpa margin @page yang sudah diset (jadi 0 / mepet tanpa margin). */
  body { margin: 0; padding: 0; }
  body { font-family: Arial, Helvetica, "Liberation Sans", sans-serif; font-size: 10pt; line-height: 1.3; color: #000; }
  p { margin: 0; }
  .kop p { font-weight: bold; }
  .u { text-decoration: underline; }
  .b { font-weight: bold; }
  .judul { margin: 16px 0 14px; text-align: center; }
  table { border-collapse: collapse; width: 100%; }
  td { vertical-align: top; padding: 0 3px; }
  .just { text-align: justify; }

  /* Judul bagian A-F. display:flex/inline-block tidak stabil di DomPDF,
     jadi pakai tabel satu baris untuk jarak huruf-judul. */
  .bag { font-weight: bold; margin: 8px 0 3px; width: auto; }
  .bag .hrf { width: 22px; }

  .ind { margin-left: 5.4%; width: 94.6%; }
  .w95 { width: 95.2%; }
  .sub  { padding-left: 4px; }
  .sub2 { padding-left: 24px; }

  .a .c1 { width: 3.1%; } .a .c2 { width: 26.9%; } .a .c3 { width: 3%; }
  .bk .c1 { width: 3.1%; } .bk .c2 { width: 26.7%; } .bk .c3 { width: 2.9%; } .bk .c4 { width: 37.1%; } .bk .c5 { width: 10.2%; } .bk .c6 { width: 2.9%; }
  .kes td { padding-top: 2px; padding-bottom: 2px; }
  .kes .c1 { width: 29.8%; } .kes .c2 { width: 2.9%; }

  .usulan { text-indent: 6.35mm; }
  .disposisi { border: 1px solid #000; height: 9.2em; margin-left: 5.4%; width: 92.9%; }

  /* Blok tanda tangan (kota/tanggal s.d. nama & NIP) satu kesatuan - kalau
     tidak muat di sisa halaman, seluruh blok didorong utuh ke halaman baru. */
  .ttd { margin-top: 18px; page-break-inside: avoid; }
  .ttd td { padding: 1px 3px; }
  .ttd .spasi td { height: 64px; }

  .lampiran { margin-left: 49.8%; width: auto; }
  .lampiran td { padding: 0 3px; }
  .judul-lamp { text-align: center; font-weight: bold; margin: 30px 0 14px; }
  .barang td { border: 1px solid #000; padding: 6px 5px; }
  .barang .kepala td { height: 1.5cm; vertical-align: middle; text-align: center; }
  .barang .isi td { height: 4.12cm; }
</style>
</head>
<body>
@php
    $lpp = $lpf->lpp;
    $lp = optional($lpp)->lp;
    $lphp = optional($lp)->lphp;
    $sbp = optional($lphp)->sbp;
@endphp

<!-- ===================== HALAMAN 1 ===================== -->
<div>
  <div class="kop">
    <p>Kementerian Keuangan Republik Indonesia</p>
    <p>Direktorat Jenderal Bea dan Cukai</p>
    <p>Kantor Wilayah Direktorat Jenderal Bea dan Cukai Aceh</p>
    <p class="u">Kantor Pengawasan dan Pelayanan Bea dan Cukai Tipe Madya Pabean C Banda Aceh</p>
  </div>

  <div class="judul">
    <p class="b u">LEMBAR PENELITIAN FORMAL (LPF)</p>
    <p>Nomor : {{ $lpf->nomor_lpf ?? '-' }}</p>
  </div>

  <table class="bag"><tr><td class="hrf">A.</td><td>Uraian Pelanggaran</td></tr></table>
  <table class="a w95">
    <tr><td class="c1">1.</td><td class="c2">Jenis Pelanggaran</td><td class="c3">:</td><td class="just">Diduga melanggar {{ optional($lphp)->pasal ?? '-' }} {{ optional($lphp)->uu_terkait ?? '' }}</td></tr>
    <tr><td class="c1">2.</td><td class="c2">Tempat</td><td class="c3">:</td><td class="just">{{ optional($sbp)->lokasi_penindakan ?? '-' }}, Kec. {{ optional($sbp)->kecamatan_penindakan ?? '-' }}, {{ optional($sbp)->kota_penindakan ?? '-' }}</td></tr>
    <tr><td class="c1">3.</td><td class="c2">Waktu</td><td class="c3">:</td><td>{{ optional(optional($sbp)->tanggal_sbp)->translatedFormat('d F Y') ?? '-' }} pukul {{ optional($sbp)->waktu_penindakan ?? '-' }} WIB</td></tr>
    <tr><td class="c1">4.</td><td class="c2">Pelaku</td><td class="c3"></td><td></td></tr>
    @if(optional($lphp)->pelaku_tidak_ditemukan)
    <tr><td class="c1"></td><td class="c2 sub">a.&nbsp;&nbsp;Nama</td><td class="c3">:</td><td>Pelaku tidak ditemukan</td></tr>
    <tr><td class="c1"></td><td class="c2 sub2">Umur</td><td class="c3">:</td><td>-</td></tr>
    <tr><td class="c1"></td><td class="c2 sub2">Jenis Kelamin</td><td class="c3">:</td><td>-</td></tr>
    <tr><td class="c1"></td><td class="c2 sub2">Alamat</td><td class="c3">:</td><td>-</td></tr>
    <tr><td class="c1"></td><td class="c2 sub2">Keterangan</td><td class="c3">:</td><td>-</td></tr>
    @else
    <tr><td class="c1"></td><td class="c2 sub">a.&nbsp;&nbsp;Nama</td><td class="c3">:</td><td>{{ optional($sbp)->nama_pelaku ?? '-' }}</td></tr>
    <tr><td class="c1"></td><td class="c2 sub2">Umur</td><td class="c3">:</td><td>-</td></tr>
    <tr><td class="c1"></td><td class="c2 sub2">Jenis Kelamin</td><td class="c3">:</td><td>{{ optional($sbp)->jenis_kelamin ?? '-' }}</td></tr>
    <tr><td class="c1"></td><td class="c2 sub2">Alamat</td><td class="c3">:</td><td>{{ optional($sbp)->alamat_di_indonesia ?? '-' }}</td></tr>
    <tr><td class="c1"></td><td class="c2 sub2">Keterangan</td><td class="c3">:</td><td>-</td></tr>
    @endif
    <tr><td class="c1">5.</td><td class="c2">Status Penangkapan</td><td class="c3">:</td><td>{{ $lpf->status_penangkapan ?? '-' }}</td></tr>
  </table>

  <table class="bag"><tr><td class="hrf">B.</td><td>Kelengkapan Dokumen Penindakan</td></tr></table>
  <table class="bk ind">
    <tr><td class="c1">1.</td><td class="c2">No. Surat Perintah/Tugas</td><td class="c3">:</td><td class="c4">{{ optional($sbp)->nomor_surat_perintah ?? '-' }}</td><td class="c5">Tanggal</td><td class="c6">:</td><td>{{ optional(optional($sbp)->tanggal_surat_perintah)->translatedFormat('d F Y') ?? '-' }}</td></tr>
    <tr><td class="c1">2.</td><td class="c2">No. Surat Limpahan</td><td class="c3">:</td><td class="c4">{{ $lpf->nomor_surat_limpahan ?? '-' }}</td><td class="c5">Tanggal</td><td class="c6">:</td><td>{{ optional($lpf->tanggal_surat_limpahan)->translatedFormat('d F Y') ?? '-' }}</td></tr>
    <tr><td class="c1">3.</td><td class="c2">No. LP</td><td class="c3">:</td><td class="c4">{{ optional($lp)->nomor_lp ?? '-' }}</td><td class="c5">Tanggal</td><td class="c6">:</td><td>{{ optional(optional($lp)->tanggal_lp)->translatedFormat('d F Y') ?? '-' }}</td></tr>
    <tr><td class="c1">4.</td><td class="c2">BAW Saksi</td><td class="c3">:</td><td class="c4">{{ $lpf->nomor_baw_saksi ?? '-' }}</td><td class="c5">Tanggal</td><td class="c6">:</td><td>{{ optional($lpf->tanggal_baw_saksi)->translatedFormat('d F Y') ?? '-' }}</td></tr>
    <tr><td class="c1">5.</td><td class="c2">BAP Tersangka</td><td class="c3">:</td><td class="c4">{{ $lpf->nomor_bap_tersangka ?? '-' }}</td><td class="c5">Tanggal</td><td class="c6">:</td><td>{{ optional($lpf->tanggal_bap_tersangka)->translatedFormat('d F Y') ?? '-' }}</td></tr>
    <tr><td class="c1">6.</td><td class="c2">Resume Perkara</td><td class="c3">:</td><td class="c4">{{ $lpf->nomor_resume_perkara ?? '-' }}</td><td class="c5">Tanggal</td><td class="c6">:</td><td>{{ optional($lpf->tanggal_resume_perkara)->translatedFormat('d F Y') ?? '-' }}</td></tr>
    <tr><td class="c1">7.</td><td class="c2">Dokumen Lain</td><td class="c3">:</td><td class="c4">{{ $lpf->nomor_dokumen_lain ?? '-' }}</td><td class="c5">Tanggal</td><td class="c6">:</td><td>{{ optional($lpf->tanggal_dokumen_lain)->translatedFormat('d F Y') ?? '-' }}</td></tr>
  </table>

  <table class="bag"><tr><td class="hrf">C.</td><td>Barang Hasil Penindakan</td></tr></table>
  <table class="a ind">
    <tr><td class="c1">1.</td><td class="c2">Komoditi</td><td class="c3">:</td><td class="just">{{ optional($sbp)->jenis_barang ?? '-' }}</td></tr>
    <tr><td class="c1"></td><td class="c2">Uraian Barang</td><td class="c3">:</td><td class="just">{{ $lpf->barang_hasil_penindakan ?? optional($sbp)->uraian_barang ?? '-' }}</td></tr>
    <tr><td class="c1"></td><td class="c2">Merek</td><td class="c3">:</td><td>-</td></tr>
    <tr><td class="c1"></td><td class="c2">Kondisi</td><td class="c3">:</td><td>-</td></tr>
    <tr><td class="c1"></td><td class="c2">Tipe</td><td class="c3">:</td><td>-</td></tr>
    <tr><td class="c1"></td><td class="c2">Spesifikasi Lain</td><td class="c3">:</td><td>-</td></tr>
    <tr><td class="c1"></td><td class="c2">Jumlah Koli</td><td class="c3">:</td><td>-</td></tr>
    <tr><td class="c1"></td><td class="c2">Jenis Koli</td><td class="c3">:</td><td>-</td></tr>
    <tr><td class="c1">2.</td><td class="c2">Dokumen Pab/Cukai Asal</td><td class="c3">:</td><td class="just">-</td></tr>
    <tr><td class="c1"></td><td class="c2">Kantor Pendaftaran</td><td class="c3">:</td><td class="just">-</td></tr>
    <tr><td class="c1"></td><td class="c2">Nomor</td><td class="c3">:</td><td class="just">-</td></tr>
    <tr><td class="c1"></td><td class="c2">Tanggal</td><td class="c3">:</td><td class="just">-</td></tr>
    <tr><td class="c1">3.</td><td class="c2">Pengangkut</td><td class="c3">:</td><td class="just">-</td></tr>
    <tr><td class="c1"></td><td class="c2">No. Voyage / No. Polisi</td><td class="c3">:</td><td class="just">-</td></tr>
    <tr><td class="c1"></td><td class="c2">Kontainer No.</td><td class="c3">:</td><td class="just">-</td></tr>
    <tr><td class="c1"></td><td class="c2">Ukuran</td><td class="c3">:</td><td class="just">-</td></tr>
  </table>

  <table class="bag"><tr><td class="hrf">D.</td><td>Kesimpulan</td></tr></table>
  <table class="kes w95">
    <tr><td class="c1">Status penangkapan</td><td class="c2">:</td><td class="just">{{ $lpf->status_penangkapan ?? '-' }}</td></tr>
    <tr><td class="c1">Domain perkara</td><td class="c2">:</td><td class="just">{{ $lpf->domain_perkara ?? '-' }}</td></tr>
    <tr><td class="c1">Lengkap tidaknya berkas<br>Penindakan</td><td class="c2">:</td><td class="just">{{ $lpf->lengkap_berkas ?? '-' }}</td></tr>
    <tr><td class="c1">Cukup tidaknya barang bukti</td><td class="c2">:</td><td class="just">{{ $lpf->cukup_barang_bukti ?? '-' }}</td></tr>
    <tr><td class="c1">Cukup tidaknya alat bukti</td><td class="c2">:</td><td class="just">{{ $lpf->cukup_alat_bukti ?? '-' }}</td></tr>
    <tr><td class="c1">Keberadaan pelaku</td><td class="c2">:</td><td class="just">{{ $lpf->keberadaan_pelaku ?? '-' }}</td></tr>
    <tr><td class="c1">Keterkaitan alat bukti, barang bukti dan pelaku</td><td class="c2">:</td><td class="just">{{ $lpf->keterkaitan_bukti_pelaku ?? '-' }}</td></tr>
    <tr><td class="c1">Ada tidaknya indikasi pelanggaran</td><td class="c2">:</td><td class="just">{{ $lpf->indikasi_pelanggaran ?? '-' }}</td></tr>
  </table>

  <table class="bag" style="margin-top:16px"><tr><td class="hrf">E.</td><td>Usulan</td></tr></table>
  <p class="usulan just">{{ $lpf->usulan ?? '-' }}</p>

  <table class="bag" style="margin-top:16px"><tr><td class="hrf">F.</td><td>Catatan/Disposisi Atasan</td></tr></table>
  <div class="disposisi" style="text-align: left; white-space: pre-line;">{{ $lpf->catatan_disposisi ?: '' }}</div>

  <table class="ttd ind" style="margin-left:3.9%; width:95.2%">
    <tr><td style="width:31.3%"></td><td style="width:32.8%"></td><td>Banda Aceh, {{ optional($lpf->tanggal_lpf)->translatedFormat('d F Y') ?? '-' }}</td></tr>
    <tr><td></td><td></td><td>Yang membuat LPF,</td></tr>
    <tr><td>Konseptor LPF</td><td></td><td>Pemeriksa Bea Cukai Ahli Pertama</td></tr>
    <tr class="spasi"><td></td><td></td><td></td></tr>
    <tr><td>{{ optional($lpf->konseptor)->nama ?? '-' }}</td><td></td><td>{{ optional($lpf->pemeriksa)->nama ?? '-' }}</td></tr>
    <tr><td>NIP {{ optional($lpf->konseptor)->nip_formatted ?? '-' }}</td><td></td><td>NIP {{ optional($lpf->pemeriksa)->nip_formatted ?? '-' }}</td></tr>
    <tr><td></td><td>Mengetahui,</td><td></td></tr>
    <tr><td></td><td>Kepala Seksi Penindakan dan Penyidikan</td><td></td></tr>
    <tr class="spasi"><td></td><td></td><td></td></tr>
    <tr><td></td><td>{{ optional($lpf->pengampu)->nama ?? '-' }}</td><td></td></tr>
    <tr><td></td><td>NIP {{ optional($lpf->pengampu)->nip_formatted ?? '-' }}</td><td></td></tr>
  </table>
</div>

<!-- ===================== HALAMAN 2 (LAMPIRAN) ===================== -->
<div style="page-break-before: always;">
  <table class="lampiran">
    <tr><td colspan="3" class="b">LAMPIRAN</td></tr>
    <tr><td>Nomor</td><td>:</td><td>{{ $lpf->nomor_lpf ?? '-' }}</td></tr>
    <tr><td>Tanggal</td><td>:</td><td>{{ optional($lpf->tanggal_lpf)->translatedFormat('d F Y') ?? '-' }}</td></tr>
  </table>

  <p class="judul-lamp">BARANG HASIL PENINDAKAN</p>

  <table class="barang">
    <tr class="kepala"><td style="width:73.5%">Uraian Barang</td><td class="b">Keterangan</td></tr>
    <tr class="isi"><td class="just">{{ $lpf->barang_hasil_penindakan ?? optional($sbp)->uraian_barang ?? '-' }}</td><td>{{ $lpf->cukup_barang_bukti === 'Cukup' ? 'Sesuai' : ($lpf->cukup_barang_bukti ? 'Tidak Sesuai' : '-') }}</td></tr>
  </table>

  <table class="ttd" style="margin-top:36px">
    <tr><td style="width:33.8%"></td><td style="width:29.6%"></td><td>Banda Aceh, {{ optional($lpf->tanggal_lpf)->translatedFormat('d F Y') ?? '-' }}</td></tr>
    <tr><td></td><td></td><td>Yang membuat LPF,</td></tr>
    <tr><td>Konseptor LPF</td><td></td><td>Pemeriksa Bea Cukai Ahli Pertama</td></tr>
    <tr class="spasi"><td></td><td></td><td></td></tr>
    <tr><td>{{ optional($lpf->konseptor)->nama ?? '-' }}</td><td></td><td>{{ optional($lpf->pemeriksa)->nama ?? '-' }}</td></tr>
    <tr><td>NIP {{ optional($lpf->konseptor)->nip_formatted ?? '-' }}</td><td></td><td>NIP {{ optional($lpf->pemeriksa)->nip_formatted ?? '-' }}</td></tr>
    <tr><td></td><td>Mengetahui,</td><td></td></tr>
    <tr><td></td><td>Kepala Seksi Penindakan dan Penyidikan</td><td></td></tr>
    <tr class="spasi"><td></td><td></td><td></td></tr>
    <tr><td></td><td>{{ optional($lpf->pengampu)->nama ?? '-' }}</td><td></td></tr>
    <tr><td></td><td>NIP {{ optional($lpf->pengampu)->nip_formatted ?? '-' }}</td><td></td></tr>
  </table>
</div>

</body>
</html>
