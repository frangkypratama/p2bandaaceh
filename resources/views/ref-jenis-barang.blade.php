@extends('layouts.app')

@section('title', 'Referensi Jenis Barang')

@section('content')
<div class="container-lg">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0"><strong>Data Referensi Jenis Barang</strong></h5>
            <button type="button" class="btn btn-primary" data-coreui-toggle="modal" data-coreui-target="#jenisBarangModal" data-url="{{ route('ref-jenis-barang.store') }}">
                <i class="cil-plus"></i> Tambah Data
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col" class="text-center" style="width: 5%;">No</th>
                            <th scope="col">Nama Barang</th>
                            <th scope="col" style="width: 20%;">Satuan Default</th>
                            <th scope="col" class="text-center" style="width: 15%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($jenisBarang as $barang)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $barang->nama_barang }}</td>
                                <td>{{ $barang->satuan->nama_satuan ?? 'N/A' }}</td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-sm btn-warning text-white"
                                            data-coreui-toggle="modal"
                                            data-coreui-target="#jenisBarangModal"
                                            data-id="{{ $barang->id }}"
                                            data-nama_barang="{{ $barang->nama_barang }}"
                                            data-id_satuan_default="{{ $barang->id_satuan_default }}"
                                            data-url="{{ route('ref-jenis-barang.update', $barang->id) }}"
                                            title="Edit Data">
                                        <i class="cil-pencil"></i>
                                    </button>
                                    {{-- Tombol ini menargetkan modal hapus global dari app.blade.php --}}
                                    <button type="button" class="btn btn-sm btn-danger text-white"
                                            data-coreui-toggle="modal"
                                            data-coreui-target="#deleteConfirmationModal" 
                                            data-url="{{ route('ref-jenis-barang.destroy', $barang->id) }}"
                                            title="Hapus Data">
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
<div class="modal fade" id="jenisBarangModal" tabindex="-1" aria-labelledby="jenisBarangModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="jenisBarangModalLabel">Tambah Data</h5>
                <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="jenisBarangForm" method="POST" action="">
                @csrf
                <div id="method-field"></div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nama_barang" class="form-label">Nama Barang</label>
                        <input type="text" class="form-control" id="nama_barang" name="nama_barang" required>
                    </div>
                    <div class="mb-3">
                        <label for="id_satuan_default" class="form-label">Satuan Default</label>
                        <select class="form-select" id="id_satuan_default" name="id_satuan_default" required>
                            <option value="" disabled selected>-- Pilih Satuan --</option>
                            @foreach($satuans as $satuan)
                                <option value="{{ $satuan->id }}">{{ $satuan->nama_satuan }}</option>
                            @endforeach
                        </select>
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
        const jenisBarangModal = document.getElementById('jenisBarangModal');
        jenisBarangModal.addEventListener('show.coreui.modal', function (event) {
            const button = event.relatedTarget;
            const url = button.getAttribute('data-url');
            const id = button.getAttribute('data-id');

            const modalTitle = jenisBarangModal.querySelector('.modal-title');
            const form = jenisBarangModal.querySelector('#jenisBarangForm');
            const methodField = jenisBarangModal.querySelector('#method-field');
            const namaBarangInput = jenisBarangModal.querySelector('#nama_barang');
            const idSatuanDefaultSelect = jenisBarangModal.querySelector('#id_satuan_default');

            form.action = url;

            if (id) {
                // Mode Edit
                const namaBarang = button.getAttribute('data-nama_barang');
                const idSatuanDefault = button.getAttribute('data-id_satuan_default');
                
                modalTitle.textContent = 'Edit Jenis Barang';
                methodField.innerHTML = '@method("PUT")';
                namaBarangInput.value = namaBarang;
                idSatuanDefaultSelect.value = idSatuanDefault;
            } else {
                // Mode Tambah
                modalTitle.textContent = 'Tambah Jenis Barang';
                methodField.innerHTML = '';
                form.reset();
            }
        });
    });
</script>
@endpush
