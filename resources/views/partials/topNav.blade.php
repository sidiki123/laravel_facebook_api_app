<nav class="topnav navbar navbar-expand shadow justify-content-between justify-content-sm-start navbar-light bg-white" id="sidenavAccordion">
    <!-- Sidenav Toggle Button-->
    <button class="btn btn-icon btn-transparent-dark order-1 order-lg-0 me-2 ms-lg-2 me-lg-0" id="sidebarToggle"><i data-feather="menu"></i></button>

    <a class="navbar-brand pe-3 ps-4 ps-lg-2" href="{{ route('home') }}">Gestion de stock</a>
    {{-- <form class="form-inline me-auto d-none d-lg-block me-3">
        <div class="input-group input-group-joined input-group-solid">
            <input class="form-control pe-0" type="search" placeholder="Search" aria-label="Search" />
            <div class="input-group-text"><i data-feather="search"></i></div>
        </div>
    </form> --}}
    <!-- Navbar Items-->
    <ul class="navbar-nav align-items-center ms-auto">

        <li class="nav-item dropdown no-caret dropdown-user me-3 me-lg-4">
            <a class="btn btn-icon btn-transparent-dark dropdown-toggle" id="navbarDropdownUserImage" href="javascript:void(0);" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img class="img-fluid" src="{{ asset('asset/logo-bg.png') }}" /></a>
            <div class="dropdown-menu dropdown-menu-end border-0 shadow animated--fade-in-up" aria-labelledby="navbarDropdownUserImage">
                <h6 class="dropdown-header d-flex align-items-center">
                    <img class="dropdown-user-img" src="{{ asset('asset/logo-bg.png') }}" />
                    <div class="dropdown-user-details">
                        <div class="dropdown-user-details-name">{{ Auth::user()->name }}</div>
                        <div class="dropdown-user-details-email">
                            <a href="javascript:;">
                                {{ Auth::user()->email }}</a></div>
                    </div>
                </h6>
                <div class="dropdown-divider"></div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a class="dropdown-item" href={{ route('logout') }}
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        <div class="dropdown-item-icon"><i data-feather="log-out"></i></div>
                        {{ __('Se déconnecter') }}
                    </a>
                </form>
            </div>
        </li>
    </ul>
</nav>
