<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Surat Perintah Penelitian (SPLIT) Nomor {{ $split->nomor_split ?? '-' }}</title>
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
  .center { text-align: center; }
  .judul { margin: 16px 0 14px; text-align: center; }
  table { border-collapse: collapse; width: 100%; }
  td { vertical-align: top; padding: 0 3px; }
  .just { text-align: justify; }

  .dasar .lbl { width: 19.6%; font-weight: bold; padding-left: 6px; }
  .dasar ol { margin: 0; padding-left: 22px; text-align: justify; }

  .perintah { margin: 16px 0 16px; text-align: center; font-weight: bold; padding-right: 8%; }

  .kepada { margin-left: 3mm; width: calc(100% - 3mm); }
  .kepada .k1 { width: 12.9%; font-weight: bold; }
  .kepada .k2 { width: 15%; }
  .kepada .k3 { width: 2.9%; }
  .kosong td { height: 1.3em; }

  .untuk { margin-top: 18px; margin-left: 3mm; width: calc(100% - 3mm); }
  .untuk .k1 { width: 12.9%; font-weight: bold; white-space: pre; }
  .untuk .k2 { width: 5.1%; }
  .untuk .k3 { width: 24.5%; }
  .untuk .k4 { width: 2.9%; }

  .demikian { margin-top: 18px; text-indent: 14.8mm; text-align: justify; }
  /* Blok tanda tangan (kota/tanggal s.d. nama & NIP) satu kesatuan - kalau
     tidak muat di sisa halaman, seluruh blok didorong utuh ke halaman baru. */
  .ttd { margin-top: 18px; margin-left: 55.8%; text-align: justify; page-break-inside: avoid; }
  .ttd .spasi { height: 70px; }
</style>
</head>
<body>
@php
    $lpp = $split->lpp;
    $lp = optional($lpp)->lp;
    $lphp = optional($lp)->lphp;
    $sbp = optional($lphp)->sbp;

    $dasarLines = collect(explode("\n", (string) $split->dasar))->map(fn ($l) => trim($l))->filter();
    $pertimbanganLines = collect(explode("\n", (string) $split->pertimbangan))->map(fn ($l) => trim($l))->filter();
    $tugasLines = collect(explode("\n", (string) $split->uraian_tugas))->map(fn ($l) => trim($l))->filter();
@endphp

<div>

  <div class="kop">
    <p>Kementerian Keuangan Republik Indonesia</p>
    <p>Direktorat Jenderal Bea dan Cukai</p>
    <p>Kantor Wilayah Direktorat Jenderal Bea dan Cukai Aceh</p>
    <p class="u">Kantor Pengawasan dan Pelayanan Bea dan Cukai Tipe Madya Pabean C Banda Aceh</p>
  </div>

  <div class="judul">
    <p class="b u">SURAT PERINTAH PENELITIAN (SPLIT)</p>
    <p>Nomor : {{ $split->nomor_split ?? '-' }}</p>
  </div>

  <table class="dasar">
    <tr>
      <td class="lbl">D a s a r :</td>
      <td>
        <ol>
          @forelse($dasarLines as $line)
            <li>{{ $line }}</li>
          @empty
            <li>-</li>
          @endforelse
        </ol>
      </td>
    </tr>
    <tr>
      <td class="lbl">Pertimbangan :</td>
      <td>
        <ol>
          @forelse($pertimbanganLines as $line)
            <li>{{ $line }}</li>
          @empty
            <li>-</li>
          @endforelse
        </ol>
      </td>
    </tr>
  </table>

  <p class="perintah">D I P E R I N T A H K A N</p>

  <table class="kepada just">
    <tr><td class="k1">Kepada&nbsp;&nbsp;:</td><td class="k2">Nama</td><td class="k3">:</td><td>{{ optional($split->petugas1)->nama ?? '-' }}</td></tr>
    <tr><td class="k1"></td><td class="k2">NIP</td><td class="k3">:</td><td>{{ optional($split->petugas1)->nip_formatted ?? '-' }}</td></tr>
    <tr><td class="k1"></td><td class="k2">Pangkat/Gol/</td><td class="k3">:</td><td>{{ optional($split->petugas1)->pangkat ?? '-' }} / {{ optional($split->petugas1)->golongan ?? '-' }}</td></tr>
    <tr><td class="k1"></td><td class="k2">Jabatan</td><td class="k3">:</td><td>{{ optional($split->petugas1)->jabatan ?? '-' }}</td></tr>
    <tr class="kosong"><td></td><td></td><td></td><td></td></tr>
    <tr><td class="k1"></td><td class="k2">Nama</td><td class="k3">:</td><td>{{ optional($split->petugas2)->nama ?? '-' }}</td></tr>
    <tr><td class="k1"></td><td class="k2">NIP</td><td class="k3">:</td><td>{{ optional($split->petugas2)->nip_formatted ?? '-' }}</td></tr>
    <tr><td class="k1"></td><td class="k2">Pangkat/Gol/</td><td class="k3">:</td><td>{{ optional($split->petugas2)->pangkat ?? '-' }} / {{ optional($split->petugas2)->golongan ?? '-' }}</td></tr>
    <tr><td class="k1"></td><td class="k2">Jabatan</td><td class="k3">:</td><td>{{ optional($split->petugas2)->jabatan ?? '-' }}</td></tr>
  </table>

  <table class="untuk just">
    <tr><td class="k1">Untuk&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</td><td class="k2">1.</td><td colspan="3">@if($tugasLines->count())
{{ $tugasLines->first() }}
@else
Melakukan tugas penelitian berupa mencari, mengumpulkan bahan keterangan, dan menemukan bukti permulaan yang cukup atas perkara yang diduga dilakukan oleh :
@endif</td></tr>
    <tr><td class="k1"></td><td class="k2"></td><td class="k3">Nama</td><td class="k4">:</td><td>{{ optional($sbp)->nama_pelaku ?? '-' }}</td></tr>
    <tr><td class="k1"></td><td class="k2"></td><td class="k3">Pekerjaan</td><td class="k4">:</td><td>-</td></tr>
    <tr><td class="k1"></td><td class="k2"></td><td class="k3">Tempat/tanggal lahir</td><td class="k4">:</td><td>-</td></tr>
    <tr><td class="k1"></td><td class="k2"></td><td class="k3">Alamat</td><td class="k4">:</td><td>{{ optional($sbp)->alamat_di_indonesia ?? '-' }}</td></tr>
    <tr class="kosong"><td></td><td></td><td></td><td></td><td></td></tr>
    <tr><td class="k1"></td><td class="k2">2.</td><td colspan="3">{{ $tugasLines->count() > 1 ? $tugasLines->skip(1)->implode(' ') : 'Setelah melaksanakan Surat Perintah ini agar melaporkan kepada yang memberi perintah.' }}</td></tr>
  </table>

  <p class="demikian">Demikian surat perintah ini dibuat untuk dilaksanakan dengan penuh tanggung jawab.</p>

  <div class="ttd">
    <p>Dikeluarkan di : Banda Aceh</p>
    <p class="u">Pada tanggal : {{ optional($split->tanggal_split)->translatedFormat('d F Y') ?? '-' }}</p>
    <p>Kepala Seksi Penindakan dan Penyidikan Kantor Pengawasan dan Pelayanan Bea dan Cukai Tipe Madya Pabean C Banda Aceh</p>
    <div class="spasi"></div>
    <p>{{ optional($split->penerbit)->nama ?? '-' }}</p>
    <p>NIP {{ optional($split->penerbit)->nip_formatted ?? '-' }}</p>
  </div>

</div>
</body>
</html>
