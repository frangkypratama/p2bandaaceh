<div class="col-md-12">
    <div class="card h-100 border-light shadow-sm">
        <div class="card-header bg-light">
            <h5 class="card-title mb-0 d-flex align-items-center"><i class="cil-people me-2"></i>Petugas yang Bertugas</h5>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6">
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
                <div class="col-md-6">
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
