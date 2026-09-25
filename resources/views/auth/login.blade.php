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
    <div class="bg-body-tertiary min-vh-100 d-flex flex-row align-items-center py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-5">

                    <div class="text-center mb-4">
                        <img src="{{ asset('assets/img/logo-bc-banda-aceh.png') }}" alt="Logo" height="56">
                        <span class="fs-3 fw-semibold align-middle ms-2">P2 Banda Aceh</span>
                    </div>

                    <div class="card shadow-sm">
                        <div class="card-body p-4">
                            <h1 class="h4 text-center mb-4">Masuk ke akun Anda</h1>

                            @if ($errors->any())
                                <div class="alert alert-danger" role="alert">
                                    {{ $errors->first() }}
                                </div>
                            @endif

                            <form method="POST" action="{{ route('login') }}">
                                @csrf

                                <div class="mb-3">
                                    <label for="nip" class="form-label">NIP</label>
                                    <input
                                        type="text"
                                        id="nip"
                                        name="nip"
                                        class="form-control @error('nip') is-invalid @enderror"
                                        placeholder="NIP tanpa spasi"
                                        value="{{ old('nip') }}"
                                        inputmode="numeric"
                                        autocomplete="username"
                                        autofocus
                                        required>
                                </div>

                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <div class="input-group">
                                        <input
                                            type="password"
                                            id="password"
                                            name="password"
                                            class="form-control @error('password') is-invalid @enderror"
                                            placeholder="Password"
                                            autocomplete="current-password"
                                            required>
                                        <button class="btn btn-outline-secondary" type="button" id="togglePassword" aria-label="Tampilkan password">
                                            <i class="cil-low-vision" id="togglePasswordIcon"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="mb-4 form-check">
                                    <input type="checkbox" class="form-check-input" id="remember" name="remember">
                                    <label class="form-check-label" for="remember">Ingat saya di perangkat ini</label>
                                </div>

                                <button type="submit" class="btn btn-primary w-100">Sign in</button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('togglePassword').addEventListener('click', function () {
            var input = document.getElementById('password');
            var icon = document.getElementById('togglePasswordIcon');
            var isHidden = input.type === 'password';

            input.type = isHidden ? 'text' : 'password';
            icon.classList.toggle('cil-low-vision', !isHidden);
            icon.classList.toggle('cil-eye', isHidden);
        });
    </script>
</body>
</html>
