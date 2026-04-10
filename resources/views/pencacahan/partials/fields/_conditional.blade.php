@switch($nama_barang)

    @case('Hasil Tembakau')
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Merek</label>
                <input type="text" class="form-control" data-field="merek" placeholder="Contoh: Manchester" value="{{ old('merek', $data['merek'] ?? '') }}">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Jenis Tarif Cukai</label>
                <select class="form-select" data-field="id_ref_tarif_cukai">
                    <option value="" selected disabled>Pilih Jenis Tarif</option>
                    @foreach($tarifCukaiData as $tarif)
                        @php
                            $tarifFormatted = number_format($tarif->tarif, 0, ',', '.');
                            $label = $tarif->jenis;
                            if ($tarif->golongan) {
                                $label .= ($tarif->golongan === 'Tanpa Golongan') ? ' - Tanpa Golongan' : " - Golongan {$tarif->golongan}";
                            }
                            $label .= " - Rp {$tarifFormatted}";
                        @endphp
                        <option value="{{ $tarif->id }}" {{ old('id_ref_tarif_cukai', $data['id_ref_tarif_cukai'] ?? '') == $tarif->id ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 mb-3">
                <label class="form-label">Jumlah Bungkus</label>
                <input type="number" class="form-control" data-field="jumlah_bungkus" min="1" placeholder="10" value="{{ old('jumlah_bungkus', $data['jumlah_bungkus'] ?? '') }}">
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">Jumlah Batang/Bks</label>
                <input type="number" class="form-control" data-field="jumlah_batang" min="1" placeholder="20" value="{{ old('jumlah_batang', $data['jumlah_batang'] ?? '') }}">
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">Total Batang</label>
                <input type="number" class="form-control" data-field="total_batang" readonly value="{{ old('total_batang', ($data['jumlah_bungkus'] ?? 0) * ($data['jumlah_batang'] ?? 0)) }}">
            </div>
        </div>
        @break

    @case('Handphone, Gadget, Part & Accesories')
        <div class="mb-3">
            <label class="form-label">Merek</label>
            <input type="text" class="form-control" data-field="merek" placeholder="Contoh: iPhone, Samsung" value="{{ old('merek', $data['merek'] ?? '') }}">
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">IMEI 1</label>
                <input type="text" class="form-control" data-field="imei1" placeholder="15 digit" maxlength="15" oninput="this.value=this.value.replace(/[^0-9]/g,'')" value="{{ old('imei1', $data['imei1'] ?? '') }}">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">IMEI 2 (Opsional)</label>
                <input type="text" class="form-control" data-field="imei2" placeholder="15 digit" maxlength="15" oninput="this.value=this.value.replace(/[^0-9]/g,'')" value="{{ old('imei2', $data['imei2'] ?? '') }}">
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">Warna</label>
            <input type="text" class="form-control" data-field="warna" placeholder="Contoh: Hitam, Putih" value="{{ old('warna', $data['warna'] ?? '') }}">
        </div>
        @break

    @case('Elektronik')
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Jenis Elektronik</label>
                <input type="text" class="form-control" data-field="jenis_elektronik" placeholder="Contoh: TV, Kulkas" value="{{ old('jenis_elektronik', $data['jenis_elektronik'] ?? '') }}">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Merek</label>
                <input type="text" class="form-control" data-field="merek" placeholder="Contoh: Samsung" value="{{ old('merek', $data['merek'] ?? '') }}">
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Model / No. Seri</label>
                <input type="text" class="form-control" data-field="model_seri" placeholder="Contoh: UA43AU7000" value="{{ old('model_seri', $data['model_seri'] ?? '') }}">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Ukuran</label>
                <input type="text" class="form-control" data-field="ukuran" placeholder="Contoh: 43 inch" value="{{ old('ukuran', $data['ukuran'] ?? '') }}">
            </div>
        </div>
        @break

    @case('Kendaraan Darat (Bermotor/Tidak), Part & Accessories')
        <div class="row">
            <div class="col-md-4 mb-3">
                <label class="form-label">Jenis Kendaraan</label>
                <select class="form-select" data-field="jenis_kendaraan">
                    <option value="" {{ old('jenis_kendaraan', $data['jenis_kendaraan'] ?? '') == '' ? 'selected' : '' }}>Pilih Jenis</option>
                    <option value="Mobil" {{ old('jenis_kendaraan', $data['jenis_kendaraan'] ?? '') == 'Mobil' ? 'selected' : '' }}>Mobil</option>
                    <option value="Motor" {{ old('jenis_kendaraan', $data['jenis_kendaraan'] ?? '') == 'Motor' ? 'selected' : '' }}>Motor</option>
                    <option value="Sepeda" {{ old('jenis_kendaraan', $data['jenis_kendaraan'] ?? '') == 'Sepeda' ? 'selected' : '' }}>Sepeda</option>
                    <option value="Lainnya" {{ old('jenis_kendaraan', $data['jenis_kendaraan'] ?? '') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                </select>
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">Merek</label>
                <input type="text" class="form-control" data-field="merek" placeholder="Contoh: Toyota" value="{{ old('merek', $data['merek'] ?? '') }}">
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">Tipe</label>
                <input type="text" class="form-control" data-field="tipe" placeholder="Contoh: Avanza" value="{{ old('tipe', $data['tipe'] ?? '') }}">
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Nomor Rangka</label>
                <input type="text" class="form-control" data-field="nomor_rangka" value="{{ old('nomor_rangka', $data['nomor_rangka'] ?? '') }}">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Nomor Mesin</label>
                <input type="text" class="form-control" data-field="nomor_mesin" value="{{ old('nomor_mesin', $data['nomor_mesin'] ?? '') }}">
            </div>
        </div>
        @break

    @case('Kendaraan Air (Bermotor/Tidak), Part & Accessories')
        <div class="row">
            <div class="col-md-4 mb-3">
                <label class="form-label">Jenis</label>
                <select class="form-select" data-field="jenis_kendaraan">
                    <option value="" {{ old('jenis_kendaraan', $data['jenis_kendaraan'] ?? '') == '' ? 'selected' : '' }}>Pilih Jenis</option>
                    <option value="Kapal" {{ old('jenis_kendaraan', $data['jenis_kendaraan'] ?? '') == 'Kapal' ? 'selected' : '' }}>Kapal</option>
                    <option value="Perahu" {{ old('jenis_kendaraan', $data['jenis_kendaraan'] ?? '') == 'Perahu' ? 'selected' : '' }}>Perahu</option>
                    <option value="Speedboat" {{ old('jenis_kendaraan', $data['jenis_kendaraan'] ?? '') == 'Speedboat' ? 'selected' : '' }}>Speedboat</option>
                    <option value="Lainnya" {{ old('jenis_kendaraan', $data['jenis_kendaraan'] ?? '') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                </select>
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">Merek</label>
                <input type="text" class="form-control" data-field="merek" value="{{ old('merek', $data['merek'] ?? '') }}">
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">Tipe</label>
                <input type="text" class="form-control" data-field="tipe" value="{{ old('tipe', $data['tipe'] ?? '') }}">
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Nomor Lambung (Hull)</label>
                <input type="text" class="form-control" data-field="nomor_rangka" value="{{ old('nomor_rangka', $data['nomor_rangka'] ?? '') }}">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Nomor Mesin</label>
                <input type="text" class="form-control" data-field="nomor_mesin" value="{{ old('nomor_mesin', $data['nomor_mesin'] ?? '') }}">
            </div>
        </div>
        @break

    @case('Kendaraan Udara (Bermotor/Tidak), Part & Accessories')
        <div class="row">
            <div class="col-md-4 mb-3">
                <label class="form-label">Jenis</label>
                <select class="form-select" data-field="jenis_kendaraan">
                    <option value="" {{ old('jenis_kendaraan', $data['jenis_kendaraan'] ?? '') == '' ? 'selected' : '' }}>Pilih Jenis</option>
                    <option value="Pesawat" {{ old('jenis_kendaraan', $data['jenis_kendaraan'] ?? '') == 'Pesawat' ? 'selected' : '' }}>Pesawat</option>
                    <option value="Helikopter" {{ old('jenis_kendaraan', $data['jenis_kendaraan'] ?? '') == 'Helikopter' ? 'selected' : '' }}>Helikopter</option>
                    <option value="Drone" {{ old('jenis_kendaraan', $data['jenis_kendaraan'] ?? '') == 'Drone' ? 'selected' : '' }}>Drone</option>
                    <option value="Lainnya" {{ old('jenis_kendaraan', $data['jenis_kendaraan'] ?? '') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                </select>
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">Merek</label>
                <input type="text" class="form-control" data-field="merek" value="{{ old('merek', $data['merek'] ?? '') }}">
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">Tipe</label>
                <input type="text" class="form-control" data-field="tipe" value="{{ old('tipe', $data['tipe'] ?? '') }}">
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Nomor Registrasi</label>
                <input type="text" class="form-control" data-field="nomor_rangka" value="{{ old('nomor_rangka', $data['nomor_rangka'] ?? '') }}">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Nomor Mesin</label>
                <input type="text" class="form-control" data-field="nomor_mesin" value="{{ old('nomor_mesin', $data['nomor_mesin'] ?? '') }}">
            </div>
        </div>
        @break

    @case('Minuman Mengandung Etil Alkohol')
        <div class="mb-3">
            <label class="form-label">Merek</label>
            <input type="text" class="form-control" data-field="merek" placeholder="Contoh: Johnnie Walker" value="{{ old('merek', $data['merek'] ?? '') }}">
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Kadar Alkohol (%)</label>
                <input type="number" class="form-control" data-field="kadar_alkohol" step="0.1" min="0" placeholder="40" value="{{ old('kadar_alkohol', $data['kadar_alkohol'] ?? '') }}">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Volume (ml)</label>
                <input type="number" class="form-control" data-field="volume" min="0" placeholder="750" value="{{ old('volume', $data['volume'] ?? '') }}">
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Jumlah Botol</label>
                <input type="number" class="form-control" data-field="jumlah_botol" min="1" placeholder="12" value="{{ old('jumlah_botol', $data['jumlah_botol'] ?? '') }}">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Jenis MMEA</label>
                <select class="form-select" data-field="jenis_mmea">
                    <option value="" {{ old('jenis_mmea', $data['jenis_mmea'] ?? '') == '' ? 'selected' : '' }}>Pilih Jenis</option>
                    <option value="Bir" {{ old('jenis_mmea', $data['jenis_mmea'] ?? '') == 'Bir' ? 'selected' : '' }}>Bir</option>
                    <option value="Anggur" {{ old('jenis_mmea', $data['jenis_mmea'] ?? '') == 'Anggur' ? 'selected' : '' }}>Anggur</option>
                    <option value="Spirit" {{ old('jenis_mmea', $data['jenis_mmea'] ?? '') == 'Spirit' ? 'selected' : '' }}>Spirit</option>
                    <option value="Lainnya" {{ old('jenis_mmea', $data['jenis_mmea'] ?? '') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                </select>
            </div>
        </div>
        @break

    @case('Etil Alkohol')
        <div class="row">
            <div class="col-md-4 mb-3">
                <label class="form-label">Kadar (%)</label>
                <input type="number" class="form-control" data-field="kadar_alkohol" step="0.1" min="0" max="100" value="{{ old('kadar_alkohol', $data['kadar_alkohol'] ?? '') }}">
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">Volume (liter)</label>
                <input type="number" class="form-control" data-field="volume" min="0" step="0.1" value="{{ old('volume', $data['volume'] ?? '') }}">
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">Jumlah Wadah</label>
                <input type="number" class="form-control" data-field="jumlah_botol" min="1" value="{{ old('jumlah_botol', $data['jumlah_botol'] ?? '') }}">
            </div>
        </div>
        @break

    @case('Pita Cukai')
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Jenis HT</label>
                <select class="form-select" data-field="jenis_rokok">
                    <option value="" {{ old('jenis_rokok', $data['jenis_rokok'] ?? '') == '' ? 'selected' : '' }}>Pilih Jenis</option>
                    <option value="SKM" {{ old('jenis_rokok', $data['jenis_rokok'] ?? '') == 'SKM' ? 'selected' : '' }}>SKM</option>
                    <option value="SPM" {{ old('jenis_rokok', $data['jenis_rokok'] ?? '') == 'SPM' ? 'selected' : '' }}>SPM</option>
                    <option value="SKT" {{ old('jenis_rokok', $data['jenis_rokok'] ?? '') == 'SKT' ? 'selected' : '' }}>SKT</option>
                    <option value="SPT" {{ old('jenis_rokok', $data['jenis_rokok'] ?? '') == 'SPT' ? 'selected' : '' }}>SPT</option>
                    <option value="SKTF" {{ old('jenis_rokok', $data['jenis_rokok'] ?? '') == 'SKTF' ? 'selected' : '' }}>SKTF</option>
                    <option value="SPTF" {{ old('jenis_rokok', $data['jenis_rokok'] ?? '') == 'SPTF' ? 'selected' : '' }}>SPTF</option>
                    <option value="TIS" {{ old('jenis_rokok', $data['jenis_rokok'] ?? '') == 'TIS' ? 'selected' : '' }}>TIS</option>
                    <option value="KLM" {{ old('jenis_rokok', $data['jenis_rokok'] ?? '') == 'KLM' ? 'selected' : '' }}>KLM</option>
                    <option value="KLB" {{ old('jenis_rokok', $data['jenis_rokok'] ?? '') == 'KLB' ? 'selected' : '' }}>KLB</option>
                    <option value="CRT" {{ old('jenis_rokok', $data['jenis_rokok'] ?? '') == 'CRT' ? 'selected' : '' }}>CRT</option>
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Seri Pita</label>
                <input type="text" class="form-control" data-field="model_seri" placeholder="Seri pita cukai" value="{{ old('model_seri', $data['model_seri'] ?? '') }}">
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Tahun</label>
                <input type="number" class="form-control" data-field="tahun" min="2000" max="2099" placeholder="2025" value="{{ old('tahun', $data['tahun'] ?? '') }}">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Jumlah Keping</label>
                <input type="number" class="form-control" data-field="jumlah" min="1" value="{{ old('jumlah', $data['jumlah'] ?? '') }}">
            </div>
        </div>
        @break

    @case('Narkotika, Psikotropika, dan Prekursor')
        <div class="mb-3">
            <label class="form-label">Jenis Zat</label>
            <select class="form-select" data-field="jenis_zat">
                <option value="" {{ old('jenis_zat', $data['jenis_zat'] ?? '') == '' ? 'selected' : '' }}>Pilih Jenis</option>
                <option value="Narkotika" {{ old('jenis_zat', $data['jenis_zat'] ?? '') == 'Narkotika' ? 'selected' : '' }}>Narkotika</option>
                <option value="Psikotropika" {{ old('jenis_zat', $data['jenis_zat'] ?? '') == 'Psikotropika' ? 'selected' : '' }}>Psikotropika</option>
                <option value="Prekursor" {{ old('jenis_zat', $data['jenis_zat'] ?? '') == 'Prekursor' ? 'selected' : '' }}>Prekursor</option>
            </select>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Nama Zat</label>
                <input type="text" class="form-control" data-field="nama_zat" placeholder="Contoh: Metamfetamin" value="{{ old('nama_zat', $data['nama_zat'] ?? '') }}">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Bentuk Sediaan</label>
                <input type="text" class="form-control" data-field="bentuk_sediaan" placeholder="Contoh: Kristal, Tablet" value="{{ old('bentuk_sediaan', $data['bentuk_sediaan'] ?? '') }}">
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Berat (gram)</label>
                <input type="number" class="form-control" data-field="berat" step="0.01" min="0" value="{{ old('berat', $data['berat'] ?? '') }}">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Jumlah Kemasan</label>
                <input type="number" class="form-control" data-field="jumlah_kemasan" min="1" value="{{ old('jumlah_kemasan', $data['jumlah_kemasan'] ?? '') }}">
            </div>
        </div>
        @break

    @case('Senjata Api, Airgun, Airsoftgun & Part')
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Jenis Senjata</label>
                <select class="form-select" data-field="jenis_kendaraan">
                    <option value="" {{ old('jenis_kendaraan', $data['jenis_kendaraan'] ?? '') == '' ? 'selected' : '' }}>Pilih Jenis</option>
                    <option value="Senjata Api" {{ old('jenis_kendaraan', $data['jenis_kendaraan'] ?? '') == 'Senjata Api' ? 'selected' : '' }}>Senjata Api</option>
                    <option value="Airgun" {{ old('jenis_kendaraan', $data['jenis_kendaraan'] ?? '') == 'Airgun' ? 'selected' : '' }}>Airgun</option>
                    <option value="Airsoftgun" {{ old('jenis_kendaraan', $data['jenis_kendaraan'] ?? '') == 'Airsoftgun' ? 'selected' : '' }}>Airsoftgun</option>
                    <option value="Part/Amunisi" {{ old('jenis_kendaraan', $data['jenis_kendaraan'] ?? '') == 'Part/Amunisi' ? 'selected' : '' }}>Part/Amunisi</option>
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Merek</label>
                <input type="text" class="form-control" data-field="merek" value="{{ old('merek', $data['merek'] ?? '') }}">
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Kaliber</label>
                <input type="text" class="form-control" data-field="ukuran" placeholder="Contoh: 9mm, .45 ACP" value="{{ old('ukuran', $data['ukuran'] ?? '') }}">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Nomor Seri</label>
                <input type="text" class="form-control" data-field="model_seri" value="{{ old('model_seri', $data['model_seri'] ?? '') }}">
            </div>
        </div>
        @break

    @case('Uang Tunai /Bni')
        <div class="row">
            <div class="col-md-4 mb-3">
                <label class="form-label">Mata Uang</label>
                <select class="form-select" data-field="jenis_mmea">
                    <option value="" {{ old('jenis_mmea', $data['jenis_mmea'] ?? '') == '' ? 'selected' : '' }}>Pilih</option>
                    <option value="IDR" {{ old('jenis_mmea', $data['jenis_mmea'] ?? '') == 'IDR' ? 'selected' : '' }}>IDR - Rupiah</option>
                    <option value="USD" {{ old('jenis_mmea', $data['jenis_mmea'] ?? '') == 'USD' ? 'selected' : '' }}>USD - Dollar AS</option>
                    <option value="SGD" {{ old('jenis_mmea', $data['jenis_mmea'] ?? '') == 'SGD' ? 'selected' : '' }}>SGD - Dollar Singapura</option>
                    <option value="MYR" {{ old('jenis_mmea', $data['jenis_mmea'] ?? '') == 'MYR' ? 'selected' : '' }}>MYR - Ringgit</option>
                    <option value="Lainnya" {{ old('jenis_mmea', $data['jenis_mmea'] ?? '') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                </select>
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">Nominal</label>
                <input type="number" class="form-control" data-field="volume" min="0" value="{{ old('volume', $data['volume'] ?? '') }}">
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">Jumlah Lembar/Keping</label>
                <input type="number" class="form-control" data-field="jumlah" min="1" value="{{ old('jumlah', $data['jumlah'] ?? '') }}">
            </div>
        </div>
        @break

    @case('CITES (Flora & Fauna)')
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Nama Ilmiah</label>
                <input type="text" class="form-control" data-field="nama_zat" placeholder="Contoh: Chelonia mydas" value="{{ old('nama_zat', $data['nama_zat'] ?? '') }}">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Nama Umum</label>
                <input type="text" class="form-control" data-field="merek" placeholder="Contoh: Penyu Hijau" value="{{ old('merek', $data['merek'] ?? '') }}">
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Appendix CITES</label>
                <select class="form-select" data-field="jenis_zat">
                    <option value="" {{ old('jenis_zat', $data['jenis_zat'] ?? '') == '' ? 'selected' : '' }}>Pilih Appendix</option>
                    <option value="Appendix I" {{ old('jenis_zat', $data['jenis_zat'] ?? '') == 'Appendix I' ? 'selected' : '' }}>Appendix I</option>
                    <option value="Appendix II" {{ old('jenis_zat', $data['jenis_zat'] ?? '') == 'Appendix II' ? 'selected' : '' }}>Appendix II</option>
                    <option value="Appendix III" {{ old('jenis_zat', $data['jenis_zat'] ?? '') == 'Appendix III' ? 'selected' : '' }}>Appendix III</option>
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Kondisi</label>
                <select class="form-select" data-field="bentuk_sediaan">
                    <option value="" {{ old('bentuk_sediaan', $data['bentuk_sediaan'] ?? '') == '' ? 'selected' : '' }}>Pilih Kondisi</option>
                    <option value="Hidup" {{ old('bentuk_sediaan', $data['bentuk_sediaan'] ?? '') == 'Hidup' ? 'selected' : '' }}>Hidup</option>
                    <option value="Mati" {{ old('bentuk_sediaan', $data['bentuk_sediaan'] ?? '') == 'Mati' ? 'selected' : '' }}>Mati</option>
                    <option value="Olahan" {{ old('bentuk_sediaan', $data['bentuk_sediaan'] ?? '') == 'Olahan' ? 'selected' : '' }}>Olahan</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Jumlah</label>
                <input type="number" class="form-control" data-field="jumlah" min="1" value="{{ old('jumlah', $data['jumlah'] ?? '') }}">
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
        @break

    @case('Logam Mulia Dan Perhiasan')
        <div class="row">
            <div class="col-md-4 mb-3">
                <label class="form-label">Jenis</label>
                <select class="form-select" data-field="jenis_elektronik">
                    <option value="" {{ old('jenis_elektronik', $data['jenis_elektronik'] ?? '') == '' ? 'selected' : '' }}>Pilih Jenis</option>
                    <option value="Emas" {{ old('jenis_elektronik', $data['jenis_elektronik'] ?? '') == 'Emas' ? 'selected' : '' }}>Emas</option>
                    <option value="Perak" {{ old('jenis_elektronik', $data['jenis_elektronik'] ?? '') == 'Perak' ? 'selected' : '' }}>Perak</option>
                    <option value="Platinum" {{ old('jenis_elektronik', $data['jenis_elektronik'] ?? '') == 'Platinum' ? 'selected' : '' }}>Platinum</option>
                    <option value="Perhiasan" {{ old('jenis_elektronik', $data['jenis_elektronik'] ?? '') == 'Perhiasan' ? 'selected' : '' }}>Perhiasan</option>
                </select>
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">Kadar (karat/%)</label>
                <input type="text" class="form-control" data-field="ukuran" placeholder="Contoh: 24K, 99.9%" value="{{ old('ukuran', $data['ukuran'] ?? '') }}">
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">Berat (gram)</label>
                <input type="number" class="form-control" data-field="berat" step="0.01" min="0" value="{{ old('berat', $data['berat'] ?? '') }}">
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">Merek / Deskripsi</label>
            <input type="text" class="form-control" data-field="merek" placeholder="Contoh: Antam, Gelang emas" value="{{ old('merek', $data['merek'] ?? '') }}">
        </div>
        @break

    @case('Crude Oil (Minyak Mentah), Pelumas & BBM')
        <div class="row">
            <div class="col-md-4 mb-3">
                <label class="form-label">Jenis</label>
                <select class="form-select" data-field="jenis_elektronik">
                    <option value="" {{ old('jenis_elektronik', $data['jenis_elektronik'] ?? '') == '' ? 'selected' : '' }}>Pilih Jenis</option>
                    <option value="Solar" {{ old('jenis_elektronik', $data['jenis_elektronik'] ?? '') == 'Solar' ? 'selected' : '' }}>Solar</option>
                    <option value="Bensin" {{ old('jenis_elektronik', $data['jenis_elektronik'] ?? '') == 'Bensin' ? 'selected' : '' }}>Bensin</option>
                    <option value="Pelumas" {{ old('jenis_elektronik', $data['jenis_elektronik'] ?? '') == 'Pelumas' ? 'selected' : '' }}>Pelumas</option>
                    <option value="Minyak Mentah" {{ old('jenis_elektronik', $data['jenis_elektronik'] ?? '') == 'Minyak Mentah' ? 'selected' : '' }}>Minyak Mentah</option>
                    <option value="Lainnya" {{ old('jenis_elektronik', $data['jenis_elektronik'] ?? '') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                </select>
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">Volume (liter)</label>
                <input type="number" class="form-control" data-field="volume" min="0" step="0.1" value="{{ old('volume', $data['volume'] ?? '') }}">
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">Jumlah Wadah</label>
                <input type="number" class="form-control" data-field="jumlah_botol" min="1" value="{{ old('jumlah_botol', $data['jumlah_botol'] ?? '') }}">
            </div>
        </div>
        @break

    @case('Crude Palm Oil (Minyak Sawit)')
    @case('Produk Turunan CPO (Kec. Minyak Goreng)')
        <div class="row">
            <div class="col-md-4 mb-3">
                <label class="form-label">Volume (liter/kg)</label>
                <input type="number" class="form-control" data-field="volume" min="0" step="0.1" value="{{ old('volume', $data['volume'] ?? '') }}">
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">Jumlah Wadah</label>
                <input type="number" class="form-control" data-field="jumlah_botol" min="1" value="{{ old('jumlah_botol', $data['jumlah_botol'] ?? '') }}">
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">Satuan</label>
                <select class="form-select" data-field="id_satuan">
                    <option value="" selected disabled>Pilih Satuan</option>
                    @foreach($satuanData as $satuan)
                        <option value="{{ $satuan->id }}" {{ old('id_satuan', $data['id_satuan'] ?? '') == $satuan->id ? 'selected' : '' }}>{{ $satuan->nama_satuan }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        @break

    @case('Bahan Kimia')
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Nama Bahan</label>
                <input type="text" class="form-control" data-field="nama_zat" placeholder="Contoh: Asam Sulfat" value="{{ old('nama_zat', $data['nama_zat'] ?? '') }}">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Nomor CAS (Opsional)</label>
                <input type="text" class="form-control" data-field="model_seri" placeholder="Contoh: 7664-93-9" value="{{ old('model_seri', $data['model_seri'] ?? '') }}">
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 mb-3">
                <label class="form-label">Wujud</label>
                <select class="form-select" data-field="bentuk_sediaan">
                    <option value="" {{ old('bentuk_sediaan', $data['bentuk_sediaan'] ?? '') == '' ? 'selected' : '' }}>Pilih Wujud</option>
                    <option value="Cair" {{ old('bentuk_sediaan', $data['bentuk_sediaan'] ?? '') == 'Cair' ? 'selected' : '' }}>Cair</option>
                    <option value="Padat" {{ old('bentuk_sediaan', $data['bentuk_sediaan'] ?? '') == 'Padat' ? 'selected' : '' }}>Padat</option>
                    <option value="Gas" {{ old('bentuk_sediaan', $data['bentuk_sediaan'] ?? '') == 'Gas' ? 'selected' : '' }}>Gas</option>
                </select>
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">Berat/Volume</label>
                <input type="number" class="form-control" data-field="berat" step="0.01" min="0" value="{{ old('berat', $data['berat'] ?? '') }}">
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">Satuan</label>
                <select class="form-select" data-field="id_satuan">
                    <option value="" selected disabled>Pilih Satuan</option>
                    @foreach($satuanData as $satuan)
                        <option value="{{ $satuan->id }}" {{ old('id_satuan', $data['id_satuan'] ?? '') == $satuan->id ? 'selected' : '' }}>{{ $satuan->nama_satuan }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        @break

    @case('Barang & Bahan Radioaktif')
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Jenis Zat</label>
                <input type="text" class="form-control" data-field="nama_zat" placeholder="Contoh: Cesium-137" value="{{ old('nama_zat', $data['nama_zat'] ?? '') }}">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Aktivitas (Bq)</label>
                <input type="number" class="form-control" data-field="berat" step="0.01" min="0" value="{{ old('berat', $data['berat'] ?? '') }}">
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">Nomor Izin BAPETEN</label>
            <input type="text" class="form-control" data-field="no_bpom" value="{{ old('no_bpom', $data['no_bpom'] ?? '') }}">
        </div>
        @break

    @case('Hewan Dan Bagian Tubuh (Non Cites)')
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Nama Hewan</label>
                <input type="text" class="form-control" data-field="merek" value="{{ old('merek', $data['merek'] ?? '') }}">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Kondisi</label>
                <select class="form-select" data-field="bentuk_sediaan">
                    <option value="" {{ old('bentuk_sediaan', $data['bentuk_sediaan'] ?? '') == '' ? 'selected' : '' }}>Pilih Kondisi</option>
                    <option value="Hidup" {{ old('bentuk_sediaan', $data['bentuk_sediaan'] ?? '') == 'Hidup' ? 'selected' : '' }}>Hidup</option>
                    <option value="Mati" {{ old('bentuk_sediaan', $data['bentuk_sediaan'] ?? '') == 'Mati' ? 'selected' : '' }}>Mati</option>
                    <option value="Olahan" {{ old('bentuk_sediaan', $data['bentuk_sediaan'] ?? '') == 'Olahan' ? 'selected' : '' }}>Olahan</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Jumlah</label>
                <input type="number" class="form-control" data-field="jumlah" min="1" value="{{ old('jumlah', $data['jumlah'] ?? '') }}">
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
        @break

    @case('Tumbuhan Dan Bagian Tumbuhan (Non Cites)')
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Nama Tumbuhan</label>
                <input type="text" class="form-control" data-field="merek" value="{{ old('merek', $data['merek'] ?? '') }}">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Bagian</label>
                <select class="form-select" data-field="bentuk_sediaan">
                    <option value="" {{ old('bentuk_sediaan', $data['bentuk_sediaan'] ?? '') == '' ? 'selected' : '' }}>Pilih Bagian</option>
                    <option value="Akar" {{ old('bentuk_sediaan', $data['bentuk_sediaan'] ?? '') == 'Akar' ? 'selected' : '' }}>Akar</option>
                    <option value="Batang" {{ old('bentuk_sediaan', $data['bentuk_sediaan'] ?? '') == 'Batang' ? 'selected' : '' }}>Batang</option>
                    <option value="Daun" {{ old('bentuk_sediaan', $data['bentuk_sediaan'] ?? '') == 'Daun' ? 'selected' : '' }}>Daun</option>
                    <option value="Buah" {{ old('bentuk_sediaan', $data['bentuk_sediaan'] ?? '') == 'Buah' ? 'selected' : '' }}>Buah</option>
                    <option value="Utuh" {{ old('bentuk_sediaan', $data['bentuk_sediaan'] ?? '') == 'Utuh' ? 'selected' : '' }}>Utuh</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Berat (kg)</label>
                <input type="number" class="form-control" data-field="berat" step="0.01" min="0" value="{{ old('berat', $data['berat'] ?? '') }}">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Jumlah</label>
                <input type="number" class="form-control" data-field="jumlah" min="1" value="{{ old('jumlah', $data['jumlah'] ?? '') }}">
            </div>
        </div>
        @break

    @case('Benda Cagar Budaya')
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Nama Benda</label>
                <input type="text" class="form-control" data-field="merek" value="{{ old('merek', $data['merek'] ?? '') }}">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Periode/Era</label>
                <input type="text" class="form-control" data-field="model_seri" placeholder="Contoh: Majapahit, Abad ke-14" value="{{ old('model_seri', $data['model_seri'] ?? '') }}">
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Bahan</label>
                <select class="form-select" data-field="bentuk_sediaan">
                    <option value="" {{ old('bentuk_sediaan', $data['bentuk_sediaan'] ?? '') == '' ? 'selected' : '' }}>Pilih Bahan</option>
                    <option value="Batu" {{ old('bentuk_sediaan', $data['bentuk_sediaan'] ?? '') == 'Batu' ? 'selected' : '' }}>Batu</option>
                    <option value="Logam" {{ old('bentuk_sediaan', $data['bentuk_sediaan'] ?? '') == 'Logam' ? 'selected' : '' }}>Logam</option>
                    <option value="Keramik" {{ old('bentuk_sediaan', $data['bentuk_sediaan'] ?? '') == 'Keramik' ? 'selected' : '' }}>Keramik</option>
                    <option value="Kayu" {{ old('bentuk_sediaan', $data['bentuk_sediaan'] ?? '') == 'Kayu' ? 'selected' : '' }}>Kayu</option>
                    <option value="Lainnya" {{ old('bentuk_sediaan', $data['bentuk_sediaan'] ?? '') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Jumlah</label>
                <input type="number" class="form-control" data-field="jumlah" min="1" value="{{ old('jumlah', $data['jumlah'] ?? '') }}">
            </div>
        </div>
        @break

    @case('Kayu & Rotan (Asalan)')
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Jenis Kayu/Rotan</label>
                <input type="text" class="form-control" data-field="merek" placeholder="Contoh: Jati, Meranti" value="{{ old('merek', $data['merek'] ?? '') }}">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Volume (m³)</label>
                <input type="number" class="form-control" data-field="volume" step="0.01" min="0" value="{{ old('volume', $data['volume'] ?? '') }}">
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Jumlah Batang/Ikat</label>
                <input type="number" class="form-control" data-field="jumlah" min="1" value="{{ old('jumlah', $data['jumlah'] ?? '') }}">
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
        @break

    @case('Produk Melanggar Haki')
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Merek Asli yang Dilanggar</label>
                <input type="text" class="form-control" data-field="merek" placeholder="Contoh: Nike, Louis Vuitton" value="{{ old('merek', $data['merek'] ?? '') }}">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Merek Palsu / Label</label>
                <input type="text" class="form-control" data-field="nama_produk" value="{{ old('nama_produk', $data['nama_produk'] ?? '') }}">
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 mb-3">
                <label class="form-label">Jenis Pelanggaran</label>
                <select class="form-select" data-field="jenis_elektronik">
                    <option value="" {{ old('jenis_elektronik', $data['jenis_elektronik'] ?? '') == '' ? 'selected' : '' }}>Pilih Jenis</option>
                    <option value="Merek" {{ old('jenis_elektronik', $data['jenis_elektronik'] ?? '') == 'Merek' ? 'selected' : '' }}>Merek</option>
                    <option value="Hak Cipta" {{ old('jenis_elektronik', $data['jenis_elektronik'] ?? '') == 'Hak Cipta' ? 'selected' : '' }}>Hak Cipta</option>
                    <option value="Paten" {{ old('jenis_elektronik', $data['jenis_elektronik'] ?? '') == 'Paten' ? 'selected' : '' }}>Paten</option>
                </select>
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">Jumlah</label>
                <input type="number" class="form-control" data-field="jumlah" min="1" value="{{ old('jumlah', $data['jumlah'] ?? '') }}">
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">Satuan</label>
                <select class="form-select" data-field="id_satuan">
                    <option value="" selected disabled>Pilih Satuan</option>
                    @foreach($satuanData as $satuan)
                        <option value="{{ $satuan->id }}" {{ old('id_satuan', $data['id_satuan'] ?? '') == $satuan->id ? 'selected' : '' }}>{{ $satuan->nama_satuan }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        @break

    @case('Alat Kesehatan')
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Nama Alat</label>
                <input type="text" class="form-control" data-field="nama_produk" value="{{ old('nama_produk', $data['nama_produk'] ?? '') }}">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Merek</label>
                <input type="text" class="form-control" data-field="merek" value="{{ old('merek', $data['merek'] ?? '') }}">
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 mb-3">
                <label class="form-label">No. Izin Edar (Kemenkes)</label>
                <input type="text" class="form-control" data-field="no_bpom" value="{{ old('no_bpom', $data['no_bpom'] ?? '') }}">
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">Kelas Risiko</label>
                <select class="form-select" data-field="bentuk_sediaan">
                    <option value="" {{ old('bentuk_sediaan', $data['bentuk_sediaan'] ?? '') == '' ? 'selected' : '' }}>Pilih Kelas</option>
                    <option value="A" {{ old('bentuk_sediaan', $data['bentuk_sediaan'] ?? '') == 'A' ? 'selected' : '' }}>Kelas A</option>
                    <option value="B" {{ old('bentuk_sediaan', $data['bentuk_sediaan'] ?? '') == 'B' ? 'selected' : '' }}>Kelas B</option>
                    <option value="C" {{ old('bentuk_sediaan', $data['bentuk_sediaan'] ?? '') == 'C' ? 'selected' : '' }}>Kelas C</option>
                </select>
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">Jumlah</label>
                <input type="number" class="form-control" data-field="jumlah" min="1" value="{{ old('jumlah', $data['jumlah'] ?? '') }}">
            </div>
        </div>
        @break

    @case('Kosmetik')
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Nama Produk</label>
                <input type="text" class="form-control" data-field="nama_produk" placeholder="Contoh: Facial Wash" value="{{ old('nama_produk', $data['nama_produk'] ?? '') }}">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Merek</label>
                <input type="text" class="form-control" data-field="merek" placeholder="Contoh: Scarlett" value="{{ old('merek', $data['merek'] ?? '') }}">
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">No. Izin Edar (BPOM)</label>
                <input type="text" class="form-control" data-field="no_bpom" placeholder="Contoh: NA18211204238" value="{{ old('no_bpom', $data['no_bpom'] ?? '') }}">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Tanggal Kadaluwarsa</label>
                <input type="date" class="form-control" data-field="tanggal_kadaluwarsa" value="{{ old('tanggal_kadaluwarsa', $data['tanggal_kadaluwarsa'] ?? '') }}">
            </div>
        </div>
        @break

    @case('Obat-Obatan')
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Nama Obat</label>
                <input type="text" class="form-control" data-field="nama_obat" placeholder="Contoh: Paracetamol" value="{{ old('nama_obat', $data['nama_obat'] ?? '') }}">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Merek</label>
                <input type="text" class="form-control" data-field="merek" placeholder="Contoh: Panadol" value="{{ old('merek', $data['merek'] ?? '') }}">
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 mb-3">
                <label class="form-label">Bentuk Sediaan</label>
                <select class="form-select" data-field="bentuk_sediaan">
                    <option value="" {{ old('bentuk_sediaan', $data['bentuk_sediaan'] ?? '') == '' ? 'selected' : '' }}>Pilih Bentuk</option>
                    <option value="Tablet" {{ old('bentuk_sediaan', $data['bentuk_sediaan'] ?? '') == 'Tablet' ? 'selected' : '' }}>Tablet</option>
                    <option value="Kapsul" {{ old('bentuk_sediaan', $data['bentuk_sediaan'] ?? '') == 'Kapsul' ? 'selected' : '' }}>Kapsul</option>
                    <option value="Sirup" {{ old('bentuk_sediaan', $data['bentuk_sediaan'] ?? '') == 'Sirup' ? 'selected' : '' }}>Sirup</option>
                    <option value="Lainnya" {{ old('bentuk_sediaan', $data['bentuk_sediaan'] ?? '') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                </select>
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">Jumlah</label>
                <input type="number" class="form-control" data-field="jumlah" min="1" value="{{ old('jumlah', $data['jumlah'] ?? '') }}">
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">Satuan</label>
                <select class="form-select" data-field="id_satuan">
                    <option value="" selected disabled>Pilih Satuan</option>
                    @foreach($satuanData as $satuan)
                        <option value="{{ $satuan->id }}" {{ old('id_satuan', $data['id_satuan'] ?? '') == $satuan->id ? 'selected' : '' }}>{{ $satuan->nama_satuan }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        @break

@endswitch
