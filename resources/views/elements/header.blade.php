@push('scripts')
<script type="text/javascript">
    const counters = document.querySelectorAll('#total-points');
    const speed = 200;

    counters.forEach( counter => {
        const animate = () => {
            const value = +counter.getAttribute('akhi');
            const data = +counter.innerText;
            const time = value / speed;

            if (data < value) {
                counter.innerText = Math.ceil(data + time);
                setTimeout(animate, 1);
            } else {
                counter = counter.getAttribute('akhi');
                var counterm = counter.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ");
                const totalPoints = document.querySelectorAll('#total-points');

                totalPoints.forEach (points => {
                    points.innerHTML = counterm;
                })
            }
        }
        animate();
    });
</script>
@endpush

<header>
    <nav class="navbar navbar-dark navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="{{ route('page.index') }}">
                <img src="{{ asset('images/logo.png') }}" width="180"  alt="Logo">
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link nav-link-menu" href="{{ route('page.index') }}">
                            <span data-hover="Accueil">Accueil</span>
                        </a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link nav-link-menu font-aventures text-primary" href="#" data-bs-title="Coming soon..." data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-container="body">
                        <img src="{{ asset('images/logo-adventures.png') }}" width="35"  alt="Logo Aventures">Aventures
                    </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-menu" href="{{ route('statut.page.index') }}">
                            <span data-hover="Statut">Statut</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-menu" href="{{ route('donation.page.index') }}">
                            <span data-hover="Donation">Donation</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-menu" href="http://arklog.ark-division.fr">
                            <span data-hover="ARKLog">ARKLog</span>
                        </a>
                    </li>
                </ul>

                <!-- Points -->
                @include('partials._points', ['header' => true])

                @if (Auth::guest())
                    <div class="d-flex align-items-center">
                        <a class="btn btn-outline-danger ms-3 me-3" href="{{ route('users.auth.register') }}">
                            <i class="fa fa-user-plus" aria-hidden="true"></i> Inscription
                        </a>
                        <a class="btn btn-outline-primary" href="{{ route('users.auth.login') }}">
                            <i class="fa fa-sign-in" aria-hidden="true"></i> Connexion
                        </a>
                    </div>
                @else

                    <div class="col-auto">
                        <ul class="navbar-nav ps-lg-2 ps-xl-5">
                            <li class="nav-item">
                                <!-- Notifications -->
                                @include('partials._notifications')

                                <a class="nav-link dropdown-toggle d-inline" style="font-size:17px" href="#" id="sidebar-trigger" role="button">
                                    <i class="fa-thin fa-circle-user"></i> <span style="color:#e6cb8e">Bonjour,</span> {{ Auth::user()->username }}
                                </a>
                            </li>
                        </ul>
                    </div>
                @endif

            </div>

        </div>
    </nav>
</header>


<!-- Sidebar -->
@include('elements.sidebar')
