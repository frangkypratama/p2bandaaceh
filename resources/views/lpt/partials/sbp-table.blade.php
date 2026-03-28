<div class="table-responsive">
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>No</th>
                <th>Nomor SBP</th>
                <th>Tanggal SBP</th>
                <th>Nama Pelaku</th>
                <th>Jenis Barang</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($sbp as $item)
                <tr>
                    <td>{{ $loop->iteration + $sbp->firstItem() - 1 }}</td>
                    <td>{{ $item->nomor_sbp }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal_sbp)->format('d-m-Y') }}</td>
                    <td>{{ $item->nama_pelaku }}</td>
                    <td>{{ $item->jenis_barang }}</td>
                    <td>
                        <button type="button"
                                class="btn btn-sm btn-primary pilih-sbp-btn"
                                data-id="{{ $item->id }}"
                                data-nomor-sbp="{{ $item->nomor_sbp }}"
                                data-coreui-dismiss="modal">
                            Pilih
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Tidak ada data SBP.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <div class="mt-3">
        {{ $sbp->links('vendor.pagination.coreui') }}
    </div>
</div>