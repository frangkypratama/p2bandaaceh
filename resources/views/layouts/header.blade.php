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

        <ul class="header-nav ms-auto">
            <li class="nav-item dropdown">
                <a class="nav-link py-0 d-flex align-items-center" href="#" data-coreui-toggle="dropdown" aria-expanded="false">
                    <i class="cil-user me-2"></i>
                    <span>{{ auth()->user()->name }}</span>
                </a>
                <div class="dropdown-menu dropdown-menu-end">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item">
                            <i class="cil-account-logout me-2"></i> Logout
                        </button>
                    </form>
                </div>
            </li>
        </ul>
    </div>
</header>
