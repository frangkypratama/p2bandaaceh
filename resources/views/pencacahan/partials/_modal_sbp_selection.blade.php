<div class="modal fade" id="sbpModal" tabindex="-1" aria-labelledby="sbpModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="sbpModalLabel"><i class="cil-file me-2"></i>Pilih Dokumen SBP</h5>
                <button type="button" class="btn-close btn-close-white" data-coreui-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="input-group mb-3">
                    <span class="input-group-text"><i class="cil-search"></i></span>
                    <input type="text" id="sbpSearchInput" class="form-control" placeholder="Cari berdasarkan Nomor SBP...">
                </div>
                <div id="sbpLoadingIndicator" class="text-center py-4 d-none">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2 mb-0">Memuat data SBP...</p>
                </div>
                <div id="sbpErrorAlert" class="alert alert-danger d-none"></div>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center" style="width: 5%;"><i class="cil-hand-point-up"></i></th>
                                <th><i class="cil-barcode me-2"></i>Nomor SBP</th>
                                <th><i class="cil-calendar me-2"></i>Tanggal SBP</th>
                                <th><i class="cil-info me-2"></i>Status</th>
                            </tr>
                        </thead>
                        <tbody id="sbpTableBody">
                            <tr>
                                <td colspan="4">
                                    <div class="text-center text-muted p-4">
                                        <i class="cil-keyboard" style="font-size: 2.5rem;"></i>
                                        <p class="mb-0 mt-2 fw-bold">Mulai Mencari</p>
                                        <small>Ketik kata kunci pada kolom pencarian di atas untuk menemukan SBP.</small>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div id="sbpPagination" class="d-flex justify-content-center mt-3"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-coreui-dismiss="modal"><i class="cil-x me-2"></i>Tutup</button>
                <button type="button" class="btn btn-primary" id="selectSbpButton"><i class="cil-check-alt me-2"></i>Pilih</button>
            </div>
        </div>
    </div>
</div>
