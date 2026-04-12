<div class="col-md-12">
    <div class="card h-100 border-light shadow-sm">
        <div class="card-header bg-light">
            <h5 class="card-title mb-0 d-flex align-items-center"><i class="cil-notes me-2"></i>Penomoran & Referensi</h5>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="nomor_sbp" class="form-label">Nomor SBP</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="cil-barcode"></i></span>
                        <input id="nomor_sbp" type="number" class="form-control @error('nomor_sbp_final') is-invalid @enderror" name="nomor_sbp" 
                               value="{{ old('nomor_sbp', $sbp->nomor_sbp_int ?? '') }}" placeholder="Masukkan hanya angka" required>
                        <button class="btn btn-outline-secondary" type="button" id="fetch-last-sbp" title="Ambil Nomor Terakhir">
                            <i class="cil-loop-circular"></i>
                        </button>
                        @error('nomor_sbp_final')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="tanggal_sbp" class="form-label">Tanggal SBP</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="cil-calendar"></i></span>
                        <input id="tanggal_sbp" type="date" class="form-control" name="tanggal_sbp" 
                               value="{{ old('tanggal_sbp', (isset($sbp) && $sbp->tanggal_sbp) ? $sbp->tanggal_sbp->format('Y-m-d') : '') }}" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="nomor_surat_perintah" class="form-label">Nomor Surat Perintah</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="cil-file"></i></span>
                        <input class="form-control" list="datalistOptions" id="nomor_surat_perintah" name="nomor_surat_perintah" placeholder="Ketik untuk mencari..."
                               value="{{ old('nomor_surat_perintah', $sbp->nomor_surat_perintah ?? 'PRIN-') }}" required>
                        <datalist id="datalistOptions">
                            @foreach($suratPerintahData as $sp)
                                <option value="{{ $sp->nomor_prin }}">
                            @endforeach
                        </datalist>
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="tanggal_surat_perintah" class="form-label">Tanggal Surat Perintah</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="cil-calendar"></i></span>
                        <input id="tanggal_surat_perintah" type="date" class="form-control" name="tanggal_surat_perintah" 
                               value="{{ old('tanggal_surat_perintah', (isset($sbp) && $sbp->tanggal_surat_perintah) ? $sbp->tanggal_surat_perintah->format('Y-m-d') : '') }}" required>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@once
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // --- Script untuk autofill tanggal surat perintah ---
            const suratPerintahData = @json($suratPerintahData);
            const nomorSuratInput = document.getElementById('nomor_surat_perintah');
            const tanggalSuratInput = document.getElementById('tanggal_surat_perintah');
            const prefix = 'PRIN-';

            function autofillTanggal() {
                const nomorDipilih = nomorSuratInput.value;
                const dataCocok = suratPerintahData.find(surat => surat.nomor_prin === nomorDipilih);
                if (dataCocok) {
                    tanggalSuratInput.value = dataCocok.tanggal_prin;
                }
            }

            function enforcePrefix() {
                if (!nomorSuratInput.value.startsWith(prefix)) {
                    nomorSuratInput.value = prefix;
                }
            }

            nomorSuratInput.addEventListener('keydown', function(e) {
                const { value, selectionStart } = e.target;
                if ((e.key === 'Backspace' && selectionStart <= prefix.length) || 
                    (e.key === 'Delete' && selectionStart < prefix.length)) {
                    e.preventDefault();
                }
            });

            nomorSuratInput.addEventListener('input', function() {
                enforcePrefix();
                autofillTanggal();
            });

            nomorSuratInput.addEventListener('focus', function() {
                if (nomorSuratInput.value === '') {
                    nomorSuratInput.value = prefix;
                }
            });
            
            if (nomorSuratInput.value && !tanggalSuratInput.value) {
                autofillTanggal();
            }

            // --- Script untuk mengambil nomor SBP terakhir ---
            const fetchButton = document.getElementById('fetch-last-sbp');
            const nomorSbpInput = document.getElementById('nomor_sbp');

            if (fetchButton) {
                fetchButton.addEventListener('click', function() {
                    const originalHtml = this.innerHTML;
                    this.disabled = true;
                    this.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';

                    fetch("{{ route('sbp.get-last-number') }}")
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Gagal mengambil data. Status: ' + response.status);
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (data.next_number) {
                                nomorSbpInput.value = data.next_number;
                            } else {
                                alert('Tidak dapat menemukan nomor SBP berikutnya.');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Terjadi kesalahan: ' + error.message);
                        })
                        .finally(() => {
                            this.disabled = false;
                            this.innerHTML = originalHtml;
                        });
                });
            }
        });
    </script>
    @endpush
@endonce
