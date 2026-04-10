<div class="mb-3">
    <label class="form-label">Uraian / Nama Barang</label>
    <input type="text" class="form-control" data-field="merek" placeholder="Contoh: Bawang Merah Brebes, Nike Air Jordan, dll" value="{{ old('merek', $data['merek'] ?? '') }}">
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
