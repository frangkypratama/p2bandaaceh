{{-- Petugas --}}
<div class="col-md-12">
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="card-title mb-0">5. Petugas yang Bertugas</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="id_petugas_1" class="form-label">Petugas 1</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="cil-user-follow"></i></span>
                            <select id="id_petugas_1" class="form-select" name="id_petugas_1" required>
                                <option selected disabled value="">Pilih Petugas 1...</option>
                                @foreach($petugasData as $petugas)
                                    <option value="{{ $petugas->id }}" {{ old('id_petugas_1') == $petugas->id ? 'selected' : '' }}>{{ $petugas->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="id_petugas_2" class="form-label">Petugas 2</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="cil-user-follow"></i></span>
                             <select id="id_petugas_2" class="form-select" name="id_petugas_2" required>
                                <option selected disabled value="">Pilih Petugas 2...</option>
                                @foreach($petugasData as $petugas)
                                    <option value="{{ $petugas->id }}" {{ old('id_petugas_2') == $petugas->id ? 'selected' : '' }}>{{ $petugas->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
