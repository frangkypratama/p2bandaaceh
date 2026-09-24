<div class="table-responsive">
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>No</th>
                <th>Nomor LPP</th>
                <th>Tanggal LPP</th>
                <th>Nomor LP</th>
                <th>Nama Pelaku</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($lpp as $item)
                @php $sbp = optional(optional($item->lp)->lphp)->sbp; @endphp
                <tr>
                    <td>{{ $loop->iteration + $lpp->firstItem() - 1 }}</td>
                    <td>{{ $item->nomor_lpp }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal_lpp)->format('d-m-Y') }}</td>
                    <td>{{ optional($item->lp)->nomor_lp ?? '-' }}</td>
                    <td>{{ optional($sbp)->nama_pelaku ?? '-' }}</td>
                    <td>
                        @if($item->lpf)
                            <span class="badge bg-success">Telah Dibuat LPF</span>
                        @else
                            <a href="{{ route('lpf.create', ['lpp_id' => $item->id]) }}" class="btn btn-sm btn-primary">
                                Pilih
                            </a>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Tidak ada data LPP.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <div class="mt-3">
        {{ $lpp->links('vendor.pagination.coreui') }}
    </div>
</div>
