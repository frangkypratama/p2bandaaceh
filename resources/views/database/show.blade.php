@extends('layouts.app')

@section('content')
<div class="container-lg">
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <a href="{{ route('database.index') }}" class="btn btn-sm btn-light me-2" title="Kembali ke daftar tabel">
                        <i class="cil-arrow-left"></i>
                    </a>
                    <h1 class="mb-0 d-inline-block">Tabel: <strong>{{ $tableName }}</strong></h1>
                </div>
            </div>
        </div>
        <div class="card-body">
            @if ($data->isEmpty())
                <div class="alert alert-info" role="alert">
                    Tabel ini tidak memiliki data.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                @foreach ($columns as $column)
                                    <th>{{ $column }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $row)
                                <tr>
                                    @foreach ($columns as $column)
                                        <td>{{ $row->$column }}</td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Paginasi --}}
                <div class="mt-3 d-flex justify-content-center">
                    {{ $data->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
