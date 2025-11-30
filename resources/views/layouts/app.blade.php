<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'P2 Banda Aceh')</title>
    @vite(['resources/scss/style.scss', 'resources/js/app.js'])
</head>
<body>

<div class="sidebar sidebar-dark sidebar-fixed" id="sidebar">
    <!-- Sidebar content here -->
    <ul class="sidebar-nav" data-coreui="navigation" data-simplebar="">
        <li class="nav-item"><a class="nav-link" href="#">
            <svg class="nav-icon">
                <use xlink:href="/node_modules/@coreui/icons/sprites/free.svg#cil-speedometer"></use>
            </svg> Dashboard</a></li>
    </ul>
</div>

<div class="wrapper d-flex flex-column min-vh-100 bg-light">
    <header class="header header-sticky mb-4">
        <!-- Header content here -->
        <div class="container-fluid">
            <button class="header-toggler px-md-0 me-md-3" type="button" onclick="coreui.Sidebar.getInstance(document.querySelector('#sidebar')).toggle()">
                <svg class="icon icon-lg">
                    <use xlink:href="/node_modules/@coreui/icons/sprites/free.svg#cil-menu"></use>
                </svg>
            </button>
            <a class="header-brand d-md-none" href="#">
                <svg width="118" height="46" alt="CoreUI Logo">
                    <use xlink:href="/assets/brand/coreui.svg#full"></use>
                </svg>
            </a>
        </div>
    </header>

    <div class="body flex-grow-1 px-3">
        <div class="container-lg">
            @yield('content')
        </div>
    </div>

    <footer class="footer">
        <!-- Footer content here -->
        <div><a href="https://coreui.io">CoreUI</a> © 2024 creativeLabs.</div>
        <div class="ms-auto">Powered by&nbsp;<a href="https://coreui.io/">CoreUI</a></div>
    </footer>
</div>

</body>
</html>
