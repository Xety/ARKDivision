@extends('layouts.error')
{!! config(['app.title' => 'Not found']) !!}

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-12 text-center">
            <h1 class="font-aventures" style="font-size: 8rem;font-weight: bold;">
                403
            </h1>
            <div class="fs-1 mb-4">
                Vous n'êtes pas autorisé a effectuer cette action.
            </div>
            <div class="mb-4">
                {!! link_to(
                    route('page.index'),
                    '<i class="fa fa-home" aria-hidden="true"></i> Accueil',
                    ['class' => 'btn btn-outline-primary'],
                    true,
                    false
                ) !!}
            </div>
        </div>
    </div>
</div>
@endsection