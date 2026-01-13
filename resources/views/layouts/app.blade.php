<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'CoreUI Laravel')</title>
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
                @yield('content')
            </main>

        </div>

        {{-- FOOTER --}}
        @include('layouts.footer')

    </div>
    
    {{-- Custom Scripts --}}
    @stack('scripts')

</body>
</html>
