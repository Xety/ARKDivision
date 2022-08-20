@extends('layouts.error')
{!! config(['app.title' => 'Site en maintenance']) !!}

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-12 text-center">
            <h1 class="font-aventures" style="font-size: 8rem;font-weight: bold;">
                503
            </h1>
            <div class="fs-1 mb-4">
                Le site est en maintenance, réessayez plus tard.
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