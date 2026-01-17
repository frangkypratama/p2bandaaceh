@extends('layouts.app')

@section('title', 'Pratinjau ' . $sbp->nomor_sbp)

@section('content')
<div class="container-lg">

    {{-- KONTROL (TIDAK DICETAK) --}}
    <div class="card mb-4">
        <div class="card-header">
            <strong>Pratinjau Dokumen SBP</strong>
        </div>
        <div class="card-body">
            <p>Gunakan tombol di bawah untuk mencetak dokumen.</p>

            <a href="{{ route('sbp.index') }}" class="btn btn-secondary">
                <i class="cil-arrow-circle-left"></i> Kembali
            </a>

            <a href="{{ route('sbp.pdf', $sbp->id) }}" target="_blank" class="btn btn-success ms-2">
                <i class="cil-print"></i> Cetak Dokumen
            </a>
        </div>
    </div>

    {{-- PREVIEW PDF --}}
    <div class="card">
        <div class="card-body p-0">
            <iframe 
                src="{{ route('sbp.pdf', $sbp->id) }}" 
                width="100%" 
                height="900px"
                style="border:none;">
            </iframe>
        </div>
    </div>

</div>
@endsection
