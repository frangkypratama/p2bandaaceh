@extends('layouts.app')

@section('content')
<div class="container-lg">
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="card-title mb-0">Edit Pencacahan</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('pencacahan.update', $pencacahan->id) }}" method="POST" id="editPencacahanForm">
                @csrf
                @method('PUT')
                <h5 class="mb-3">Penomoran</h5>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="no_ba_cacah_nomor" class="form-label">Nomor BA Cacah</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="cil-notes"></i></span>
                                <input type="text" class="form-control" id="no_ba_cacah_nomor" placeholder="Masukkan hanya angka" required oninput="this.value = this.value.replace(/[^0-9]/g, '')" value="{{ old('no_ba_cacah_nomor', explode('/', $pencacahan->no_ba_cacah)[0]) }}">
                            </div>
                            <input type="hidden" name="no_ba_cacah" id="no_ba_cacah" value="{{ old('no_ba_cacah', $pencacahan->no_ba_cacah) }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="tanggal_ba_cacah" class="form-label">Tanggal BA Cacah</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="cil-calendar"></i></span>
                                <input type="date" class="form-control" id="tanggal_ba_cacah" name="tanggal_ba_cacah" value="{{ old('tanggal_ba_cacah', $pencacahan->tanggal_ba_cacah) }}" required>
                            </div>
                        </div>
                    </div>
                </div>

                <hr>
                <h5 class="mb-3">Detail Cacah</h5>
                <div class="row">
                     <div class="col-md-6">
                        <div class="mb-3">
                            <label for="lokasi_cacah" class="form-label">Lokasi Cacah</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="cil-magnifying-glass"></i></span>
                                <input type="text" class="form-control" id="lokasi_cacah" name="lokasi_cacah" value="{{ old('lokasi_cacah', $pencacahan->lokasi_cacah) }}">
                            </div>
                        </div>
                    </div>
                </div>

                <hr>
                <h5 class="mb-3">Petugas</h5>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="id_petugas_1" class="form-label">Petugas 1</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="cil-user"></i></span>
                                <select id="id_petugas_1" class="form-select" name="id_petugas_1" required>
                                    <option value="" disabled>Pilih Petugas 1</option>
                                    @foreach($petugasData as $petugas)
                                        <option value="{{ $petugas->id }}" {{ old('id_petugas_1', $pencacahan->id_petugas_1) == $petugas->id ? 'selected' : '' }}>{{ $petugas->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="id_petugas_2" class="form-label">Petugas 2</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="cil-user"></i></span>
                                 <select id="id_petugas_2" class="form-select" name="id_petugas_2">
                                    <option value="" disabled>Pilih Petugas 2</option>
                                    @foreach($petugasData as $petugas)
                                        <option value="{{ $petugas->id }}" {{ old('id_petugas_2', $pencacahan->id_petugas_2) == $petugas->id ? 'selected' : '' }}>{{ $petugas->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer text-end">
                    <button type="submit" class="btn btn-primary"><i class="cil-save"></i> Simpan</button>
                    <a href="{{ route('pencacahan.index') }}" class="btn btn-secondary"><i class="cil-x-circle"></i> Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const tglInput = document.getElementById('tanggal_ba_cacah');
        const form = document.getElementById('editPencacahanForm');
        const noBaCacahNomorInput = document.getElementById('no_ba_cacah_nomor');
        const noBaCacahHiddenInput = document.getElementById('no_ba_cacah');

        form.addEventListener('submit', function(e) {
            const nomor = noBaCacahNomorInput.value;
            const date = new Date(tglInput.value);
            const year = date.getFullYear();
            
            if (nomor && !isNaN(year)) {
                noBaCacahHiddenInput.value = `BA-${nomor}/CACAH/KBC.010202/${year}`;
            } else {
                noBaCacahHiddenInput.value = ''; 
            }
        });
    });
</script>
@endpush
