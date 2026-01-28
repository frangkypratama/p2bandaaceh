{{-- Penomoran --}}
<div class="col-md-12">
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="card-title mb-0">1. Penomoran & Referensi</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="nomor_sbp" class="form-label">Nomor SBP</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="cil-notes"></i></span>
                            <input id="nomor_sbp" type="number" class="form-control" name="nomor_sbp" value="{{ old('nomor_sbp') }}" placeholder="Masukkan hanya angka" required>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="tanggal_sbp" class="form-label">Tanggal SBP</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="cil-calendar"></i></span>
                            <input id="tanggal_sbp" type="date" class="form-control" name="tanggal_sbp" value="{{ old('tanggal_sbp') }}" required>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="nomor_surat_perintah" class="form-label">Nomor Surat Perintah</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="cil-file"></i></span>
                            <input id="nomor_surat_perintah" type="text" class="form-control" name="nomor_surat_perintah" value="{{ old('nomor_surat_perintah') }}" placeholder="Contoh: PRIN-1/KBC.0102/2025" required>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="tanggal_surat_perintah" class="form-label">Tanggal Surat Perintah</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="cil-calendar"></i></span>
                            <input id="tanggal_surat_perintah" type="date" class="form-control" name="tanggal_surat_perintah" value="{{ old('tanggal_surat_perintah') }}" required>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    // HANYA PRIN
    const input = document.getElementById('nomor_surat_perintah');
    if (!input) return;

    const PREFIX = 'PRIN-';

    function lockPrefix() {
        if (!input.value.startsWith(PREFIX)) {
            input.value = PREFIX;
        }

        if (input.selectionStart < PREFIX.length) {
            input.setSelectionRange(PREFIX.length, PREFIX.length);
        }
    }

    // set awal
    input.value = input.value && input.value.startsWith(PREFIX)
        ? input.value
        : PREFIX;

    // cegah hapus PRIN-
    input.addEventListener('keydown', function (e) {
        if (
            (e.key === 'Backspace' || e.key === 'Delete') &&
            input.selectionStart <= PREFIX.length
        ) {
            e.preventDefault();
        }
    });

    input.addEventListener('input', lockPrefix);
    input.addEventListener('focus', lockPrefix);
    input.addEventListener('click', lockPrefix);

});
</script>
@endpush
