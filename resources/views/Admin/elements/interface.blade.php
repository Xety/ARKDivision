<nav id="interfaceMenu" class="col-lg-2 d-lg-block interface collapse">
    <div class="position-sticky pt-3 interface-sticky">
        <h6 class="interface-heading d-flex justify-content-between align-items-center px-3 mt-2 mb-4">
                <a href="#" id="sidebar-trigger" class="nav-link">
                    Hello,&nbsp;
                    <span class="text-primary fw-bold">
                        {{ Auth::user()->username }}
                    </span>
                </a>
            <a href="{{ route('users.auth.logout') }}" class="float-xs-right" data-toggle="tooltip" data-container="body" title="Logout"
                onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                <i class="fa fa-sign-out"></i>
            </a>
            {!! Form::open([
                'route' => 'users.auth.logout',
                'id' => 'logout-form',
                'method' => 'post',
                'style' => 'display: none;'
            ]) !!}
            {!! Form::close() !!}
        </h6>

        {!! Menu::{'admin.administration'}() !!}

        <h6 class="interface-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-uppercase">
            <span>Users</span>
        </h6>
        @permission('manage.users')
            {!! Menu::{'admin.user'}() !!}
        @endpermission

        <h6 class="interface-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-uppercase">
            <span>Roles</span>
        </h6>
        @permission('manage.roles')
            {!! Menu::{'admin.role'}() !!}
        @endpermission
    </div>
</nav>
