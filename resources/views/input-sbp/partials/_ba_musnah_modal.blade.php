<!-- Modal BA Musnah -->
<div class="modal fade" id="baMusnahModal" tabindex="-1" aria-labelledby="baMusnahModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="baMusnahModalLabel">Input Berita Acara Pemusnahan</h5>
                <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="modal_nomor_ba_musnah" class="form-label">Nomor BA Musnah</label>
                    <input type="text" class="form-control" id="modal_nomor_ba_musnah" placeholder="Masukkan nomor BA Musnah...">
                </div>
            </div>
            <div class="modal-footer">
                @isset($sbp)
                    <button type="button" class="btn btn-danger me-auto" id="modalDeleteBaMusnahBtn">
                        <i class="cil-trash"></i> Hapus BA Musnah
                    </button>
                @endisset
                <button type="button" class="btn btn-secondary" data-coreui-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="saveBaMusnahButton">Simpan</button>
            </div>
        </div>
    </div>
</div>