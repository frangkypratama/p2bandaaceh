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
                 <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="modal_nomor_bast" class="form-label">Nomor BAST</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="cil-notes"></i></span>
                                <input type="text" class="form-control" id="modal_nomor_bast" name="nomor_bast" placeholder="Contoh: BAST-1/KBC.010202/2025" value="{{ old('nomor_bast', isset($sbp) ? $sbp->bast?->nomor_bast : '') }}">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="modal_tanggal_bast" class="form-label">Tanggal BAST</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="cil-calendar"></i></span>
                                <input type="date" class="form-control" id="modal_tanggal_bast" name="tanggal_bast" value="{{ old('tanggal_bast', isset($sbp) && $sbp->bast?->tanggal_bast ? $sbp->bast->tanggal_bast->format('Y-m-d') : '') }}">
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
                                <input type="text" class="form-control" id="modal_jenis_dokumen" name="jenis_dokumen" placeholder="Contoh: Surat Pemberitahuan" value="{{ old('jenis_dokumen', isset($sbp) ? $sbp->bast?->jenis_dokumen : '') }}">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="modal_tanggal_dokumen" class="form-label">Tanggal Dokumen</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="cil-calendar"></i></span>
                                <input type="date" class="form-control" id="modal_tanggal_dokumen" name="tanggal_dokumen" value="{{ old('tanggal_dokumen', isset($sbp) && $sbp->bast?->tanggal_dokumen ? $sbp->bast->tanggal_dokumen->format('Y-m-d') : '') }}">
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
                                <input type="text" class="form-control" id="modal_petugas_eksternal" name="petugas_eksternal" placeholder="Nama lengkap petugas" value="{{ old('petugas_eksternal', isset($sbp) ? $sbp->bast?->petugas_eksternal : '') }}">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="modal_nip_nrp_petugas_eksternal" class="form-label">NIP/NRP Petugas</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="cil-badge"></i></span>
                                <input type="text" class="form-control" id="modal_nip_nrp_petugas_eksternal" name="nip_nrp_petugas_eksternal" placeholder="Nomor Induk Pegawai/NRP" value="{{ old('nip_nrp_petugas_eksternal', isset($sbp) ? $sbp->bast?->nip_nrp_petugas_eksternal : '') }}">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="modal_instansi_eksternal" class="form-label">Instansi</label>
                    <div class="input-group">
                         <span class="input-group-text"><i class="cil-building"></i></span>
                        <input type="text" class="form-control" id="modal_instansi_eksternal" name="instansi_eksternal" placeholder="Contoh: Badan Karantina Indonesia" value="{{ old('instansi_eksternal', isset($sbp) ? $sbp->bast?->instansi_eksternal : '') }}">
                    </div>
                </div>

                <hr>

                <div class="mb-3">
                    <label for="modal_dalam_rangka" class="form-label">Dalam Rangka</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="cil-description"></i></span>
                        <textarea class="form-control" id="modal_dalam_rangka" name="dalam_rangka" rows="3" placeholder="Jelaskan tujuan serah terima">{{ old('dalam_rangka', isset($sbp) ? $sbp->bast?->dalam_rangka : '') }}</textarea>
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
