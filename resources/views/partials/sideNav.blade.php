<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <nav class="sidenav shadow-right sidenav-light">
            <div class="sidenav-menu">
                <div class="nav accordion" id="accordionSidenav">
                    <div class="sidenav-menu-heading">Pages</div>
                    <a class="nav-link collapsed" href="{{ route('home') }}">
                        <div class="nav-link-icon"><i data-feather="activity"></i></div>
                        Accueil
                    </a>
                    @if (Auth::user()->token == null ?? '')
                        <a class="nav-link collapsed" href="{{ route('informations.index') }}">
                            <div class="nav-link-icon"><i data-feather="package"></i></div>
                            Profil
                        </a>
                    @else
                        <a class="nav-link collapsed" href="{{ route('publication.index') }}">
                            <div class="nav-link-icon"><i data-feather="repeat"></i></div>
                            Publications
                        </a>
                        <a class="nav-link collapsed" href="{{ route('informations.index') }}">
                            <div class="nav-link-icon"><i data-feather="package"></i></div>
                            Profil
                        </a>
                    @endif
                </div>
            </div>
            <img class="text-center" src="{{ asset('media/profile-2.png') }}" alt="" width="150px" style="margin: auto">
            <div class="sidenav-footer">
                <div class="sidenav-footer-content">
                    <div class="sidenav-footer-subtitle">Utilisateur connecté(e):</div>
                    <div class="sidenav-footer-title">{{ Auth::user()->name }}</div>
                </div>
            </div>
        </nav>
    </div>
