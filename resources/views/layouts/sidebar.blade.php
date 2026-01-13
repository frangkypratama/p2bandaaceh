<!-- SIDEBAR -->
<aside class="sidebar sidebar-dark sidebar-fixed" id="sidebar" role="complementary" aria-label="Main Sidebar">
    <div class="sidebar-brand d-flex align-items-center justify-content-center py-3 border-bottom">
        <h1 class="sidebar-brand-full fs-5 m-0 text-center">
            P2 Banda Aceh
        </h1>
        <span class="sidebar-brand-narrow fw-bold">CL</span>
    </div>

    <nav class="sidebar-nav" role="navigation" aria-label="Primary Navigation" data-coreui="navigation" data-simplebar>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/dashboard') }}" aria-current="page">
                    <i class="nav-icon cil-speedometer"></i> Dashboard  <!-- Tambahkan icon jika diperlukan -->
                </a>
            </li>

            <li class="nav-title">
                <h2 class="fs-6 text-uppercase">Theme</h2>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ url('/colors') }}">
                    <i class="nav-icon cil-palette"></i> Colors  <!-- Tambahkan icon jika diperlukan -->
                </a>
            </li>
        </ul>
    </nav>
</aside>