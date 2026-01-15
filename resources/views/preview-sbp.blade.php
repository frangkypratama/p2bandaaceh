@extends('layouts.app')

@section('title', 'Pratinjau Cetak SBP - ' . $sbp->nomor_sbp)

@push('styles')
<style>
    /* Aturan khusus untuk proses cetak (Ctrl+P) */
    @media print {
        /* Sembunyikan semua elemen dari layout utama secara default */
        body * {
            visibility: hidden;
        }

        /* Tampilkan HANYA area yang bisa dicetak dan semua isinya */
        .printable-area, .printable-area * {
            visibility: visible;
        }

        /* Atur posisi area cetak agar mengisi seluruh halaman kertas */
        .printable-area {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            margin: 0;
            padding: 0;
        }

        /* Spesifikasi ukuran kertas F4 dan margin dari template asli */
        @page {
            size: 210mm 330mm;
            margin: 30mm 25mm;
        }

        /* Pastikan elemen .no-print dan elemen UI lainnya benar-benar tidak muncul */
        .no-print, .no-print *,
        .sidebar, .header, .footer,
        .c-sidebar, .c-header, .c-footer,
        .card, .card-body /* Sembunyikan card wrapper saat cetak */
        {
            display: none !important;
            visibility: hidden;
        }

        /* Override khusus untuk printable-area di dalam card-body yang di-hidden */
        .card .card-body .printable-area {
            display: block !important;
        }
    }
</style>
@endpush

@section('content')
<div class="container-lg">
    {{-- BAGIAN KONTROL CETAK (TIDAK IKUT DICETAK) --}}
    <div class="card mb-4 no-print">
        <div class="card-header">
            <h5 class="mb-0">Kontrol Pratinjau</h5>
        </div>
        <div class="card-body">
            <p class="mb-3">Halaman ini adalah pratinjau dokumen. Hanya area di bawah ini yang akan dicetak atau diunduh. Gunakan tombol di bawah untuk tindakan lebih lanjut.</p>
            <a href="{{ route('sbp.pdf', $sbp->id) }}" target="_blank" class="btn btn-primary">
                <i class="cil-cloud-download"></i> Unduh PDF
            </a>
            <a href="{{ route('sbp.index') }}" class="btn btn-secondary">
                <i class="cil-action-undo"></i> Kembali ke Daftar
            </a>
        </div>
    </div>

    {{-- CARD WRAPPER UNTUK TAMPILAN RAPI DI LAYAR --}}
    <div class="card">
        <div class="card-body">
            {{-- AREA YANG SEBENARNYA AKAN DICETAK --}}
            <div class="printable-area">
                @include('templatecetak.templatesbp', ['sbp' => $sbp])
            </div>
        </div>
    </div>
</div>
@endsection
