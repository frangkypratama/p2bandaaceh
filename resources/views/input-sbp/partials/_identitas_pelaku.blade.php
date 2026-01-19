{{-- Data Identitas --}}
<div class="col-md-12">
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="card-title mb-0">2. Data Identitas Pelaku</h5>
        </div>
        <div class="card-body">
            <div class="mb-3">
                <label for="nama_pelaku" class="form-label">Nama Pelaku</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="cil-user"></i></span>
                    <input id="nama_pelaku" type="text" class="form-control" name="nama_pelaku" value="{{ old('nama_pelaku') }}" placeholder="Nama lengkap pelaku" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="jenis_identitas" class="form-label">Jenis Identitas</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="cil-credit-card"></i></span>
                            <select id="jenis_identitas" class="form-select" name="jenis_identitas" required>
                                <option selected disabled value="">Pilih Jenis Identitas...</option>
                                <option value="Paspor" {{ old('jenis_identitas') == 'Paspor' ? 'selected' : '' }}>Paspor</option>
                                <option value="KTP" {{ old('jenis_identitas') == 'KTP' ? 'selected' : '' }}>KTP</option>
                                <option value="SIM" {{ old('jenis_identitas') == 'SIM' ? 'selected' : '' }}>SIM</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="nomor_identitas" class="form-label">Nomor Identitas</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="cil-info"></i></span>
                            <input id="nomor_identitas" type="text" class="form-control" name="nomor_identitas" value="{{ old('nomor_identitas') }}" placeholder="Nomor identitas pelaku" required>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
