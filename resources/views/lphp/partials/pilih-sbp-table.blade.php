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
                        @if($item->lphp)
                            <span class="badge bg-success">LPHP telah dibuat</span>
                        @else
                            <a href="{{ route('lphp.create', ['sbp_id' => $item->id]) }}" class="btn btn-sm btn-primary">
                                Pilih
                            </a>
                        @endif
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
