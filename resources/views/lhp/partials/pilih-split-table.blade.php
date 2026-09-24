<div class="table-responsive">
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>No</th>
                <th>Nomor SPLIT</th>
                <th>Tanggal SPLIT</th>
                <th>Nomor LPF</th>
                <th>Nama Pelaku</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($split as $item)
                @php $sbp = optional(optional(optional(optional($item->lpf)->lpp)->lp)->lphp)->sbp; @endphp
                <tr>
                    <td>{{ $loop->iteration + $split->firstItem() - 1 }}</td>
                    <td>{{ $item->nomor_split }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal_split)->format('d-m-Y') }}</td>
                    <td>{{ optional($item->lpf)->nomor_lpf ?? '-' }}</td>
                    <td>{{ optional($sbp)->nama_pelaku ?? '-' }}</td>
                    <td>
                        @if($item->lhp)
                            <span class="badge bg-success">Telah Dibuat LHP</span>
                        @else
                            <a href="{{ route('lhp.create', ['split_id' => $item->id]) }}" class="btn btn-sm btn-primary">
                                Pilih
                            </a>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Tidak ada data SPLIT.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <div class="mt-3">
        {{ $split->links('vendor.pagination.coreui') }}
    </div>
</div>
