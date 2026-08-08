<!-- Preview Modal (Laporan WhatsApp) -->
<div class="modal fade" id="waModal" tabindex="-1" aria-labelledby="waModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="waModalLabel">
                    <i class="cib-whatsapp me-1"></i> Preview Laporan WhatsApp
                </h5>
                <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <div class="text-center py-4" id="waLoading">
                    <div class="spinner-border text-success" role="status"></div>
                    <p class="mb-0 mt-2">Memuat laporan...</p>
                </div>
                <textarea id="waText" class="form-control d-none" rows="16" readonly
                          style="font-size: 14px; line-height: 1.5;"></textarea>
            </div>
            <div class="modal-footer">
                <span class="text-success small me-auto d-none" id="waCopiedLabel">Tersalin!</span>
                <button type="button" class="btn btn-secondary" data-coreui-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-success" id="waCopyBtn">
                    <i class="cil-copy"></i> Salin Teks
                </button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var waModalEl    = document.getElementById('waModal');
    var waModal      = new coreui.Modal(waModalEl);
    var waLoading    = document.getElementById('waLoading');
    var waText       = document.getElementById('waText');
    var waCopyBtn    = document.getElementById('waCopyBtn');
    var waCopiedLabel = document.getElementById('waCopiedLabel');

    function resetWaModal() {
        waText.classList.add('d-none');
        waText.value = '';
        waLoading.classList.remove('d-none');
        waCopiedLabel.classList.add('d-none');
    }

    document.querySelectorAll('.wa-btn').forEach(function (button) {
        button.addEventListener('click', function () {
            var url = this.getAttribute('data-wa-url');

            resetWaModal();
            waModal.show();

            fetch(url)
                .then(function (res) {
                    if (!res.ok) throw new Error('Gagal memuat laporan.');
                    return res.text();
                })
                .then(function (text) {
                    waText.value = text;
                    waLoading.classList.add('d-none');
                    waText.classList.remove('d-none');
                })
                .catch(function () {
                    waLoading.classList.add('d-none');
                    waText.value = 'Gagal memuat laporan. Silakan coba lagi.';
                    waText.classList.remove('d-none');
                });
        });
    });

    waCopyBtn.addEventListener('click', function () {
        if (!waText.value) return;
        waText.select();
        navigator.clipboard.writeText(waText.value).then(function () {
            waCopiedLabel.classList.remove('d-none');
            setTimeout(function () { waCopiedLabel.classList.add('d-none'); }, 2000);
        });
    });

    waModalEl.addEventListener('hidden.coreui.modal', resetWaModal);
});
</script>
