<header class="pos-f-t">
    <div class="navbar-header" style="background-color: #262a2b;color: #fff;border-bottom: 1px solid #1dfcea;">
        <div class="container" style="min-height: 45px;">
            <div class="row" style="padding: 10px;">
            <div class="col-md-6" style="">
                <a href="https://www.facebook.com/arkdivision/"  style="font-size: 12px;">
                    <i class="fab fa-facebook-square"></i>
                    Suivez-nous sur Facebook !
                </a>

            </div>
            <div class="col-md-2 offset-md-4">
                <a href="https://discord.gg/tcud7UG">
                    <i class="fab fa-discord"></i>
                    Discord
                </a>
            </div>
            </div>
        </div>
    </div>

    <nav id="navbar" class="navbar navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ route('page.index') }}">
                <img src="{{ asset('images/logo.png') }}" height="80" class="d-inline-block align-middle" alt="Logo">
            </a>

            <button class="navbar-toggler hidden-sm-up" type="button" data-toggle="collapse" data-target="#navbarDivision" aria-controls="navbarDivision" aria-expanded="false" aria-label="Toggle navigation">
            </button>

            <div class="collapse navbar-collapse navbar-toggleable-xs" id="navbarDivision">
                <ul class="nav navbar-nav">
                    <li class="nav-item nav-link active">
                        <a class="nav-link-menu" href="{{ route('page.index') }}">
                            <span data-hover="Accueil">Accueil</span>
                        </a>
                    </li>
                    <li class="nav-item nav-link">
                        <a class="nav-link-menu" href="{{ route('statut.page.index') }}">
                            <span data-hover="Statut">Statut</span>
                        </a>
                    </li>
                    <li class="nav-item nav-link">
                        <a class="nav-link-menu" href="{{ route('donation.page.index') }}">
                            <span data-hover="Donation">Donation</span>
                        </a>
                    </li>
                    <li class="nav-item nav-link">
                        <a class="nav-link-menu" href="http://arklog.ark-division.fr">
                            <span data-hover="ARKLog">ARKLog</span>
                        </a>
                    </li>
                </ul>

                @if (Auth::guest())
                    <div class="nav-item float-sm-right">
                        <a class="btn btn-outline-primary-inverse" href="{{ route('users.auth.register') }}">
                            <i class="fa fa-user-plus" aria-hidden="true"></i> Inscription
                        </a>
                        <a class="btn btn-outline-primary-inverse" href="{{ route('users.auth.login') }}">
                            <i class="fa fa-sign-in" aria-hidden="true"></i> Connexion
                        </a>
                    </div>
                @else
                    <div class="navbar-text btn-group float-sm-right font-weight-bold">
                        <a href="#" id="sidebar-trigger" class="nav-link">
                            {{ Auth::user()->username }}
                        </a>
                    </div>
                    <span class="navbar-text navbar-hello-text float-xs-left float-sm-right font-weight-bold">
                        Bonjour,&nbsp;
                    </span>

                    <!-- Notifications -->
                    @include('partials._notifications')
                @endif

            </div>
        </div>
    </nav>
</header>

<!-- Sidebar -->
@include('elements.sidebar')
