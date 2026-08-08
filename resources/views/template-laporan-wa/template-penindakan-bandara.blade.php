@php
    $lokasiParts = array_filter([
        $sbp->lokasi_penindakan ?? null,
        $sbp->kecamatan_penindakan ?? null,
        $sbp->kota_penindakan ?? null,
    ]);
    $lokasiPenindakan = !empty($lokasiParts) ? implode(', ', $lokasiParts) : '-';

    $tanggalSbp = optional($sbp->tanggal_sbp)->translatedFormat('d F Y') ?? '-';
    $waktuPenindakan = trim(($sbp->waktu_penindakan ?? '-') . ' WIB, ' . $tanggalSbp);

    $isMusnah = !empty($sbp->nomor_ba_musnah);
    $isDiserahterimakan = !$isMusnah && $sbp->bast;
    $instansiTerkait = $sbp->bast->instansi_eksternal ?? 'instansi terkait';

    if ($isMusnah) {
        $disposisiBarang = 'telah dimusnahkan secara langsung di lokasi penindakan';
    } elseif ($isDiserahterimakan) {
        $disposisiBarang = 'diserahterimakan kepada ' . $instansiTerkait . ' untuk ditindaklanjuti';
    } else {
        $disposisiBarang = 'dibawa ke KPPBC TMP C Banda Aceh untuk ditindaklanjuti';
    }
@endphp
*Izin Komandan Laporan Giat Penindakan Bandara SIM*

Telah dilakukan penindakan, pemeriksaan, penegahan dan penyegelan terhadap barang bawaan penumpang detail sbb

Nama : {{ $sbp->nama_pelaku ?? '-' }}
{{ $sbp->jenis_identitas ?? 'Identitas' }} : {{ $sbp->nomor_identitas ?? '-' }}
Barang : {{ $sbp->uraian_barang ?? '-' }}
Lokasi Penindakan : {{ $lokasiPenindakan }}
Waktu Penindakan : {{ $waktuPenindakan }}
Uraian Pelanggaran : {{ $sbp->alasan_penindakan ?? '-' }}
Tindak lanjut: Diterbitkan SBP Nomor {{ $sbp->nomor_sbp ?? '-' }} tanggal {{ $tanggalSbp }}, barang selanjutnya {{ $disposisiBarang }}.

Demikian disampaikan, terima kasih.
