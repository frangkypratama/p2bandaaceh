<div class="modal fade" id="baMusnahModal" tabindex="-1" aria-labelledby="baMusnahModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="baMusnahModalLabel">Berita Acara Pemusnahan</h5>
                <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-md-12">
                        <label class="form-label">Tindak Lanjut:</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="modal_dimusnahkan" value="dimusnahkan">
                            <label class="form-check-label" for="modal_dimusnahkan">Barang dimusnahkan</label>
                        </div>
                    </div>
                    {{-- Tambahkan field lain yang relevan untuk BA Musnah jika ada --}}
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-coreui-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="saveBaMusnahButton">Simpan</button>
            </div>
        </div>
    </div>
</div>
