<div class="col-md-12">
    <div class="card h-100 border-light shadow-sm">
        <div class="card-header bg-light">
            <h5 class="card-title mb-0 d-flex align-items-center"><i class="cil-magnifying-glass me-2"></i>Detail Penindakan</h5>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="lokasi_penindakan" class="form-label">Lokasi Penindakan</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="cil-location-pin"></i></span>
                        <input id="lokasi_penindakan" type="text" class="form-control" name="lokasi_penindakan" value="{{ old('lokasi_penindakan') }}" placeholder="Contoh: Bandara Internasional Sultan Iskandar Muda" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="waktu_penindakan" class="form-label">Waktu Penindakan</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="cil-clock"></i></span>
                        <input id="waktu_penindakan" type="time" class="form-control" name="waktu_penindakan" value="{{ old('waktu_penindakan') }}" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="kota" class="form-label">Kota</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="cil-building"></i></span>
                        <select id="kota" class="form-select" name="kota">
                            <option selected disabled value="">Pilih Kota...</option>
                            <option value="Banda Aceh" {{ old('kota') == 'Banda Aceh' ? 'selected' : '' }}>Banda Aceh</option>
                            <option value="Aceh Besar" {{ old('kota') == 'Aceh Besar' ? 'selected' : '' }}>Aceh Besar</option>
                            <option value="Pidie" {{ old('kota') == 'Pidie' ? 'selected' : '' }}>Pidie</option>
                            <option value="Pidie Jaya" {{ old('kota') == 'Pidie Jaya' ? 'selected' : '' }}>Pidie Jaya</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="kecamatan" class="form-label">Kecamatan</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="cil-map"></i></span>
                        <input id="kecamatan" type="text" class="form-control" name="kecamatan" value="{{ old('kecamatan') }}" placeholder="Contoh: Jaya Baru">
                    </div>
                </div>
                <div class="col-12">
                    <label for="alasan_penindakan" class="form-label">Alasan Penindakan / Dugaan Pelanggaran</label>
                    <div class="input-group">
                        <button class="btn btn-outline-secondary" type="button" data-coreui-toggle="modal" data-coreui-target="#pelanggaranModal">
                            <i class="cil-list"></i> Pilih dari Daftar
                        </button>
                        <textarea id="alasan_penindakan" class="form-control" name="alasan_penindakan" rows="3" placeholder="Jelaskan secara singkat alasan penindakan atau dugaan pelanggaran. Anda juga bisa memilih dari daftar." required>{{ old('alasan_penindakan') }}</textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
