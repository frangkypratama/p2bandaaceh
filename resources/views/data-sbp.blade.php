@extends('layouts.app')

@section('content')
<div class="container-lg">
    <div class="card mb-4">
        <div class="card-header">
            <h1 class="mb-0">Data Surat Bukti Pelanggaran (SBP)</h1>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Nomor SBP</th>
                            <th>Tanggal SBP</th>
                            <th>Pelaku</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($sbpData as $sbp)
                            <tr>
                                <td>
                                    <div class="fw-bold">{{ $sbp->nomor_sbp }}</div>
                                </td>
                                <td>
                                    <div>{{ \Carbon\Carbon::parse($sbp->tanggal_sbp)->format('d F Y') }}</div>
                                </td>
                                <td>
                                    <div>{{ $sbp->nama_pelaku }}</div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <button type="button" class="btn btn-sm btn-info text-white me-2" data-coreui-toggle="modal" data-coreui-target="#viewModal" data-sbp='{{ json_encode($sbp) }}' title="Lihat Detail">
                                            <i class="cil-search"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-primary me-2" data-coreui-toggle="modal" data-coreui-target="#editModal" data-sbp='{{ json_encode($sbp) }}' title="Edit Data">
                                            <i class="cil-pencil"></i>
                                        </button>
                                        <form action="{{ route('sbp.destroy', $sbp->id) }}" method="POST" onsubmit="return confirm('Yakin hapus data ini?');" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Hapus Data">
                                                <i class="cil-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-4">Belum ada data SBP.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $sbpData->links() }}
            </div>
        </div>
    </div>
</div>

<!-- MODALS (Sama seperti sebelumnya) -->
<div class="modal fade" id="viewModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail SBP</h5>
                <button type="button" class="btn-close" data-coreui-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="view-body-content"></div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit SBP</h5>
                <button type="button" class="btn-close" data-coreui-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="editForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row g-3" id="edit-form-fields">
                        <!-- Fields will be populated by JS -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-coreui-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const sbpFields = [ 'nomor_sbp', 'tanggal_sbp', 'nomor_surat_perintah', 'tanggal_surat_perintah', 'nama_pelaku', 'jenis_identitas', 'nomor_identitas', 'lokasi_penindakan', 'waktu_penindakan', 'alasan_penindakan', 'jenis_barang', 'jumlah_barang', 'uraian_barang', 'nama_petugas_1', 'nama_petugas_2' ];
        const fieldTypes = { 'tanggal_sbp': 'date', 'tanggal_surat_perintah': 'date', 'waktu_penindakan': 'time', 'jumlah_barang': 'number', 'alasan_penindakan': 'textarea', 'uraian_barang': 'textarea' };
        
        const viewModal = document.getElementById('viewModal');
        viewModal.addEventListener('show.coreui.modal', event => {
            const button = event.relatedTarget;
            const sbp = JSON.parse(button.getAttribute('data-sbp'));
            const modalBody = viewModal.querySelector('#view-body-content');
            let content = '<dl class="row">';
            sbpFields.forEach(key => {
                if (sbp[key]) {
                     content += `<dt class="col-sm-4 text-capitalize">${key.replace(/_/g, ' ')}</dt><dd class="col-sm-8">${sbp[key]}</dd>`;
                }
            });
            content += '</dl>';
            modalBody.innerHTML = content;
        });

        const editModal = document.getElementById('editModal');
        editModal.addEventListener('show.coreui.modal', event => {
            const button = event.relatedTarget;
            const sbp = JSON.parse(button.getAttribute('data-sbp'));
            
            const form = editModal.querySelector('#editForm');
            form.action = `/data-sbp/${sbp.id}`;

            const fieldsContainer = editModal.querySelector('#edit-form-fields');
            let formFields = '';

            sbpFields.forEach(key => {
                let value = sbp[key] || '';
                // Format tanggal & waktu untuk input
                if ((key === 'tanggal_sbp' || key === 'tanggal_surat_perintah') && value) {
                    value = new Date(value).toISOString().split('T')[0];
                }

                const type = fieldTypes[key] || 'text';
                const label = key.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
                let fieldHtml = '';
                if (type === 'textarea') {
                    fieldHtml = `<div class="col-12"><label for="edit_${key}" class="form-label">${label}</label><textarea class="form-control" id="edit_${key}" name="${key}">${value}</textarea></div>`;
                } else {
                    fieldHtml = `<div class="col-md-6"><label for="edit_${key}" class="form-label">${label}</label><input type="${type}" class="form-control" id="edit_${key}" name="${key}" value="${value}"></div>`;
                }
                formFields += fieldHtml;
            });
            
            fieldsContainer.innerHTML = formFields;
        });
    });
</script>
@endpush
