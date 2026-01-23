@extends('layouts.app')

@section('title', 'Referensi Pelanggaran')

@section('content')
<div class="container-lg">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0"><strong>Data Referensi Pelanggaran</strong></h5>
            {{-- Tombol untuk membuka modal tambah data --}}
            <button type="button" class="btn btn-primary" data-coreui-toggle="modal" data-coreui-target="#pelanggaranModal" data-url="{{ route('ref-pelanggaran.store') }}">
                <i class="cil-plus"></i> Tambah Data
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col" class="text-center" style="width: 5%;">#</th>
                            <th scope="col">Jenis Pelanggaran</th>
                            <th scope="col" class="text-center" style="width: 15%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pelanggaran as $item)
                            <tr>
                                <th scope="row" class="text-center">{{ $loop->iteration }}</th>
                                <td>{{ $item->pelanggaran }}</td>
                                <td class="text-center">
                                    {{-- Tombol untuk membuka modal edit data --}}
                                    <button type="button" class="btn btn-sm btn-warning text-white" data-coreui-toggle="modal" data-coreui-target="#pelanggaranModal" data-id="{{ $item->id }}" data-jenis="{{ $item->pelanggaran }}" data-url="{{ route('ref-pelanggaran.update', $item->id) }}" title="Edit Data">
                                        <i class="cil-pencil"></i>
                                    </button>
                                    {{-- Tombol untuk hapus data --}}
                                    <button type="button" class="btn btn-sm btn-danger text-white"
                                            data-coreui-toggle="modal"
                                            data-coreui-target="#deleteConfirmationModal"
                                            data-url="{{ route('ref-pelanggaran.destroy', $item->id) }}"
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
<div class="modal fade" id="pelanggaranModal" tabindex="-1" aria-labelledby="pelanggaranModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="pelanggaranModalLabel">Tambah Data Pelanggaran</h5>
                <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="pelanggaranForm" method="POST" action="">
                @csrf
                <div id="method-field"></div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="pelanggaran" class="form-label">Jenis Pelanggaran</label>
                        <textarea type="text" class="form-control" id="pelanggaran" name="pelanggaran" required></textarea>
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
        const pelanggaranModal = document.getElementById('pelanggaranModal');
        pelanggaranModal.addEventListener('show.coreui.modal', function (event) {
            const button = event.relatedTarget;
            const url = button.getAttribute('data-url');
            const id = button.getAttribute('data-id');
            const jenis = button.getAttribute('data-jenis');

            const modalTitle = pelanggaranModal.querySelector('.modal-title');
            const pelanggaranForm = pelanggaranModal.querySelector('#pelanggaranForm');
            const methodField = pelanggaranModal.querySelector('#method-field');
            const jenisInput = pelanggaranModal.querySelector('#pelanggaran');

            pelanggaranForm.setAttribute('action', url);

            if (id) {
                // Mode Edit
                modalTitle.textContent = 'Edit Data Pelanggaran';
                methodField.innerHTML = '@method("PUT")';
                jenisInput.value = jenis;
            } else {
                // Mode Tambah
                modalTitle.textContent = 'Tambah Data Pelanggaran';
                methodField.innerHTML = '';
                jenisInput.value = '';
            }
        });
    });
</script>
@endpush
