@extends('layouts.error')
{!! config(['app.title' => 'Oups, il y a un problème...']) !!}

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-12 text-center">
            <h1 class="font-aventures" style="font-size: 8rem;font-weight: bold;">
                500
            </h1>
            <div class="fs-1 mb-4">
                Oups, il semblerait qu'il y ait un problème ...
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