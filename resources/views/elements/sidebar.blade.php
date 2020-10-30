@if (Auth::user())
<menu class="sidebar sidebar-closed" id="sidebar">
    <div class="sidebar-container">
        <ul class="nav sidebar-menu">
            <a href="{{ Auth::user()->profile_url }}" class="sidebar-avatar" title="Visiter votre profil !" data-toggle="tooltip" data-placement="left" data-container="body">
                <img src="{{ asset(Auth::user()->avatar_small) }}" alt="avatar">
            </a>
            @permission('access.administration')
                <li>
                    <a href="{{ route('admin.page.index') }}" class="hidden-xs-down" title="Acceder à l'administration du site." data-toggle="tooltip" data-placement="left" data-container="body">
                        <i class="fa fa-dashboard"></i>
                        <small class="sidebar-text">Dashboard</small>
                    </a>
                    <!-- Responsive link -->
                    <a href="{{ route('admin.page.index') }}" class="hidden-sm-up">
                        <i class="fa fa-dashboard"></i>
                        <small class="sidebar-text">Dashboard</small>
                    </a>
                </li>
            @endpermission

            <li>
                <a href="{{ route('users.account.index') }}" class="hidden-xs-down" title="Gérer les informations de votre compte." data-toggle="tooltip" data-placement="left" data-container="body">
                    <i class="fas fa-user-edit"></i>
                    <small class="sidebar-text">Compte</small>
                </a>
                <!-- Responsive link -->
                <a href="{{ route('users.account.index') }}" class="hidden-sm-up">
                    <i class="fas fa-user-edit"></i>
                    <small class="sidebar-text">Compte</small>
                </a>
            </li>

            <li>
                <a href="{{ route('users.notification.index') }}" class="hidden-xs-down" title="Gérer vos nouvelles et anciennes notifications." data-toggle="tooltip" data-placement="left" data-container="body">
                    <i class="fas fa-user-tag"></i>
                    <small class="sidebar-text">Notifications</small>
                </a>
                <!-- Responsive link -->
                <a href="{{ route('users.notification.index') }}" class="hidden-sm-up">
                    <i class="fas fa-user-tag"></i>
                    <small class="sidebar-text">Notifications</small>
                </a>
            </li>

            <li>
                <a href="{{ route('users.reward.index') }}" class="hidden-xs-down" title="Gérer vos récompenses ingame." data-toggle="tooltip" data-placement="left" data-container="body">
                    <i class="fas fa-award"></i>
                    <small class="sidebar-text">Récompenses</small>
                </a>
                <!-- Responsive link -->
                <a href="{{ route('users.reward.index') }}" class="hidden-sm-up">
                    <i class="fas fa-award"></i>
                    <small class="sidebar-text">Récompenses</small>
                </a>
            </li>

            <li>
                <a href="{{ route('users.user.settings') }}" class="hidden-xs-down" title="Gérer les paramètres de votre compte." data-toggle="tooltip" data-placement="left" data-container="body">
                    <i class="fas fa-user-cog"></i>
                    <small class="sidebar-text">Paramètres</small>
                </a>
                <!-- Responsive link -->
                <a href="{{ route('users.reward.index') }}" class="hidden-sm-up">
                    <i class="fas fa-user-cog"></i>
                    <small class="sidebar-text">Paramètres</small>
                </a>
            </li>

            <li>
                <a href="{{ route('users.auth.logout') }}"  class="hidden-xs-down text-danger" title="A plus tard !" data-toggle="tooltip" data-placement="left" data-container="body"
                    onclick="event.preventDefault();
                             document.getElementById('logout-form').submit();">
                    <i class="fa fa-sign-out"></i>
                    <small class="sidebar-text">Déconnexion</small>
                </a>
                <!-- Responsive link -->
                <a href="{{ route('users.auth.logout') }}" class="hidden-sm-up text-danger"
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
