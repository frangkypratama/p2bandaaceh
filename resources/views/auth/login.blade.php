<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - P2 Banda Aceh</title>
    <link rel="icon" href="{{ asset('assets/img/logo-bc-banda-aceh.png') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@coreui/icons@2.1.0/css/all.min.css">

    @vite(['resources/css/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div class="bg-body-tertiary min-vh-100 d-flex flex-row align-items-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-5">
                    <div class="card p-2 shadow-sm">
                        <div class="card-body">
                            <div class="text-center mb-4">
                                <img src="{{ asset('assets/img/logo-bc-banda-aceh.png') }}" alt="Logo" height="64" class="mb-3">
                                <h1 class="h4 mb-1">P2 Banda Aceh</h1>
                                <p class="text-body-secondary">Silakan masuk menggunakan NIP Anda</p>
                            </div>

                            @if ($errors->any())
                                <div class="alert alert-danger" role="alert">
                                    {{ $errors->first() }}
                                </div>
                            @endif

                            <form method="POST" action="{{ route('login') }}">
                                @csrf

                                <div class="input-group mb-3">
                                    <span class="input-group-text">
                                        <i class="cil-user"></i>
                                        NIP
                                    </span>
                                    <input
                                        type="text"
                                        name="nip"
                                        class="form-control @error('nip') is-invalid @enderror"
                                        placeholder="NIP tanpa spasi"
                                        value="{{ old('nip') }}"
                                        inputmode="numeric"
                                        autocomplete="username"
                                        autofocus
                                        required>
                                </div>

                                <div class="input-group mb-4">
                                    <span class="input-group-text">
                                        <i class="cil-lock-locked"></i>
                                        Password
                                    </span>
                                    <input
                                        type="password"
                                        name="password"
                                        class="form-control @error('password') is-invalid @enderror"
                                        placeholder="Password"
                                        autocomplete="current-password"
                                        required>
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary w-100">Masuk</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
