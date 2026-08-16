@extends('layouts.app')

@section('content')
<div class="container-lg">
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h5 class="card-title mb-0"><i class="cil-description me-2"></i>Detail Pencacahan</h5>
            <div class="d-flex gap-2">
                <button type="button" class="btn btn-light btn-sm preview-btn"
                        data-pdf-url="{{ route('pencacahan.cetak', $pencacahan->id) }}"
                        data-pdf-title="Berita Acara Pencacahan {{ $pencacahan->no_ba_cacah }}">
                    <i class="cil-print me-1"></i>Cetak
                </button>
                <a href="{{ route('pencacahan.edit', $pencacahan->id) }}" class="btn btn-warning btn-sm">
                    <i class="cil-pencil me-1"></i>Edit
                </a>
                <a href="{{ route('pencacahan.index') }}" class="btn btn-secondary btn-sm">
                    <i class="cil-arrow-left me-1"></i>Kembali
                </a>
            </div>
        </div>
        <div class="card-body">
            {{-- Card Penomoran --}}
            <div class="card mb-3">
                <div class="card-header">
                    <h6 class="card-title mb-0"><i class="cil-notes me-2"></i>Penomoran</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="text-muted small">Nomor BA Cacah</div>
                            <div class="fw-semibold">{{ $pencacahan->no_ba_cacah ?? '-' }}</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="text-muted small">Tanggal BA Cacah</div>
                            <div class="fw-semibold">{{ optional($pencacahan->tanggal_ba_cacah)->translatedFormat('d F Y') ?? '-' }}</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="text-muted small">Nomor Surat Tugas Pencacahan</div>
                            <div class="fw-semibold">{{ $pencacahan->no_surat_tugas_pencacahan ?? '-' }}</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="text-muted small">Tanggal Surat Tugas Pencacahan</div>
                            <div class="fw-semibold">{{ optional($pencacahan->tanggal_surat_tugas_pencacahan)->translatedFormat('d F Y') ?? '-' }}</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Card Detail & Petugas --}}
            <div class="card mb-3">
                <div class="card-header">
                    <h6 class="card-title mb-0"><i class="cil-settings me-2"></i>Detail & Petugas</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="text-muted small">Lokasi Cacah</div>
                            <div class="fw-semibold">{{ $pencacahan->lokasi_cacah ?? '-' }}</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="text-muted small">Giat</div>
                            <div class="fw-semibold">{{ $pencacahan->giat ?? '-' }}</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="text-muted small">Petugas 1</div>
                            <div class="fw-semibold">{{ optional($pencacahan->petugas1)->nama ?? '-' }}</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="text-muted small">Petugas 2</div>
                            <div class="fw-semibold">{{ optional($pencacahan->petugas2)->nama ?? '-' }}</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Card Dokumen SBP & Detail Barang --}}
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title mb-0"><i class="cil-link-alt me-2"></i>Dokumen SBP & Detail Barang</h6>
                </div>
                <div class="card-body">
                    @forelse($pencacahan->sbp as $sbp)
                        @php
                            $detailsForSbp = $pencacahan->details->where('pencacahan_sbp_id', $sbp->pivot->id);
                            $photosForSbp = $sbp->pivot->getMedia('foto');
                        @endphp
                        <div class="card {{ $loop->last ? 'mb-0' : 'mb-3' }}">
                            <div class="card-header bg-light d-flex justify-content-between align-items-center flex-wrap gap-2">
                                <div class="d-flex align-items-center gap-2">
                                    <span class="fw-semibold"><i class="cil-barcode me-2"></i>{{ $sbp->nomor_sbp ?? '-' }}</span>
                                    <span class="text-muted small">{{ optional($sbp->tanggal_sbp)->translatedFormat('d F Y') ?? '-' }}</span>
                                </div>
                                <span class="badge {{ $detailsForSbp->isNotEmpty() ? 'bg-success' : 'bg-secondary' }}">
                                    {{ $detailsForSbp->count() }} Barang
                                </span>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-8">
                                        @if($detailsForSbp->isNotEmpty())
                                            <div class="table-responsive">
                                                <table class="table table-sm table-bordered mb-0">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th class="text-center" style="width: 5%;">#</th>
                                                            <th>Jenis Barang</th>
                                                            <th>Kondisi</th>
                                                            <th>Negara Asal</th>
                                                            <th>Uraian / Merek</th>
                                                            <th>Jumlah</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($detailsForSbp as $i => $detail)
                                                        <tr>
                                                            <td class="text-center">{{ $i + 1 }}</td>
                                                            <td>{{ optional($detail->jenisBarang)->nama_barang ?? '-' }}</td>
                                                            <td>{{ $detail->kondisi_barang ?? '-' }}</td>
                                                            <td>{{ $detail->negara_asal ?? '-' }}</td>
                                                            <td>{{ $detail->uraian ?? $detail->merek ?? '-' }}</td>
                                                            <td>{{ $detail->jumlah_tampil }}</td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @else
                                            <p class="text-muted mb-0">Belum ada detail barang untuk SBP ini.</p>
                                        @endif
                                    </div>
                                    <div class="col-md-4">
                                        @if($photosForSbp->isNotEmpty())
                                            <div class="d-flex flex-wrap gap-2">
                                                @foreach($photosForSbp as $photo)
                                                    @php $photoUrl = route('pencacahan.showPhoto', $photo->id); @endphp
                                                    <a href="{{ $photoUrl }}" target="_blank" title="Lihat foto ukuran penuh">
                                                        <img src="{{ $photoUrl }}" alt="Foto bukti {{ $sbp->nomor_sbp }}" class="img-thumbnail" style="height: 200px; width: 200px; object-fit: cover;">
                                                    </a>
                                                @endforeach
                                            </div>
                                        @else
                                            <p class="text-muted mb-0">Belum ada foto untuk SBP ini.</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted mb-0">Belum ada SBP yang terhubung dengan pencacahan ini.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

@include('partials._pdf-viewer')
@endsection
