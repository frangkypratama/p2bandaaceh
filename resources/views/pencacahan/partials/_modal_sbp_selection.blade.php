{{-- Modal SBP --}}
<div class="modal fade" id="sbpModal" tabindex="-1" aria-labelledby="sbpModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header"><h5 class="modal-title" id="sbpModalLabel">Pilih Dokumen SBP</h5><button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button></div>
            <div class="modal-body">
                <div class="mb-3"><input type="text" id="sbpSearchInput" class="form-control" placeholder="Cari berdasarkan Nomor SBP..."></div>
                <div id="sbpLoadingIndicator" class="text-center py-3 d-none"><div class="spinner-border text-primary"></div><span class="ms-2">Memuat...</span></div>
                <div id="sbpErrorAlert" class="alert alert-danger d-none"></div>
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center"><i class="cil-check-alt"></i></th>
                            <th>Nomor SBP</th>
                            <th>Tanggal SBP</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody id="sbpTableBody"><tr><td colspan="4" class="text-center text-muted">Ketik untuk mencari SBP...</td></tr></tbody>
                </table>
                <div id="sbpPagination" class="d-flex justify-content-center mt-3"></div>
            </div>
            <div class="modal-footer"><button type="button" class="btn btn-secondary" data-coreui-dismiss="modal">Tutup</button><button type="button" class="btn btn-primary" id="selectSbpButton">Pilih</button></div>
        </div>
    </div>
</div>
