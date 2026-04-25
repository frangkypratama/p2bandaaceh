<div class="mb-3">
    <label class="form-label">Uraian</label>
    <input type="text" class="form-control" data-field="uraian" placeholder="Contoh: Bawang Merah Brebes, Rokok, dll" value="{{ old('uraian', $data['uraian'] ?? '') }}">
</div>
<div class="mb-3">
    <label class="form-label">Merek</label>
    <input type="text" class="form-control" data-field="merek" placeholder="Contoh: Gudang Garam, Dji Sam Soe, dll" value="{{ old('merek', $data['merek'] ?? '') }}">
</div>
<div class="mb-3">
    <label class="form-label">Kondisi Barang</label>
    <select class="form-select" data-field="kondisi_barang">
        <option value="" selected disabled>Pilih Kondisi</option>
        <option value="Baru" {{ old('kondisi_barang', $data['kondisi_barang'] ?? '') == 'Baru' ? 'selected' : '' }}>Baru</option>
        <option value="Bukan Baru" {{ old('kondisi_barang', $data['kondisi_barang'] ?? '') == 'Bukan Baru' ? 'selected' : '' }}>Bukan Baru</option>
    </select>
</div>
<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Jumlah</label>
        <input type="number" class="form-control" data-field="jumlah" min="1" placeholder="0" value="{{ old('jumlah', $data['jumlah'] ?? '') }}">
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Satuan</label>
        <select class="form-select" data-field="id_satuan">
            <option value="" selected disabled>Pilih Satuan</option>
            @foreach($satuanData as $satuan)
                <option value="{{ $satuan->id }}" {{ old('id_satuan', $data['id_satuan'] ?? '') == $satuan->id ? 'selected' : '' }}>{{ $satuan->nama_satuan }}</option>
            @endforeach
        </select>
    </div>
</div>
