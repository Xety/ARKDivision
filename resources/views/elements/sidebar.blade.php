@if (Auth::user())
<menu class="sidebar sidebar-closed" id="sidebar">
    <div class="sidebar-container">
        <ul class="nav sidebar-menu">
            <a href="{{ Auth::user()->profile_url }}" class="sidebar-avatar" data-bs-title="Visiter votre profil !" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-container="body">
                <img src="{{ asset(Auth::user()->avatar_small) }}" alt="avatar">
            </a>
            @permission('access.administration')
                <li>
                    <a href="{{ route('admin.page.index') }}" class="d-none d-lg-block" data-bs-title="Acceder à l'administration du site." data-bs-toggle="tooltip" data-bs-placement="left" data-bs-container="body">
                        <i class="fa fa-dashboard"></i>
                        <small class="sidebar-text">Dashboard</small>
                    </a>
                    <!-- Responsive link -->
                    <a href="{{ route('admin.page.index') }}" class="d-lg-none">
                        <i class="fa fa-dashboard"></i>
                        <small class="sidebar-text">Dashboard</small>
                    </a>
                </li>
            @endpermission

            <li>
                <a href="#" class="d-none d-lg-block" data-bs-title="Coming soon..." data-bs-toggle="tooltip" data-bs-placement="left" data-bs-container="body">
                    <img src="{{ asset('images/logo-adventures.png') }}" width="30"  alt="Logo Aventures"><small class="sidebar-text font-aventures">Mon Aventure</small>
                </a>
                <!-- Responsive link -->
                <a href="#" class="d-lg-none">
                    <img src="{{ asset('images/logo-adventures.png') }}" width="30"  alt="Logo Aventures"><small class="sidebar-text font-aventures">Mon Aventure</small>
                </a>
            </li>

            <li>
                <a href="{{ route('users.user.account') }}" class="d-none d-lg-block" data-bs-title="Gérer les informations de votre compte." data-bs-toggle="tooltip" data-bs-placement="left" data-bs-container="body">
                    <i class="fas fa-user-edit"></i>
                    <small class="sidebar-text">Compte</small>
                </a>
                <!-- Responsive link -->
                <a href="{{ route('users.user.account') }}" class="d-lg-none">
                    <i class="fas fa-user-edit"></i>
                    <small class="sidebar-text">Compte</small>
                </a>
            </li>

            <li>
                <a href="{{ route('users.notification.index') }}" class="d-none d-lg-block" data-bs-title="Gérer vos nouvelles et anciennes notifications." data-bs-toggle="tooltip" data-bs-placement="left" data-bs-container="body">
                    <i class="fas fa-user-tag"></i>
                    <small class="sidebar-text">Notifications</small>
                </a>
                <!-- Responsive link -->
                <a href="{{ route('users.notification.index') }}" class="d-lg-none">
                    <i class="fas fa-user-tag"></i>
                    <small class="sidebar-text">Notifications</small>
                </a>
            </li>

            <li>
                <a href="{{ route('users.reward.index') }}" class="d-none d-lg-block" data-bs-title="Gérer vos récompenses ingame." data-bs-toggle="tooltip" data-bs-placement="left" data-bs-container="body">
                    <i class="fas fa-award"></i>
                    <small class="sidebar-text">Récompenses</small>
                </a>
                <!-- Responsive link -->
                <a href="{{ route('users.reward.index') }}" class="d-lg-none">
                    <i class="fas fa-award"></i>
                    <small class="sidebar-text">Récompenses</small>
                </a>
            </li>

            <li>
                <a href="{{ route('users.auth.logout') }}"  class="d-none d-lg-block text-danger" data-bs-title="A plus tard !" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-container="body"
                    onclick="event.preventDefault();
                             document.getElementById('logout-form').submit();">
                    <i class="fa fa-sign-out"></i>
                    <small class="sidebar-text">Déconnexion</small>
                </a>
                <!-- Responsive link -->
                <a href="{{ route('users.auth.logout') }}" class="d-lg-none text-danger"
                    onclick="event.preventDefault();
                             document.getElementById('logout-form').submit();">
                    <i class="fa fa-sign-out"></i>
                    <small class="sidebar-text">Déconnexion</small>
                </a>
                {!! Form::open([
                    'route' => 'users.auth.logout',
                    'id' => 'logout-form',
                    'method' => 'post',
                    'style' => 'display: none;'
                ]) !!}
                {!! Form::close() !!}
            </li>
        </ul>
    </div>
</menu>
@endif
