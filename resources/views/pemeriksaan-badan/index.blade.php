@extends('layouts.app')

@section('content')
<div class="container-lg">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0"><strong>Data Pemeriksaan Badan</strong></h5>
            <a href="{{ route('pemeriksaan-badan.create') }}" class="btn btn-primary btn-sm">
                <i class="cil-plus"></i> Tambah Data
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center">No BA Riksa Badan</th>
                            <th class="text-center">Nama</th>
                            <th class="text-center">Identitas</th>
                            <th class="text-center">Kewarganegaraan</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pemeriksaanBadan as $item)
                            <tr>
                                <td class="text-center">{{ $item->no_ba_riksa }}</td>
                                <td class="text-center">{{ $item->nama }}</td>
                                <td class="text-center">{{ $item->jenis_identitas }} / {{ $item->no_identitas }}</td>
                                <td class="text-center">{{ $item->kewarganegaraan }}</td>
                                <td class="text-center">
                                    <div class="btn-group" role="group" aria-label="Aksi">
                                        <button type="button" class="btn btn-info btn-sm btn-preview"
                                            data-coreui-toggle="modal"
                                            data-coreui-target="#cetakModal"
                                            data-preview-url="{{ route('pemeriksaan-badan.cetak', [$item->id, 'is_preview' => true]) }}">
                                            <i class="cil-print"></i>
                                        </button>
                                        <a href="{{ route('pemeriksaan-badan.edit', $item->id) }}" class="btn btn-warning btn-sm"><i class="cil-pencil"></i></a>
                                        <button type="button" class="btn btn-danger btn-sm" data-coreui-toggle="modal" data-coreui-target="#deleteConfirmationModal" data-url="{{ route('pemeriksaan-badan.destroy', $item->id) }}">
                                            <i class="cil-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Tidak ada data.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($pemeriksaanBadan->hasPages())
                <div class="mt-3">
                    {{ $pemeriksaanBadan->links('vendor.pagination.coreui') }}
                </div>
            @endif
        </div>
    </div>
</div>

{{-- Modal Cetak --}}
<div class="modal fade" id="cetakModal" tabindex="-1" aria-labelledby="cetakModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cetakModalLabel">Preview Dokumen</h5>
                <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <iframe id="previewIframe" src="about:blank" style="width: 100%; height: 75vh; border: none;" title="Preview Dokumen"></iframe>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var cetakModal = document.getElementById('cetakModal');
        if (cetakModal) {
            cetakModal.addEventListener('show.coreui.modal', function (event) {
                var button = event.relatedTarget;
                var previewUrl = button.getAttribute('data-preview-url');
                var iframe = cetakModal.querySelector('#previewIframe');

                if (iframe) {
                    iframe.src = previewUrl;
                }
            });

            cetakModal.addEventListener('hidden.coreui.modal', function () {
                var iframe = cetakModal.querySelector('#previewIframe');
                if (iframe) {
                    iframe.src = 'about:blank';
                }
            });
        }
    });
</script>
@endpush
