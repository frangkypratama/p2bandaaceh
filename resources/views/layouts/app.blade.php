<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'P2 Banda Aceh')</title>
    <link rel="icon" href="{{ public_path('assets/img/logo-bc-banda-aceh.png') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@coreui/icons@2.1.0/css/all.min.css">
    @vite(['resources/css/app.scss', 'resources/js/app.js'])
</head>

<body>

    {{-- SIDEBAR --}}
    @include('layouts.sidebar')

    {{-- WRAPPER --}}
    <div class="wrapper d-flex flex-column min-vh-100 bg-light">

        {{-- HEADER --}}
        @include('layouts.header')

        {{-- BODY --}}
        <div class="body flex-grow-1">

            {{-- MAIN CONTENT --}}
            <main class="content px-4">
                {{-- Session Alerts --}}
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-coreui-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-coreui-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                
                @yield('content')
            </main>

        </div>

        {{-- FOOTER --}}
        @include('layouts.footer')

    </div>
    
    {{-- Universal Delete Confirmation Modal --}}
    <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteConfirmationModalLabel">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus data ini?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-coreui-dismiss="modal">Batal</button>
                    <form id="deleteForm" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Custom Scripts --}}
    @stack('scripts')

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var deleteConfirmationModal = document.getElementById('deleteConfirmationModal');
            if (deleteConfirmationModal) {
                deleteConfirmationModal.addEventListener('show.coreui.modal', function (event) {
                    var button = event.relatedTarget;
                    var url = button.getAttribute('data-url');
                    var form = document.getElementById('deleteForm');
                    form.setAttribute('action', url);
                });
            }
        });
    </script>

</body>
</html>
