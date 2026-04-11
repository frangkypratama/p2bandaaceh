{{-- Modal Detail SBP --}}
<div class="modal fade" id="detailSbpModal" tabindex="-1" aria-labelledby="detailSbpModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailSbpModalLabel">Detail Barang Cacahan</h5>
                <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{-- Data SBP Read-only --}}
                <div class="row mb-3">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nomor SBP</label>
                        <input type="text" id="detail-nomor-sbp" class="form-control-plaintext" readonly>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tanggal SBP</label>
                        <input type="text" id="detail-tanggal-sbp" class="form-control-plaintext" readonly>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Jenis Barang</label>
                    <input type="text" id="detail-jenis-barang" class="form-control-plaintext" readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label">Uraian Barang</label>
                    <textarea id="detail-uraian-barang" class="form-control-plaintext" readonly rows="2"></textarea>
                </div>

                <hr>

                {{-- Repeater untuk Detail Barang --}}
                <h6 class="mb-3">Input Detail Barang</h6>
                <div id="detailSbpForm">
                    <div id="barangItemsContainer"></div>
                    <div id="emptyBarangMessage" class="text-center text-muted border rounded p-3 my-3">
                        <i class="cil-box" style="font-size: 2rem;"></i>
                        <p class="mb-0 mt-2">Belum ada barang yang ditambahkan.</p>
                    </div>
                    <button type="button" id="btnTambahBarang" class="btn btn-outline-primary w-100 mt-2">
                        <i class="cil-plus me-2"></i>Tambah Barang
                    </button>
                </div>

                <hr>

                {{-- Upload Foto --}}
                <h6 class="mb-3">Unggah Foto Barang Bukti</h6>
                <div class="foto-upload-wrapper" id="foto-upload-modal-trigger">
                    <div id="foto-preview-container-modal">
                        <img src="" id="foto_preview_modal" class="img-fluid rounded d-none" alt="Pratinjau">
                        <div class="foto-placeholder-modal text-center">
                            <i class="cil-camera" style="font-size: 2.5rem; color: #8e98a7;"></i>
                            <p class="mb-0 small text-muted mt-2">Klik untuk memilih foto</p>
                        </div>
                    </div>
                </div>
                <div class="text-center mt-2">
                    <button type="button" class="btn btn-sm btn-danger d-none" id="btn-remove-foto-modal">
                        <i class="cil-trash me-1"></i>Hapus Foto
                    </button>
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