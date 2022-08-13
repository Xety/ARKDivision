@extends('layouts.app')
{!! config(['app.title' => 'Membre']) !!}

@section('content')
<div class="container pt-6 pb-0">
    {!! $breadcrumbs->render() !!}
</div>
<div class="container pt-2">

    <div class="row">
        <div class="col-md-3">
            @include('partials.user._sidebar')
        </div>
        <div class="col-md-9">
            <section class="row">
                <div class="col-md-12 text-xs-center">
                    @if ($user->isMember)
                        <div role="alert" class="alert alert-success">
                            <i aria-hidden="true" class="fa fa-check"></i> Vous êtes <code>Membre</code> jusqu'au <code>{{ $user->member_expire_at->format('d-m-Y à H:i:s') }}</code>
                        </div>
                    @else
                        <div role="alert" class="alert alert-danger">
                            <i aria-hidden="true" class="fa fa-exclamation"></i> Vous n'êtes pas (plus) <code>Membre</code>, devenez <code>Membre</code> en faisant une donation !<br><br>
                            {{ link_to(route('admin.role.role.showcreate'), '<i class="fa fa-paypal"></i> Faire une Donation', ['class' => 'btn btn-outline-primary-inverse mb-1'], null, false) }}

                        </div>
                    @endif
                </div>

                @if ($user->isMember)
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-control-label">
                                <i class="fas fa-palette"></i> Couleurs Totales :
                            </label>
                            <span class="text-muted">
                                {{ $user->color_count }}
                            </span>
                        </div>
                        <div class="form-group">
                            <label class="form-control-label">
                                <i class="fas fa-palette"></i> Couleurs Restantes :
                            </label>
                            <span class="text-muted">
                                {{ $user->color_remain }}
                            </span>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-control-label">
                                <i class="fas fa-mask"></i> Skins Totaux :
                            </label>
                            <span class="text-muted">
                                {{ $user->skin_count }}
                            </span>
                        </div>
                        <div class="form-group">
                            <label class="form-control-label">
                                <i class="fas fa-mask"></i> Skins Restants :
                            </label>
                            <span class="text-muted">
                                {{ $user->skin_remain }}
                            </span>
                        </div>
                    </div>
                @endif


            </section>
        </div>
    </div>
</div>
@endsection
