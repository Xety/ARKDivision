@extends('layouts.app')
{!! config(['app.title' => __('Mon compte')]) !!}

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
            <section>
                {!! Form::model($user, ['route' => 'users.account.update', 'files'=>'true', 'method' => 'put']) !!}
                    <div class="row">
                        <div class="col-md-5 col-lg-4">
                            <div class="form-group {{ $errors->has('avatar') ? 'has-danger' : '' }}">

                                <div class="fileinput fileinput-exists" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail">
                                        <img src="{{ $user->avatar_medium }}" alt="Default Avatar">
                                    </div>
                                    <div class="fileinput-preview fileinput-exists thumbnail">
                                        <img src="{{ $user->avatar_medium }}" alt="User Avatar">
                                    </div>
                                    <div>
                                        <span class="btn btn-outline-primary btn-file">
                                            <i class="fa fa-refresh"></i>
                                            <span class="fileinput-exists">Change</span>
                                             {!! Form::file('avatar') !!}
                                        </span>
                                    </div>
                                </div>
                                @if ($errors->has('avatar'))
                                    <div class="form-control-feedback">
                                        {{ $errors->first('avatar') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-7 col-lg-8">
                            {!! Form::bsText(
                                'first_name',
                               'Prénom',
                                null,
                                ['placeholder' => __('Votre Prénom...')]
                            ) !!}
                            {!! Form::bsText(
                                'last_name',
                                'Nom',
                                null,
                                ['placeholder' => __('Votre Nom...')]
                            ) !!}
                        </div>
                    </div>

                    <div class="form-group text-xs-center">
                        <div class="col-md-12">
                            {!! Form::button('<i class="fa fa-floppy-o" aria-hidden="true"></i> ' . 'Enregistrer', ['type' => 'submit', 'class' => 'btn btn-outline-primary']) !!}
                        </div>
                    </div>
                {!! Form::close() !!}
            </section>
        </div>
    </div>
</div>
@endsection
