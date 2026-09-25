<div class="table-responsive">
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>No</th>
                <th>Nomor LP</th>
                <th>Tanggal LP</th>
                <th>Nomor SBP</th>
                <th>Nama Pelaku</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($lp as $item)
                @php $sbp = optional($item->lphp)->sbp; @endphp
                <tr>
                    <td>{{ $loop->iteration + $lp->firstItem() - 1 }}</td>
                    <td>{{ $item->nomor_lp }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal_lp)->format('d-m-Y') }}</td>
                    <td>{{ optional($sbp)->nomor_sbp ?? '-' }}</td>
                    <td>{{ optional($sbp)->nama_pelaku ?? '-' }}</td>
                    <td>
                        @if($item->lpp)
                            <span class="badge bg-success">LPP telah dibuat</span>
                        @else
                            <a href="{{ route('lpp.create', ['lp_id' => $item->id]) }}" class="btn btn-sm btn-primary">
                                Pilih
                            </a>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Tidak ada data LP.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <div class="mt-3">
        {{ $lp->links('vendor.pagination.coreui') }}
    </div>
</div>
