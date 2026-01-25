<!-- Modal BA Musnah -->
<div class="modal fade" id="baMusnahModal" tabindex="-1" aria-labelledby="baMusnahModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="baMusnahModalLabel">Input Berita Acara Pemusnahan</h5>
                <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="nomor_ba_musnah" id="hidden_nomor_ba_musnah" value="{{ old('nomor_ba_musnah') }}">
                <div class="mb-3">
                    <label for="modal_nomor_ba_musnah" class="form-label">Nomor BA Musnah</label>
                    <input type="text" class="form-control" id="modal_nomor_ba_musnah" placeholder="Masukkan nomor BA Musnah...">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-coreui-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="saveBaMusnahButton">Simpan</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const flagBaMusnahCheckbox = document.getElementById('flag_ba_musnah');
        const baMusnahModalElement = document.getElementById('baMusnahModal');
        const saveBaMusnahButton = document.getElementById('saveBaMusnahButton');

        // Use the exact same conditional check as the working BAST modal
        if (flagBaMusnahCheckbox && baMusnahModalElement && saveBaMusnahButton) {
            
            const baMusnahModal = new coreui.Modal(baMusnahModalElement);
            const hiddenInput = document.getElementById('hidden_nomor_ba_musnah');
            const modalInput = document.getElementById('modal_nomor_ba_musnah');

            // Further check for the non-essential elements before using them
            if (hiddenInput && modalInput) {
                
                // Pre-fill modal input on page load
                modalInput.value = hiddenInput.value;

                // Attach a DIRECT event listener to the checkbox
                flagBaMusnahCheckbox.addEventListener('change', function () {
                    if (this.checked) {
                        modalInput.value = hiddenInput.value; // Sync value before showing
                        baMusnahModal.show();
                    } else {
                        // When unchecked manually, clear the data
                        hiddenInput.value = '';
                        modalInput.value = '';
                    }
                });

                // Save button listener
                saveBaMusnahButton.addEventListener('click', function () {
                    hiddenInput.value = modalInput.value;
                    flagBaMusnahCheckbox.checked = true; // Ensure checkbox stays checked
                    baMusnahModal.hide();
                });

                // Modal close listener (for cancel/X button)
                baMusnahModalElement.addEventListener('hidden.coreui.modal', function () {
                    // If modal is closed and no data is saved, uncheck the box
                    if (!hiddenInput.value) {
                        flagBaMusnahCheckbox.checked = false;
                    }
                });

                // On-load check for server validation errors
                const errors = @json($errors->keys());
                if (errors.includes('nomor_ba_musnah')) {
                    baMusnahModal.show();
                }
            }
        }
    });
</script>
@endpush
