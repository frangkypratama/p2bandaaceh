@extends('layouts.app')

@section('title', 'Pratinjau Dokumen ' . $sbp->nomor_sbp)

@section('content')
<div class="container-lg">

    {{-- KONTROL (TIDAK DICETAK) --}}
    <div class="card mb-4">
        <div class="card-header">
            <strong>Kontrol Pratinjau</strong>
        </div>
        <div class="card-body">
            <p>Gunakan tombol di bawah untuk kembali atau mencetak dokumen.</p>

            <a href="{{ route('sbp.index') }}" class="btn btn-secondary">
                <i class="cil-arrow-circle-left"></i> Kembali
            </a>

            <div class="btn-group ms-2">
                <button type="button" class="btn btn-success dropdown-toggle" data-coreui-toggle="dropdown" aria-expanded="false">
                    <i class="cil-print"></i> Cetak
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item fw-bold" href="{{ route('sbp.pdf.semua', $sbp->id) }}" target="_blank">Cetak Semua Dokumen</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="{{ route('sbp.pdf', $sbp->id) }}" target="_blank">Cetak SBP</a></li>
                    <li><a class="dropdown-item" href="{{ route('sbp.pdf.ba-riksa', $sbp->id) }}" target="_blank">Cetak BA Pemeriksaan</a></li>
                    <li><a class="dropdown-item" href="{{ route('sbp.pdf.ba-tegah', $sbp->id) }}" target="_blank">Cetak BA Penegahan</a></li>
                    <li><a class="dropdown-item" href="{{ route('sbp.pdf.ba-segel', $sbp->id) }}" target="_blank">Cetak BA Penyegelan</a></li>
                    @if ($sbp->bast)
                    <li><a class="dropdown-item" href="{{ route('sbp.pdf.bast', $sbp->id) }}" target="_blank">Cetak BA Serah Terima</a></li>
                    @endif
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="{{ route('sbp.pdf.checklist', $sbp->id) }}" target="_blank">Checklist Kelengkapan</a></li>
                </ul>
            </div>
        </div>
    </div>

    {{-- PREVIEW PDF SBP --}}
    <div class="card mb-4">
        <div class="card-body p-0">
            <iframe 
                src="{{ route('sbp.pdf.semua', $sbp->id) }}" 
                width="100%" 
                height="900px"
                style="border:none;">
            </iframe>
        </div>
    </div>
</div>
@endsection
