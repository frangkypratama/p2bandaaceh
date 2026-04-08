@extends('layouts.app')

@section('title', 'Referensi Tarif Cukai')

@section('content')
<div class="container-lg">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0"><strong>Data Referensi Tarif Cukai</strong></h5>
            {{-- Tombol untuk membuka modal tambah data --}}
            <button type="button" class="btn btn-primary" data-coreui-toggle="modal" data-coreui-target="#tarifCukaiModal" data-url="{{ route('ref-tarif-cukai.store') }}">
                <i class="cil-plus"></i> Tambah Data
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col" class="text-center" style="width: 5%;">#</th>
                            <th scope="col">Jenis</th>
                            <th scope="col">Golongan</th>
                            <th scope="col" class="text-end">HJE Min</th>
                            <th scope="col" class="text-end">HJE Max</th>
                            <th scope="col" class="text-end">Tarif</th>
                            <th scope="col" class="text-center" style="width: 15%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tarifCukai as $item)
                            <tr>
                                <th scope="row" class="text-center">{{ $loop->iteration }}</th>
                                <td>{{ $item->jenis }}</td>
                                <td>{{ $item->golongan }}</td>
                                <td class="text-end">Rp {{ number_format($item->hje_min, 2, ',', '.') }}</td>
                                <td class="text-end">Rp {{ number_format($item->hje_max, 2, ',', '.') }}</td>
                                <td class="text-end">Rp {{ number_format($item->tarif, 2, ',', '.') }}</td>
                                <td class="text-center">
                                    {{-- Tombol untuk membuka modal edit data --}}
                                    <button type="button" class="btn btn-sm btn-warning text-white" 
                                            data-coreui-toggle="modal" 
                                            data-coreui-target="#tarifCukaiModal" 
                                            data-id="{{ $item->id }}" 
                                            data-jenis="{{ $item->jenis }}"
                                            data-golongan="{{ $item->golongan }}"
                                            data-hje_min="{{ $item->hje_min }}"
                                            data-hje_max="{{ $item->hje_max }}"
                                            data-tarif="{{ $item->tarif }}"
                                            data-url="{{ route('ref-tarif-cukai.update', $item->id) }}" 
                                            title="Edit Data">
                                        <i class="cil-pencil"></i>
                                    </button>
                                    {{-- Tombol untuk hapus data --}}
                                    <button type="button" class="btn btn-sm btn-danger text-white"
                                            data-coreui-toggle="modal"
                                            data-coreui-target="#deleteConfirmationModal"
                                            data-url="{{ route('ref-tarif-cukai.destroy', $item->id) }}"
                                            title="Hapus Data">
                                        <i class="cil-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Tidak ada data.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- Modal untuk Tambah & Edit Data --}}
<div class="modal fade" id="tarifCukaiModal" tabindex="-1" aria-labelledby="tarifCukaiModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tarifCukaiModalLabel">Tambah Data</h5>
                <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="tarifCukaiForm" method="POST" action="">
                @csrf
                <div id="method-field"></div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="jenis" class="form-label">Jenis</label>
                        <input type="text" class="form-control" id="jenis" name="jenis" required>
                    </div>
                    <div class="mb-3">
                        <label for="golongan" class="form-label">Golongan</label>
                        <input type="text" class="form-control" id="golongan" name="golongan" required>
                    </div>
                    <div class="mb-3">
                        <label for="hje_min" class="form-label">HJE Minimum</label>
                        <input type="number" class="form-control" id="hje_min" name="hje_min" step="0.01" required>
                    </div>
                    <div class="mb-3">
                        <label for="hje_max" class="form-label">HJE Maksimum</label>
                        <input type="number" class="form-control" id="hje_max" name="hje_max" step="0.01">
                    </div>
                    <div class="mb-3">
                        <label for="tarif" class="form-label">Tarif</label>
                        <input type="number" class="form-control" id="tarif" name="tarif" step="0.01" required>
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
        const tarifCukaiModal = document.getElementById('tarifCukaiModal');
        tarifCukaiModal.addEventListener('show.coreui.modal', function (event) {
            const button = event.relatedTarget;
            const url = button.getAttribute('data-url');
            const id = button.getAttribute('data-id');

            const modalTitle = tarifCukaiModal.querySelector('.modal-title');
            const form = tarifCukaiModal.querySelector('#tarifCukaiForm');
            const methodField = tarifCukaiModal.querySelector('#method-field');
            
            form.setAttribute('action', url);

            if (id) {
                // Mode Edit
                modalTitle.textContent = 'Edit Data Tarif Cukai';
                methodField.innerHTML = '@method("PUT")';
                
                // Isi form dengan data dari atribut data-*
                form.querySelector('#jenis').value = button.getAttribute('data-jenis');
                form.querySelector('#golongan').value = button.getAttribute('data-golongan');
                form.querySelector('#hje_min').value = button.getAttribute('data-hje_min');
                form.querySelector('#hje_max').value = button.getAttribute('data-hje_max');
                form.querySelector('#tarif').value = button.getAttribute('data-tarif');
            } else {
                // Mode Tambah
                modalTitle.textContent = 'Tambah Data Tarif Cukai';
                methodField.innerHTML = '';
                form.reset(); // Bersihkan form
            }
        });
    });
</script>
@endpush
