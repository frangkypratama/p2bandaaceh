@extends('layouts.app')

@section('title', 'Input SBP')

@section('content')
<div class="container-lg">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0"><strong>Input Surat Bukti Penindakan (SBP)</strong></h4>
                    <small class="text-medium-emphasis">Lengkapi semua informasi yang diperlukan di bawah ini.</small>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('sbp.store') }}" class="row g-3" id="sbpForm">
                        @csrf

                        {{-- Include Partials --}}
                        @include('input-sbp.partials._penomoran')
                        @include('input-sbp.partials._identitas_pelaku')
                        @include('input-sbp.partials._detail_penindakan')
                        @include('input-sbp.partials._barang_bukti')
                        @include('input-sbp.partials._petugas')

                        {{-- Include Modals --}}
                        @include('input-sbp.partials._bast_modal')
                        @include('input-sbp.partials._pelanggaran_modal')

                        <div class="col-12 text-center">
                            <button type="submit" class="btn btn-primary btn">
                                <i class="cil-save"></i> Simpan Data SBP
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
