<div class="col-md-12">
    <div class="card h-100 border-light shadow-sm">
        <div class="card-header bg-light">
            <h5 class="card-title mb-0 d-flex align-items-center"><i class="cil-briefcase me-2"></i>Informasi Barang Hasil Penindakan</h5>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="jenis_barang" class="form-label">Jenis Barang</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="cil-layers"></i></span>
                        <select id="jenis_barang" class="form-select" name="jenis_barang" required>
                            <option selected disabled value="">Silahkan Pilih Jenis Barang...</option>
                            @foreach($jenisBarang as $barang)
                                <option value="{{ $barang->nama_barang }}" {{ old('jenis_barang') == $barang->nama_barang ? 'selected' : '' }}>
                                    {{ $barang->nomor_urut }}. {{ $barang->nama_barang }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="kondisi_barang" class="form-label">Kondisi Barang</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="cil-3d"></i></span>
                        <select id="kondisi_barang" class="form-select" name="kondisi_barang" required>
                            <option selected disabled value="">Pilih Kondisi...</option>
                            <option value="Baru" {{ old('kondisi_barang') == 'Baru' ? 'selected' : '' }}>Baru</option>
                            <option value="Bukan Baru" {{ old('kondisi_barang') == 'Bukan Baru' ? 'selected' : '' }}>Bukan Baru</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="jumlah_barang" class="form-label">Jumlah Barang</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="cil-calculator"></i></span>
                        <input id="jumlah_barang" type="number" class="form-control" name="jumlah_barang" value="{{ old('jumlah_barang') }}" placeholder="0" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="jenis_satuan" class="form-label">Jenis Satuan</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="cil-puzzle"></i></span>
                        <select id="jenis_satuan" class="form-select" name="jenis_satuan" required>
                            <option selected disabled value="">Pilih Satuan...</option>
                            @foreach($refSatuanData as $satuan)
                                <option value="{{ $satuan->nama_satuan }}" {{ old('jenis_satuan') == $satuan->nama_satuan ? 'selected' : '' }}>{{ $satuan->nama_satuan }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-12">
                    <label for="uraian_barang" class="form-label">Uraian Barang</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="cil-description"></i></span>
                        <textarea id="uraian_barang" class="form-control" name="uraian_barang" rows="3" placeholder="Jelaskan secara detail mengenai barang hasil penindakan" required>{{ old('uraian_barang') }}</textarea>
                    </div>
                </div>
                <div class="col-12">
                    <div class="border rounded p-3 bg-white">
                         <label class="form-label fw-bold">Opsi Tambahan:</label>
                        <div class="form-check form-switch mb-2">
                            <input class="form-check-input" type="checkbox" role="switch" name="flag_bast" id="flag_bast" value="1" {{ old('flag_bast') ? 'checked' : '' }}>
                            <label class="form-check-label" for="flag_bast">Serah Terima ke Instansi Terkait?</label>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch" name="flag_ba_musnah" id="flag_ba_musnah" value="1" {{ old('flag_ba_musnah') ? 'checked' : '' }}>
                            <label class="form-check-label" for="flag_ba_musnah">Barang akan dimusnahkan?</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
