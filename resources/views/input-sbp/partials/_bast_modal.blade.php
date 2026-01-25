<!-- Modal BAST -->
<div class="modal fade" id="bastModal" tabindex="-1" aria-labelledby="bastModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="bastModalLabel">
                    <i class="cil-share-boxed me-2"></i> Input Berita Acara Serah Terima (BAST)
                </h5>
                <button type="button" class="btn-close btn-close-white" data-coreui-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{-- Hidden Fields for BAST data --}}
                <input type="hidden" name="nomor_bast" id="hidden_nomor_bast" value="{{ old('nomor_bast') }}">
                <input type="hidden" name="tanggal_bast" id="hidden_tanggal_bast" value="{{ old('tanggal_bast') }}">
                <input type="hidden" name="jenis_dokumen" id="hidden_jenis_dokumen" value="{{ old('jenis_dokumen') }}">
                <input type="hidden" name="tanggal_dokumen" id="hidden_tanggal_dokumen" value="{{ old('tanggal_dokumen') }}">
                <input type="hidden" name="petugas_eksternal" id="hidden_petugas_eksternal" value="{{ old('petugas_eksternal') }}">
                <input type="hidden" name="nip_nrp_petugas_eksternal" id="hidden_nip_nrp_petugas_eksternal" value="{{ old('nip_nrp_petugas_eksternal') }}">
                <input type="hidden" name="instansi_eksternal" id="hidden_instansi_eksternal" value="{{ old('instansi_eksternal') }}">
                <input type="hidden" name="dalam_rangka" id="hidden_dalam_rangka" value="{{ old('dalam_rangka') }}">

                 <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="modal_nomor_bast" class="form-label">Nomor BAST</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="cil-notes"></i></span>
                                <input type="text" class="form-control" id="modal_nomor_bast" placeholder="Contoh: BAST-1/KBC.010202/2025" value="{{ old('nomor_bast', isset($sbp) ? $sbp->bast?->nomor_bast : '') }}">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="modal_tanggal_bast" class="form-label">Tanggal BAST</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="cil-calendar"></i></span>
                                <input type="date" class="form-control" id="modal_tanggal_bast" value="{{ old('tanggal_bast', isset($sbp) && $sbp->bast?->tanggal_bast ? $sbp->bast->tanggal_bast->format('Y-m-d') : '') }}">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="modal_jenis_dokumen" class="form-label">Jenis Dokumen</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="cil-file"></i></span>
                                <input type="text" class="form-control" id="modal_jenis_dokumen" placeholder="Contoh: Surat Pemberitahuan" value="{{ old('jenis_dokumen', isset($sbp) ? $sbp->bast?->jenis_dokumen : '') }}">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="modal_tanggal_dokumen" class="form-label">Tanggal Dokumen</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="cil-calendar"></i></span>
                                <input type="date" class="form-control" id="modal_tanggal_dokumen" value="{{ old('tanggal_dokumen', isset($sbp) && $sbp->bast?->tanggal_dokumen ? $sbp->bast->tanggal_dokumen->format('Y-m-d') : '') }}">
                            </div>
                        </div>
                    </div>
                </div>

                <hr>
                <h6 class="mt-3"><i class="cil-building me-2"></i> Pihak Eksternal</h6>
                <small class="text-medium-emphasis">Informasi pihak yang menerima barang bukti.</small>


                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="modal_petugas_eksternal" class="form-label">Nama Petugas</label>
                             <div class="input-group">
                                <span class="input-group-text"><i class="cil-user"></i></span>
                                <input type="text" class="form-control" id="modal_petugas_eksternal" placeholder="Nama lengkap petugas" value="{{ old('petugas_eksternal', isset($sbp) ? $sbp->bast?->petugas_eksternal : '') }}">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="modal_nip_nrp_petugas_eksternal" class="form-label">NIP/NRP Petugas</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="cil-badge"></i></span>
                                <input type="text" class="form-control" id="modal_nip_nrp_petugas_eksternal" placeholder="Nomor Induk Pegawai/NRP" value="{{ old('nip_nrp_petugas_eksternal', isset($sbp) ? $sbp->bast?->nip_nrp_petugas_eksternal : '') }}">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="modal_instansi_eksternal" class="form-label">Instansi</label>
                    <div class="input-group">
                         <span class="input-group-text"><i class="cil-building"></i></span>
                        <input type="text" class="form-control" id="modal_instansi_eksternal" placeholder="Contoh: Badan Karantina Indonesia" value="{{ old('instansi_eksternal', isset($sbp) ? $sbp->bast?->instansi_eksternal : '') }}">
                    </div>
                </div>

                <hr>

                <div class="mb-3">
                    <label for="modal_dalam_rangka" class="form-label">Dalam Rangka</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="cil-description"></i></span>
                        <textarea class="form-control" id="modal_dalam_rangka" rows="3" placeholder="Jelaskan tujuan serah terima">{{ old('dalam_rangka', isset($sbp) ? $sbp->bast?->dalam_rangka : '') }}</textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                @if(isset($sbp))
                <button type="button" class="btn btn-danger me-auto" id="modalDeleteBastBtn">
                    <i class="cil-trash"></i> Hapus BAST
                </button>
                @endif
                <button type="button" class="btn btn-light" data-coreui-dismiss="modal">
                    <i class="cil-x"></i> Batal
                </button>
                <button type="button" class="btn btn-primary" id="saveBastButton">
                    <i class="cil-save"></i> Simpan Data BAST
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // BAST Modal Logic
        const flagBastCheckbox = document.getElementById('flag_bast');
        const saveBastButton = document.getElementById('saveBastButton');
        const bastModalElement = document.getElementById('bastModal');

        if (bastModalElement && flagBastCheckbox && saveBastButton) {
            const bastModal = new coreui.Modal(bastModalElement);

            // Helper function to check for BAST-related validation errors
            const errors = @json($errors->keys());
            const bastErrorKeys = [
                'nomor_bast', 'tanggal_bast', 'jenis_dokumen', 'tanggal_dokumen',
                'petugas_eksternal', 'nip_nrp_petugas_eksternal', 'instansi_eksternal', 'dalam_rangka'
            ];
            const hasBastErrors = bastErrorKeys.some(key => errors.includes(key));

            // Show modal if there were BAST validation errors on the previous attempt
            if (hasBastErrors) {
                bastModal.show();
            }

            function loadModalData() {
                document.getElementById('modal_nomor_bast').value = document.getElementById('hidden_nomor_bast').value;
                document.getElementById('modal_tanggal_bast').value = document.getElementById('hidden_tanggal_bast').value;
                document.getElementById('modal_jenis_dokumen').value = document.getElementById('hidden_jenis_dokumen').value;
                document.getElementById('modal_tanggal_dokumen').value = document.getElementById('hidden_tanggal_dokumen').value;
                document.getElementById('modal_petugas_eksternal').value = document.getElementById('hidden_petugas_eksternal').value;
                document.getElementById('modal_nip_nrp_petugas_eksternal').value = document.getElementById('hidden_nip_nrp_petugas_eksternal').value;
                document.getElementById('modal_instansi_eksternal').value = document.getElementById('hidden_instansi_eksternal').value;
                document.getElementById('modal_dalam_rangka').value = document.getElementById('hidden_dalam_rangka').value;
            }

            flagBastCheckbox.addEventListener('change', function () {
                if (this.checked) {
                    loadModalData(); // Load existing data if any (e.g., from old input)
                    bastModal.show();
                }
            });

            saveBastButton.addEventListener('click', function () {
                // Save data from modal to hidden fields
                document.getElementById('hidden_nomor_bast').value = document.getElementById('modal_nomor_bast').value;
                document.getElementById('hidden_tanggal_bast').value = document.getElementById('modal_tanggal_bast').value;
                document.getElementById('hidden_jenis_dokumen').value = document.getElementById('modal_jenis_dokumen').value;
                document.getElementById('hidden_tanggal_dokumen').value = document.getElementById('modal_tanggal_dokumen').value;
                document.getElementById('hidden_petugas_eksternal').value = document.getElementById('modal_petugas_eksternal').value;
                document.getElementById('hidden_nip_nrp_petugas_eksternal').value = document.getElementById('modal_nip_nrp_petugas_eksternal').value;
                document.getElementById('hidden_instansi_eksternal').value = document.getElementById('modal_instansi_eksternal').value;
                document.getElementById('hidden_dalam_rangka').value = document.getElementById('modal_dalam_rangka').value;

                // Ensure checkbox remains checked
                flagBastCheckbox.checked = true;

                bastModal.hide();
            });

            // When modal is closed without saving
            bastModalElement.addEventListener('hidden.coreui.modal', function () {
                const nomorBastHidden = document.getElementById('hidden_nomor_bast');
                // If BAST number is empty (modal was cancelled before filling), uncheck the box
                if (!nomorBastHidden.value) {
                    flagBastCheckbox.checked = false;
                }
            });
        }
    });
</script>
@endpush
