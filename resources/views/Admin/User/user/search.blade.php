@extends('layouts.admin')
{!! config(['app.title' => 'Search an User']) !!}

@section('content')
<div class="col-sm-12 col-md-10 offset-md-2 p-2">
    {!! $breadcrumbs->render() !!}
</div>
<div class="col-sm-12 col-md-10 offset-md-2 pl-2 pr-2 pb-2">
    <div class="card card-inverse bg-inverse">
        <h5 class="card-header">
            Search an User
        </h5>

        <div class="card-block">
            @if ($users->isNotEmpty())
                <ul class="list-unstyled text-muted">
                <li>Search : <code>{{ $search }}</code></li>
                <li>Type : <code>{{ $type }}</code></li>
                </ul>
                <table class="table table-hover table-inverse">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th class="{{ $type == 'username' ? 'table-primary' : '' }}">Username</th>
                            <th class="{{ $type == 'email' ? 'table-primary' : '' }}">Email</th>
                            <th>Rôles</th>
                            <th class="{{ $type == 'registered_ip' ? 'table-primary' : '' }}">IP d'Inscription</th>
                            <th class="{{ $type == 'last_login_ip' ? 'table-primary' : '' }}">IP dernière connexion</th>
                            <th class="{{ $type == 'discord_id' ? 'table-primary' : '' }}">Discord</th>
                            <th class="{{ $type == 'steam_id' ? 'table-primary' : '' }}">Steam</th>
                            <th>Membre</th>
                            <th>Created</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <th scope="row">
                                    {{ $user->id }}
                                </th>
                                <td class="{{ $type == 'username' ? 'table-primary' : '' }}">
                                    {{ link_to($user->profile_url, $user->username) }}
                                </td>
                                <td class="{{ $type == 'email' ? 'table-primary' : '' }}">
                                    {{ $user->email }}
                                </td>
                                <td>
                                    @forelse ($user->roles as $role)
                                        <span style="{{ $role->css }}">
                                            {{ $role->name }}
                                        </span>
                                        <br />
                                    @empty
                                        Cet utilisateur n'a pas de rôle.
                                    @endforelse
                                </td>
                                <td class="{{ $type == 'registered_ip' ? 'table-primary' : '' }}">
                                    {{ $user->register_ip }}
                                </td>
                                <td class="{{ $type == 'last_login_ip' ? 'table-primary' : '' }}">
                                    {{ $user->last_login_ip }}
                                </td>
                                <td>
                                    <span data-toggle="tooltip" title="{{ $user->discord_id }}">
                                        {{ $user->discordNickname }}
                                    </span>
                                </td>
                                <td>
                                    <span data-toggle="tooltip" title="{{ $user->steam_id }}">
                                        {{ $user->steamNickname }}
                                    </span>
                                </td>
                                <td>
                                    @if ($user->member_expire_at <= \Carbon\Carbon::now())
                                        <span style="font-weight: bold; color: #ef3c3c;">
                                            Non
                                        </span>
                                    @else
                                        <span style="font-weight: bold; color: #00af94;">
                                            Oui
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    {{ $user->created_at->formatLocalized('%d %B %Y - %T') }}
                                </td>
                                <td>
                                    {{ link_to(
                                        route('admin.user.user.edit', ['slug' => $user->slug, 'id' => $user->id]),
                                        '<i class="fa fa-edit"></i>',
                                        [
                                            'class' => 'btn btn-sm btn-outline-info',
                                            'data-toggle' => 'tooltip',
                                            'title' => 'Editer cet utilisateur'
                                        ],
                                        null,
                                        false
                                    ) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="col-md 12 text-xs-center">
                    {{ $users->links() }}
                </div>
            @else
                <div class="col-md-12">
                    <div class="alert alert-primary" role="alert">
                        <i class="fa fa-exclamation" aria-hidden="true"></i>
                        Il n'y a pas de résultat pour votre recherche !
                    </div>
                </div>
            @endif
        </div>
        <div class="card-footer text-muted">
            Il y a {{ $users->count() }} utilisateurs correspondant à votre recherche.
        </div>
    </div>
</div>
@endsection
