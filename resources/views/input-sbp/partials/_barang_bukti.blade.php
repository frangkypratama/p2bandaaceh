{{-- Informasi Barang Hasil Penindakan --}}
<div class="col-md-12">
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="card-title mb-0">4. Informasi Barang Hasil Penindakan</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="mb-3">
                        <label for="jenis_barang" class="form-label">Jenis Barang</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="cil-layers"></i></span>
                            <input id="jenis_barang" type="text" class="form-control" name="jenis_barang" value="{{ old('jenis_barang') }}" placeholder="Contoh: Hasil Tembakau" required>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="jumlah_barang" class="form-label">Jumlah Barang</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="cil-calculator"></i></span>
                            <input id="jumlah_barang" type="number" class="form-control" name="jumlah_barang" value="{{ old('jumlah_barang') }}" placeholder="0" required>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="jenis_satuan" class="form-label">Jenis Satuan</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="cil-puzzle"></i></span>
                            <select id="jenis_satuan" class="form-select" name="jenis_satuan" required>
                                <option selected disabled value="">Pilih Satuan...</option>
                                <option value="Pcs" {{ old('jenis_satuan') == 'Pcs' ? 'selected' : '' }}>Pcs</option>
                                <option value="Pkg" {{ old('jenis_satuan') == 'Pkg' ? 'selected' : '' }}>Package</option>
                                <option value="Unit" {{ old('jenis_satuan') == 'Unit' ? 'selected' : '' }}>Unit</option>
                                <option value="Batang" {{ old('jenis_satuan') == 'Batang' ? 'selected' : '' }}>Batang</option>
                                <option value="Botol" {{ old('jenis_satuan') == 'Botol' ? 'selected' : '' }}>Botol</option>
                                <option value="Gram" {{ old('jenis_satuan') == 'Gram' ? 'selected' : '' }}>Gram</option>
                                <option value="Kilogram" {{ old('jenis_satuan') == 'Kilogram' ? 'selected' : '' }}>Kilogram</option>
                                <option value="Buah" {{ old('jenis_satuan') == 'Buah' ? 'selected' : '' }}>Buah</option>
                                <option value="Bungkus" {{ old('jenis_satuan') == 'Bungkus' ? 'selected' : '' }}>Bungkus</option>
                                <option value="Kotak" {{ old('jenis_satuan') == 'Kotak' ? 'selected' : '' }}>Kotak</option>
                                <option value="Liter" {{ old('jenis_satuan') == 'Liter' ? 'selected' : '' }}>Liter</option>
                                <option value="Mililiter" {{ old('jenis_satuan') == 'Mililiter' ? 'selected' : '' }}>Mililiter</option>
                                <option value="Karton" {{ old('jenis_satuan') == 'Karton' ? 'selected' : '' }}>Karton</option>
                                <option value="Set" {{ old('jenis_satuan') == 'Set' ? 'selected' : '' }}>Set</option>
                                <option value="Pasang" {{ old('jenis_satuan') == 'Pasang' ? 'selected' : '' }}>Pasang</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <label for="uraian_barang" class="form-label">Uraian Barang</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="cil-description"></i></span>
                    <textarea id="uraian_barang" class="form-control" name="uraian_barang" rows="3" placeholder="Jelaskan secara detail mengenai barang hasil penindakan" required>{{ old('uraian_barang') }}</textarea>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" name="flag_bast" id="flag_bast" value="1" {{ old('flag_bast') ? 'checked' : '' }}>
                        <label class="form-check-label" for="flag_bast">
                            Apakah diserah terimakan ke Instansi Terkait?
                        </label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" name="flag_ba_musnah" id="flag_ba_musnah" value="1" {{ old('flag_ba_musnah') ? 'checked' : '' }}>
                        <label class="form-check-label" for="flag_ba_musnah">
                            Apakah barang dimusnahkan?
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
