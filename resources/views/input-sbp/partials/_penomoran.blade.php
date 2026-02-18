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
                            <select id="nomor_surat_perintah" class="form-select" name="nomor_surat_perintah" required>
                                <option value="" disabled selected>Pilih Nomor Surat Perintah</option>
                                @foreach($suratPerintahData as $sp)
                                    <option value="{{ $sp->nomor_prin }}" data-tanggal="{{ $sp->tanggal_prin }}">{{ $sp->nomor_prin }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="tanggal_surat_perintah" class="form-label">Tanggal Surat Perintah</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="cil-calendar"></i></span>
                            <input id="tanggal_surat_perintah" type="date" class="form-control" name="tanggal_surat_perintah" value="{{ old('tanggal_surat_perintah') }}" required readonly>
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
        const nomorSuratPerintah = document.getElementById('nomor_surat_perintah');
        const tanggalSuratPerintah = document.getElementById('tanggal_surat_perintah');

        nomorSuratPerintah.addEventListener('change', function () {
            const selectedOption = this.options[this.selectedIndex];
            const tanggal = selectedOption.getAttribute('data-tanggal');
            tanggalSuratPerintah.value = tanggal;
        });
    });
</script>
@endpush
