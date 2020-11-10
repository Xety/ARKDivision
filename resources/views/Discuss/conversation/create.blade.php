@extends('layouts.app')
{!! config(['app.title' => 'Démarrer une discussion']) !!}

@push('style')
    {!! editor_css() !!}
    <link href="{{ mix('css/editor-md.custom.min.css') }}" rel="stylesheet">
@endpush

@push('scripts')
    {!! editor_js() !!}
    <script src="{{ asset(config('editor.pluginPath') . '/emoji-dialog/emoji-dialog.js') }}"></script>

    @php
        $comment = [
            'id' => 'conversationEditor',
            'height' => '350'
        ];
    @endphp

    @include('editor/partials/_comment', $comment)


    <script src="{{ mix('js/highlight.min.js') }}"></script>
    <script type="text/javascript">
        /* HighlightJS */
        hljs.initHighlightingOnLoad();
    </script>
@endpush

@section('content')
<div class="container pt-6 pb-0">
    {!! $breadcrumbs->render() !!}
</div>
<div class="container pt-2 pb-3">

    <div class="row">
        <div class="col-md-3">
            @include('Discuss::partials._sidebar')
        </div>
        <div class="col-md-9">
            <h3 class="text-xs-center">
                Nouvelle Discussion
            </h3>
            {!! Form::open(['route' => 'discuss.conversation.create', 'method' => 'post']) !!}

                {!! Form::bsText(
                    'title',
                    'Titre',
                    null,
                    [
                        'class' => 'form-control col-md-6',
                        'placeholder' => 'Titre de la discussion...',
                        'required' => 'required',
                        'autofocus'
                    ]
                ) !!}

                {!! Form::bsSelect(
                    'category_id',
                    $categories,
                    'Categorie',
                    1,
                    ['class' => 'form-control col-md-3', 'required' => 'required']
                ) !!}

                {!! Form::bsTextarea(
                    'content',
                    'Message',
                    old('content'),
                    [
                        'class' => 'form-control',
                        'required' => 'required',
                        'editor' => 'conversationEditor',
                        'style' => 'display:none;'
                    ]
                ) !!}

                @permission ('manage.discuss.conversations')
                    <div class="form-group">
                        <h5 class="text-muted">
                            Modération
                        </h5>
                    </div>

                    {!! Form::bsCheckbox(
                        'is_locked',
                        null,
                        0,
                        'Cochez pour verrouiller cette discussion',
                        [
                            'label' => 'Verrouiller ?',
                            'labelClass' => 'custom-control custom-checkbox d-block'
                        ]
                    ) !!}

                    {!! Form::bsCheckbox(
                        'is_pinned',
                        null,
                        0,
                        'Cocher pour épingler cette discussion',
                        [
                            'label' => 'Epingler ?',
                            'labelClass' => 'custom-control custom-checkbox d-block'
                        ]
                    ) !!}
                @endpermission

                <div class="form-group text-xs-center">
                    {!! Form::button(
                        '<i class="fa fa-pencil" aria-hidden="true"></i> ' . 'Créer la Discussion',
                        ['type' => 'submit', 'class' => 'btn btn-outline-primary']
                    ) !!}
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection