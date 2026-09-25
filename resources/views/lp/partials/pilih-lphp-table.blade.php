<div class="table-responsive">
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>No</th>
                <th>Nomor LPHP</th>
                <th>Tanggal LPHP</th>
                <th>Nomor SBP</th>
                <th>Nama Pelaku</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($lphp as $item)
                <tr>
                    <td>{{ $loop->iteration + $lphp->firstItem() - 1 }}</td>
                    <td>{{ $item->nomor_lphp }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal_lphp)->format('d-m-Y') }}</td>
                    <td><span class="badge bg-info text-white">{{ optional($item->sbp)->nomor_sbp ?? 'N/A' }}</span></td>
                    <td>{{ optional($item->sbp)->nama_pelaku ?? '-' }}</td>
                    <td>
                        @if($item->lp)
                            <span class="badge bg-success">LP telah dibuat</span>
                        @else
                            <a href="{{ route('lp.create', ['lphp_id' => $item->id]) }}" class="btn btn-sm btn-primary">
                                Pilih
                            </a>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Tidak ada data LPHP.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <div class="mt-3">
        {{ $lphp->links('vendor.pagination.coreui') }}
    </div>
</div>
