<!-- HEADER -->
<header class="header header-sticky mb-4">
    <div class="container-fluid">
        <button
            class="header-toggler px-md-0 me-md-3"
            type="button"
            aria-label="Toggle sidebar"
            onclick="coreui.Sidebar.getInstance(document.querySelector('#sidebar')).toggle()">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M4 6H20M4 12H20M4 18H20" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </button>

        <nav class="header-nav d-none d-md-flex" aria-label="Top Navigation">
            <a class="nav-link" href="{{ url('/dashboard') }}">Dashboard</a>
            <a class="nav-link" href="{{ url('/users') }}">Users</a>
            <a class="nav-link" href="{{ url('/settings') }}">Settings</a>
        </nav>

        <nav class="header-nav ms-auto" aria-label="User Menu">
            <a class="nav-link" href="#">Notifications</a>
        </nav>
    </div>
</header>
