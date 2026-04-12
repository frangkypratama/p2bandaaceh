@extends('layouts.app')

@section('title', 'Input SBP')

@section('content')
<div class="container-lg">
    <form method="POST" action="{{ route('sbp.store') }}" id="sbpForm">
        @csrf
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h4 class="card-title mb-0 d-flex align-items-center">
                    <i class="cil-plus me-2"></i>
                    <span><strong>Input Surat Bukti Penindakan (SBP)</strong></span>
                </h4>
                <small class="text-medium-emphasis-white">Lengkapi semua informasi yang diperlukan di bawah ini.</small>
            </div>
            <div class="card-body p-4">
                <div class="row g-4">
                    {{-- Include Partials --}}
                    @include('input-sbp.partials._penomoran')
                    @include('input-sbp.partials._identitas_pelaku')
                    @include('input-sbp.partials._detail_penindakan')
                    @include('input-sbp.partials._barang_bukti')
                    @include('input-sbp.partials._petugas')
                </div>
            </div>
            <div class="card-footer text-end bg-light">
                <a href="{{ route('sbp.index') }}" class="btn btn-secondary">
                    <i class="cil-x-circle me-2"></i>Batal
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="cil-save me-2"></i>Simpan Data SBP
                </button>
            </div>
        </div>
    </form>
</div>

{{-- Include Modals outside the main card structure for better DOM management --}}
@include('input-sbp.partials._bast_modal')
@include('input-sbp.partials._pelanggaran_modal')
@include('input-sbp.partials._ba_musnah_modal')
@endsection

@push('styles')
<style>
/* Custom style for white text on primary background */
.text-medium-emphasis-white {
    color: rgba(255, 255, 255, 0.7) !important;
}
/* Ensure partial card headers are consistent */
.card .card-header h5 {
    font-size: 1.1rem;
    font-weight: 600;
}
</style>
@endpush
