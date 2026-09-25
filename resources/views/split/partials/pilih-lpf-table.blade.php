<div class="table-responsive">
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>No</th>
                <th>Nomor LPF</th>
                <th>Tanggal LPF</th>
                <th>Nomor LPP</th>
                <th>Nama Pelaku</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($lpf as $item)
                @php $sbp = optional(optional(optional($item->lpp)->lp)->lphp)->sbp; @endphp
                <tr>
                    <td>{{ $loop->iteration + $lpf->firstItem() - 1 }}</td>
                    <td>{{ $item->nomor_lpf }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal_lpf)->format('d-m-Y') }}</td>
                    <td>{{ optional($item->lpp)->nomor_lpp ?? '-' }}</td>
                    <td>{{ optional($sbp)->nama_pelaku ?? '-' }}</td>
                    <td>
                        @if($item->split)
                            <span class="badge bg-success">SPLIT telah dibuat</span>
                        @else
                            <a href="{{ route('split.create', ['lpf_id' => $item->id]) }}" class="btn btn-sm btn-primary">
                                Pilih
                            </a>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Tidak ada data LPF.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <div class="mt-3">
        {{ $lpf->links('vendor.pagination.coreui') }}
    </div>
</div>
