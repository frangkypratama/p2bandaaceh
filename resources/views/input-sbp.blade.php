@extends('layouts.app')

@section('title', 'Input SBP')

@section('content')
<div class="container-lg">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0"><strong>Input Surat Bukti Penindakan (SBP)</strong></h4>
                    <small class="text-medium-emphasis">Lengkapi semua informasi yang diperlukan di bawah ini.</small>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('sbp.store') }}" class="row g-3" id="sbpForm">
                        @csrf

                        {{-- Include Partials --}}
                        @include('input-sbp.partials._penomoran')
                        @include('input-sbp.partials._identitas_pelaku')
                        @include('input-sbp.partials._detail_penindakan')
                        @include('input-sbp.partials._barang_bukti')
                        @include('input-sbp.partials._petugas')

                        {{-- Hidden BAST Fields --}}
                        <input type="hidden" name="nomor_bast" id="hidden_nomor_bast" value="{{ old('nomor_bast') }}">
                        <input type="hidden" name="tanggal_bast" id="hidden_tanggal_bast" value="{{ old('tanggal_bast') }}">
                        <input type="hidden" name="jenis_dokumen" id="hidden_jenis_dokumen" value="{{ old('jenis_dokumen') }}">
                        <input type="hidden" name="tanggal_dokumen" id="hidden_tanggal_dokumen" value="{{ old('tanggal_dokumen') }}">
                        <input type="hidden" name="petugas_eksternal" id="hidden_petugas_eksternal" value="{{ old('petugas_eksternal') }}">
                        <input type="hidden" name="nip_nrp_petugas_eksternal" id="hidden_nip_nrp_petugas_eksternal" value="{{ old('nip_nrp_petugas_eksternal') }}">
                        <input type="hidden" name="instansi_eksternal" id="hidden_instansi_eksternal" value="{{ old('instansi_eksternal') }}">
                        <input type="hidden" name="dalam_rangka" id="hidden_dalam_rangka" value="{{ old('dalam_rangka') }}">

                        <div class="col-12 text-center">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="cil-save"></i> Simpan Data SBP
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Include Modal --}}
@include('input-sbp.partials._bast_modal')

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const flagBastCheckbox = document.getElementById('flag_bast');
        const saveBastButton = document.getElementById('saveBastButton');
        const bastModalElement = document.getElementById('bastModal');
        
        if (!bastModalElement || !flagBastCheckbox || !saveBastButton) {
            console.error('One or more required elements for the BAST modal are missing.');
            return;
        }

        const bastModal = coreui.Modal.getOrCreateInstance(bastModalElement);

        // Function to load data from hidden inputs to modal
        function loadModalData() {
            document.getElementById('modal_nomor_bast').value = document.getElementById('hidden_nomor_bast').value;
            document.getElementById('modal_tanggal_bast').value = document.getElementById('hidden_tanggal_bast').value;
            document.getElementById('modal_jenis_dokumen').value = document.getElementById('hidden_jenis_dokumen').value;
            document.getElementById('modal_tanggal_dokumen').value = document.getElementById('hidden_tanggal_dokumen').value;
            document.getElementById('modal_petugas_eksternal').value = document.getElementById('hidden_petugas_eksternal').value;
            document.getElementById('modal_nip_nrp_petugas_eksternal').value = document.getElementById('hidden_nip_nrp_petugas_eksternal').value;
            document.getElementById('modal_instansi_eksternal').value = document.getElementById('hidden_instansi_eksternal').value;
            document.getElementById('modal_dalam_rangka').value = document.getElementById('hidden_dalam_rangka').value;
        }

        flagBastCheckbox.addEventListener('change', function () {
            if (this.checked) {
                loadModalData();
                bastModal.show();
            }
        });

        saveBastButton.addEventListener('click', function () {
            // Transfer data from modal to hidden inputs
            document.getElementById('hidden_nomor_bast').value = document.getElementById('modal_nomor_bast').value;
            document.getElementById('hidden_tanggal_bast').value = document.getElementById('modal_tanggal_bast').value;
            document.getElementById('hidden_jenis_dokumen').value = document.getElementById('modal_jenis_dokumen').value;
            document.getElementById('hidden_tanggal_dokumen').value = document.getElementById('modal_tanggal_dokumen').value;
            document.getElementById('hidden_petugas_eksternal').value = document.getElementById('modal_petugas_eksternal').value;
            document.getElementById('hidden_nip_nrp_petugas_eksternal').value = document.getElementById('modal_nip_nrp_petugas_eksternal').value;
            document.getElementById('hidden_instansi_eksternal').value = document.getElementById('modal_instansi_eksternal').value;
            document.getElementById('hidden_dalam_rangka').value = document.getElementById('modal_dalam_rangka').value;
            
            bastModal.hide();
        });

        bastModalElement.addEventListener('hidden.coreui.modal', function () {
            const nomorBastHidden = document.getElementById('hidden_nomor_bast');
            if (!nomorBastHidden.value) { 
                flagBastCheckbox.checked = false;
            }
        });
        
        // If there are old BAST values (e.g., due to validation failure), check the box.
        if (document.getElementById('hidden_nomor_bast').value) {
            flagBastCheckbox.checked = true;
        }
    });
</script>
@endpush
