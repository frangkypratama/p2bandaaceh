@extends('layouts.app')

@section('title', 'Surat Perintah')

@section('content')
<div class="container-lg">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0"><strong>Data Surat Perintah</strong></h5>
            {{-- Tombol untuk membuka modal tambah data --}}
            <button type="button" class="btn btn-primary" data-coreui-toggle="modal" data-coreui-target="#suratPerintahModal" data-url="{{ route('surat-perintah.store') }}">
                <i class="cil-plus"></i> Tambah Data
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col" class="text-center" style="width: 5%;">No</th>
                            <th scope="col">Nomor Surat Perintah</th>
                            <th scope="col">Tanggal Surat Perintah</th>
                            <th scope="col" class="text-center" style="width: 15%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($suratPerintah as $item)
                            <tr>
                                <th scope="row" class="text-center">{{ $loop->iteration }}</th>
                                <td>{{ $item->nomor_prin }}</td>
                                <td>{{ $item->tanggal_prin }}</td>
                                <td class="text-center">
                                    {{-- Tombol untuk membuka modal edit data --}}
                                    <button type="button" class="btn btn-sm btn-warning text-white" data-coreui-toggle="modal" data-coreui-target="#suratPerintahModal" data-id="{{ $item->id }}" data-nomor_prin="{{ $item->nomor_prin }}" data-tanggal_prin="{{ $item->tanggal_prin }}" data-url="{{ route('surat-perintah.update', $item->id) }}" title="Edit Data">
                                        <i class="cil-pencil"></i>
                                    </button>
                                    {{-- Tombol untuk hapus data --}}
                                    <button type="button" class="btn btn-sm btn-danger text-white" data-coreui-toggle="modal" data-coreui-target="#deleteConfirmationModal" data-url="{{ route('surat-perintah.destroy', $item->id) }}" title="Hapus Data">
                                        <i class="cil-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">Tidak ada data.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- Modal untuk Tambah & Edit Data --}}
<div class="modal fade" id="suratPerintahModal" tabindex="-1" aria-labelledby="suratPerintahModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="suratPerintahModalLabel">Tambah Data Surat Perintah</h5>
                <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="suratPerintahForm" method="POST" action="">
                @csrf
                <div id="method-field"></div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nomor_prin" class="form-label">Nomor Surat</label>
                        <input type="text" class="form-control" id="nomor_prin" name="nomor_prin" required>
                    </div>
                    <div class="mb-3">
                        <label for="tanggal_prin" class="form-label">Tanggal Surat</label>
                        <input type="date" class="form-control" id="tanggal_prin" name="tanggal_prin" required>
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
        const suratPerintahModal = document.getElementById('suratPerintahModal');
        suratPerintahModal.addEventListener('show.coreui.modal', function (event) {
            const button = event.relatedTarget;
            const url = button.getAttribute('data-url');
            const id = button.getAttribute('data-id');
            const nomor_prin = button.getAttribute('data-nomor_prin');
            const tanggal_prin = button.getAttribute('data-tanggal_prin');

            const modalTitle = suratPerintahModal.querySelector('.modal-title');
            const suratPerintahForm = suratPerintahModal.querySelector('#suratPerintahForm');
            const methodField = suratPerintahModal.querySelector('#method-field');
            const nomorPrinInput = suratPerintahModal.querySelector('#nomor_prin');
            const tanggalPrinInput = suratPerintahModal.querySelector('#tanggal_prin');

            suratPerintahForm.setAttribute('action', url);

            if (id) {
                // Mode Edit
                modalTitle.textContent = 'Edit Data Surat Perintah';
                methodField.innerHTML = '@method("PUT")';
                nomorPrinInput.value = nomor_prin;
                tanggalPrinInput.value = tanggal_prin;
            } else {
                // Mode Tambah
                modalTitle.textContent = 'Tambah Data Surat Perintah';
                methodField.innerHTML = '';
                nomorPrinInput.value = '';
                tanggalPrinInput.value = '';
            }
        });
    });
</script>
@endpush
