@extends('layouts.app')

@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dasbor</a></li>
        <li class="breadcrumb-item"><a href="{{ route('lpt.index') }}">Data LPT</a></li>
        <li class="breadcrumb-item active">Tambah LPT</li>
    </ol>
@endsection

@section('content')
    <div class="container-lg">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        <strong>Tambah Laporan Pelaksanaan Tugas (LPT)</strong>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('lpt.store') }}" method="POST">
                            @csrf

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="nomor_lpt" class="form-label">Nomor LPT</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="cil-notes"></i></span>
                                            <input type="text" class="form-control @error('nomor_lpt') is-invalid @enderror" id="nomor_lpt" name="nomor_lpt" value="{{ old('nomor_lpt') }}" required>
                                        </div>
                                        @error('nomor_lpt')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="tanggal_lpt" class="form-label">Tanggal LPT</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="cil-calendar"></i></span>
                                            <input type="date" class="form-control @error('tanggal_lpt') is-invalid @enderror" id="tanggal_lpt" name="tanggal_lpt" value="{{ old('tanggal_lpt', date('Y-m-d')) }}" required>
                                        </div>
                                        @error('tanggal_lpt')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            {{-- SBP Selection --}}
                            <div class="form-group mb-3">
                                <label for="nomor_sbp_display" class="form-label">Nomor SBP</label>
                                <div class="input-group">
                                    <input type="text" class="form-control @error('sbp_id') is-invalid @enderror" id="nomor_sbp_display" placeholder="Pilih SBP..." readonly>
                                    <button class="btn btn-outline-primary" type="button" id="pilihSbpBtn">Pilih SBP</button>
                                </div>
                                <input type="hidden" name="sbp_id" id="sbp_id">
                                @error('sbp_id')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="jenis_lpt" class="form-label">Jenis LPT</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="cil-tag"></i></span>
                                    <input type="text" class="form-control @error('jenis_lpt') is-invalid @enderror" id="jenis_lpt" name="jenis_lpt" value="{{ old('jenis_lpt') }}" required>
                                </div>
                                @error('jenis_lpt')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="cil-save me-2"></i>Simpan
                                </button>
                                <a href="{{ route('lpt.index') }}" class="btn btn-secondary">
                                    <i class="cil-x-circle me-2"></i>Batal
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal SBP -->
<div class="modal fade" id="sbpModal" tabindex="-1" aria-labelledby="sbpModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="sbpModalLabel">Pilih SBP</h5>
                <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover" id="sbp">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nomor SBP</th>
                                <th>Tanggal SBP</th>
                                <th>Nama Pelaku</th>
                                <th>Jenis Barang</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sbp as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->nomor_sbp }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->tanggal_sbp)->format('d-m-Y') }}</td>
                                    <td>{{ $item->nama_pelaku }}</td>
                                    <td>{{ $item->jenis_barang }}</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-primary pilih-sbp-btn" data-id="{{ $item->id }}">
                                            Pilih
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const sbpModalElement = document.getElementById('sbpModal');
        const pilihSbpBtn = document.getElementById('pilihSbpBtn');
        const sbpTable = document.getElementById('sbp');

        if (sbpModalElement && pilihSbpBtn) {
            const sbpModal = new coreui.Modal(sbpModalElement);
            pilihSbpBtn.addEventListener('click', function () {
                sbpModal.show();
            });
        } else {
            console.error('Elemen modal atau tombol pemicu tidak dapat ditemukan.');
        }

        if (sbpTable) {
            sbpTable.addEventListener('click', function (e) {
                if (e.target && e.target.classList.contains('pilih-sbp-btn')) {
                    const sbpId = e.target.getAttribute('data-id');

                    // AJAX call to get SBP data
                    fetch(`/api/sbp/${sbpId}`)
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok.');
                            }
                            return response.json();
                        })
                        .then(data => {
                            // Populate form fields
                            document.getElementById('sbp_id').value = data.id;
                            const nomorSbpDisplay = document.getElementById('nomor_sbp_display');
                            nomorSbpDisplay.value = data.nomor_sbp;

                            // Store additional details as data attributes on the display input
                            nomorSbpDisplay.dataset.tanggalSbp = data.tanggal_sbp;
                            nomorSbpDisplay.dataset.namaPelaku = data.nama_pelaku;
                            nomorSbpDisplay.dataset.jenisBarang = data.jenis_barang;

                            // Hide modal after selection
                            const sbpModalInstance = coreui.Modal.getInstance(sbpModalElement);
                            if (sbpModalInstance) {
                                sbpModalInstance.hide();
                            }
                        })
                        .catch(error => {
                            console.error('Error fetching SBP data:', error);
                            alert('Gagal mengambil data SBP. Periksa konsol untuk detailnya.');
                        });
                }
            });
        }
    });
</script>
@endpush
