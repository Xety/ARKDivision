@extends('layouts.app')
{!! config(['app.title' => 'Membre']) !!}

@section('content')
<div class="container">

    <div class="row">
        <div class="col-12">
            {!! $breadcrumbs->render() !!}
        </div>
    </div>

    <div class="row">
        <div class="col-lg-3">
            @include('partials.user._sidebar')
        </div>
        <div class="col-lg-9">
            <h1 class="p-2" style="color:#bfb59e;border-bottom:1px solid #443c32">
                Membre
            </h1>

            <div class="row">

                <div class="col-lg-3 pb-3 text-center">
                    <div class="" style="background-color: #25221d;font-size: 20px;border-radius: 6px;padding: 20px 5px;">
                        <img class="pb-1" src="{{ asset('images/member-trophy.png') }}" height="100%">

                        @if ($user->isMember)
                            <span class="d-block" style="color:#e6cb8e">
                                Vous êtes membre
                            </span>
                            <span class="d-block mb-2" style="font-size: 18px;">
                                Jusqu'au {{ $user->member_expire_at->format('d-m-Y') }}
                            </span>
                        @else
                            <span class="d-block mb-1" style="color:#e6cb8e">
                                Vous n'êtes pas membre
                            </span>
                            {{ link_to(route('donation.page.index'), '<i class="fa fa-paypal"></i> Faire une Donation', ['class' => 'btn btn-primary'], null, false) }}
                        @endif

                    </div>
                </div>

                <div class="col-lg-9 pb-3">
                    <div class="row align-items-center" style="min-height: 100%;border:1px solid #8b8472;border-radius: 6px;">
                        <div class="col-lg-3 text-center">
                            <span class="d-block mb-2" style="color: #fff;font-size: 45px;">
                                {{ $user->color_count }}
                            </span>
                            <span class="d-block mb-2" style="color:#e6cb8e">
                                Couleurs Totales
                            </span>
                        </div>

                        <div class="col-lg-3 text-center">
                            <span class="d-block mb-2" style="color: #fff;font-size: 45px;">
                                {{ $user->color_remain }}
                            </span>
                            <span class="d-block mb-2" style="color:#e6cb8e">
                                Couleurs Restantes
                            </span>
                        </div>

                        <div class="col-lg-3 text-center">
                            <span class="d-block mb-2" style="color: #fff;font-size: 45px;">
                                {{ $user->skin_count }}
                            </span>
                            <span class="d-block mb-2" style="color:#e6cb8e">
                                Skins Totaux
                            </span>
                        </div>

                        <div class="col-lg-3 text-center">
                            <span class="d-block mb-2" style="color: #fff;font-size: 45px;">
                                {{ $user->skin_remain }}
                            </span>
                            <span class="d-block mb-2" style="color:#e6cb8e">
                                Skins Restants
                            </span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
