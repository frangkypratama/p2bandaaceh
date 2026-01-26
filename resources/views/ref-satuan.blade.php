@extends('layouts.app')

@section('title', 'Referensi Satuan')

@section('content')
<div class="container-lg">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0"><strong>Data Referensi Satuan</strong></h5>
            {{-- Tombol untuk membuka modal tambah data --}}
            <button type="button" class="btn btn-primary" data-coreui-toggle="modal" data-coreui-target="#satuanModal" data-url="{{ route('ref-satuan.store') }}">
                <i class="cil-plus"></i> Tambah Data
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col" class="text-center" style="width: 5%;">#</th>
                            <th scope="col">Nama Satuan</th>
                            <th scope="col" class="text-center" style="width: 15%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($satuan as $item)
                            <tr>
                                <th scope="row" class="text-center">{{ $loop->iteration }}</th>
                                <td>{{ $item->nama_satuan }}</td>
                                <td class="text-center">
                                    {{-- Tombol untuk membuka modal edit data --}}
                                    <button type="button" class="btn btn-sm btn-warning text-white" data-coreui-toggle="modal" data-coreui-target="#satuanModal" data-id="{{ $item->id }}" data-nama_satuan="{{ $item->nama_satuan }}" data-url="{{ route('ref-satuan.update', $item->id) }}" title="Edit Data">
                                        <i class="cil-pencil"></i>
                                    </button>
                                    {{-- Tombol untuk hapus data --}}
                                    <button type="button" class="btn btn-sm btn-danger text-white"
                                            data-coreui-toggle="modal"
                                            data-coreui-target="#deleteConfirmationModal"
                                            data-url="{{ route('ref-satuan.destroy', $item->id) }}"
                                            title="Hapus Data">
                                        <i class="cil-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center">Tidak ada data.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- Modal untuk Tambah & Edit Data --}}
<div class="modal fade" id="satuanModal" tabindex="-1" aria-labelledby="satuanModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="satuanModalLabel">Tambah Data Satuan</h5>
                <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="satuanForm" method="POST" action="">
                @csrf
                <div id="method-field"></div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nama_satuan" class="form-label">Nama Satuan</label>
                        <input type="text" class="form-control" id="nama_satuan" name="nama_satuan" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-coreui-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const satuanModal = document.getElementById('satuanModal');
        satuanModal.addEventListener('show.coreui.modal', function (event) {
            const button = event.relatedTarget;
            const url = button.getAttribute('data-url');
            const id = button.getAttribute('data-id');
            const nama_satuan = button.getAttribute('data-nama_satuan');

            const modalTitle = satuanModal.querySelector('.modal-title');
            const satuanForm = satuanModal.querySelector('#satuanForm');
            const methodField = satuanModal.querySelector('#method-field');
            const namaSatuanInput = satuanModal.querySelector('#nama_satuan');

            satuanForm.setAttribute('action', url);

            if (id) {
                // Mode Edit
                modalTitle.textContent = 'Edit Data Satuan';
                methodField.innerHTML = '@method("PUT")';
                namaSatuanInput.value = nama_satuan;
            } else {
                // Mode Tambah
                modalTitle.textContent = 'Tambah Data Satuan';
                methodField.innerHTML = '';
                namaSatuanInput.value = '';
            }
        });
    });
</script>
@endpush
