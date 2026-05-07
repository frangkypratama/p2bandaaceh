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

                    {{-- Include Modals outside the main card structure for better DOM management --}}
                    @include('input-sbp.partials._bast_modal')
                    @include('input-sbp.partials._pelanggaran_modal')
                    @include('input-sbp.partials._ba_musnah_modal')
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

@push('scripts')
<script>
    $(document).ready(function() {
        // Initialize Select2 on the kecamatan dropdown
        $('#kecamatan').select2({
            theme: "bootstrap-5",
            placeholder: 'Pilih Kecamatan'
        });

        $('#kota').on('change', function() {
            var kota = this.value;
            var $kecamatanSelect = $('#kecamatan');
            $kecamatanSelect.prop('disabled', true).html('<option selected disabled>Pilih Kecamatan</option>');

            if (kota) {
                fetch('{{ route("lokasi.kecamatan") }}?kota=' + kota)
                    .then(response => response.json())
                    .then(data => {
                        $kecamatanSelect.prop('disabled', false);
                        data.forEach(function(kecamatan) {
                            var option = new Option(kecamatan, kecamatan, false, false);
                            $kecamatanSelect.append(option);
                        });
                        // Refresh Select2 to show the new options
                        $kecamatanSelect.trigger('change');
                    });
            }
        });
    });
</script>
@endpush
