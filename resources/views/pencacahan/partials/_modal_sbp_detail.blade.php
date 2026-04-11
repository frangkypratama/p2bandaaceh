<div class="modal fade" id="detailSbpModal" tabindex="-1" aria-labelledby="detailSbpModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="detailSbpModalLabel"><i class="cil-list-rich me-2"></i>Detail Barang Cacahan</h5>
                <button type="button" class="btn-close btn-close-white" data-coreui-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{-- Data SBP Read-only --}}
                <div class="card mb-4">
                    <div class="card-header">
                        <h6 class="card-title mb-0"><i class="cil-file me-2"></i>Informasi SBP</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Nomor SBP</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="cil-barcode"></i></span>
                                        <input type="text" id="detail-nomor-sbp" class="form-control" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Tanggal SBP</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="cil-calendar"></i></span>
                                        <input type="text" id="detail-tanggal-sbp" class="form-control" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Jenis Barang</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="cil-layers"></i></span>
                                <input type="text" id="detail-jenis-barang" class="form-control" readonly>
                            </div>
                        </div>
                        <div>
                            <label class="form-label fw-bold">Uraian Barang</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="cil-description"></i></span>
                                <textarea id="detail-uraian-barang" class="form-control" readonly rows="2"></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Repeater untuk Detail Barang --}}
                <div class="card mb-4">
                    <div class="card-header">
                        <h6 class="card-title mb-0"><i class="cil-sitemap me-2"></i>Input Detail Barang</h6>
                    </div>
                    <div class="card-body">
                        <div id="detailSbpForm">
                            <div id="barangItemsContainer"></div>
                            <div id="emptyBarangMessage" class="text-center text-muted border rounded p-4 my-3">
                                <i class="cil-box" style="font-size: 2.5rem;"></i>
                                <p class="mb-0 mt-2 fw-bold">Belum ada barang yang ditambahkan.</p>
                                <small>Klik tombol di bawah untuk memulai.</small>
                            </div>
                            <button type="button" id="btnTambahBarang" class="btn btn-primary w-100 mt-2">
                                <i class="cil-plus me-2"></i>Tambah Barang
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Upload Foto --}}
                <div class="card">
                    <div class="card-header">
                        <h6 class="card-title mb-0"><i class="cil-camera me-2"></i>Unggah Foto Barang Bukti</h6>
                    </div>
                    <div class="card-body">
                        <div class="foto-upload-wrapper" id="foto-upload-modal-trigger" style="cursor: pointer; border: 2px dashed #c4c9d0; border-radius: .25rem; padding: 1rem;">
                            <div id="foto-preview-container-modal" class="text-center">
                                <img src="" id="foto_preview_modal" class="img-fluid rounded d-none" alt="Pratinjau" style="max-height: 250px;">
                                <div class="foto-placeholder-modal">
                                    <i class="cil-cloud-upload" style="font-size: 3rem; color: #8e98a7;"></i>
                                    <p class="mb-0 small text-muted mt-2">Klik di sini untuk memilih foto</p>
                                </div>
                            </div>
                        </div>
                        <div class="text-center mt-2">
                            <button type="button" class="btn btn-sm btn-danger d-none" id="btn-remove-foto-modal">
                                <i class="cil-trash me-1"></i>Hapus Foto
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-coreui-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="saveSbpDetailButton">
                    <i class="cil-save me-2"></i>Simpan Detail
                </button>
            </div>
        </div>
    </div>
</div>
