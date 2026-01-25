<div class="modal fade" id="pelanggaranModal" tabindex="-1" aria-labelledby="pelanggaranModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="pelanggaranModalLabel">Pilih Dugaan Pelanggaran</h5>
                <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="text-medium-emphasis">Pilih satu dugaan pelanggaran dari daftar di bawah ini.</p>
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col">Jenis Pelanggaran</th>
                                <th scope="col" class="text-center" style="width: 15%;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @isset($refPelanggaranData)
                                @forelse($refPelanggaranData as $item)
                                    <tr>
                                        <td>{{ $item->pelanggaran }}</td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-sm btn-primary btn-pilih-pelanggaran" data-pelanggaran="{{ $item->pelanggaran }}">
                                                <i class="cil-check"></i> Pilih
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="text-center">Tidak ada data referensi pelanggaran.</td>
                                    </tr>
                                @endforelse
                            @else
                                <tr>
                                    <td colspan="2" class="text-center">Data pelanggaran tidak ditemukan.</td>
                                </tr>
                            @endisset
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-coreui-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const pelanggaranModalElement = document.getElementById('pelanggaranModal');
        if (pelanggaranModalElement) {
            const alasanTextarea = document.getElementById('alasan_penindakan');
            const pelanggaranModal = coreui.Modal.getOrCreateInstance(pelanggaranModalElement);

            pelanggaranModalElement.addEventListener('click', function(event) {
                const button = event.target.closest('.btn-pilih-pelanggaran');
                if (button) {
                    const selectedPelanggaran = button.getAttribute('data-pelanggaran');
                    alasanTextarea.value = 'Diduga melanggar ' + selectedPelanggaran + '.';
                    pelanggaranModal.hide();
                }
            });
        }
    });
</script>
@endpush
