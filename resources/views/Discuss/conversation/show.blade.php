@extends('layouts.app')
{!! config(['app.title' => $conversation->title]) !!}

@push('style')
    {!! editor_css() !!}
    <link href="{{ mix('css/editor-md.custom.min.css') }}" rel="stylesheet">
@endpush

@push('scripts')
    {!! editor_js() !!}
    <script src="{{ asset(config('editor.pluginPath') . '/emoji-dialog/emoji-dialog.js') }}"></script>

    @php
        $comment = [
            'id' => 'editPostEditor'
        ];
    @endphp

    @if($conversation->is_locked == false)
        @php
            $comment = [
                'id' => 'commentEditor',
                'height' => '350'
            ];
        @endphp
    @endif

    @include('editor/partials/_comment', $comment)


    <script src="{{ mix('js/highlight.min.js') }}"></script>
    <script type="text/javascript">
        /* HighlightJS */
        hljs.initHighlightingOnLoad();
    </script>
@endpush

@section('content')
<div class="discuss-conversation-header-container pb-1 pt-2">
    <div class="blog-header mt-2">
        <div class="container text-xs-center">
            <ul class="discuss-conversation-header-badges d-inline-block">
                @if ($conversation->is_pinned)
                    <li class="discuss-conversation-header-badges-item">
                        <span class="tag tag-info" data-toggle="tooltip" title="Epinglé">
                            <i class="fa fa-thumb-tack"></i>
                        </span>
                    </li>
                @endif

                @if ($conversation->is_locked)
                    <li class="discuss-conversation-header-badges-item">
                        <span class="tag tag-primary" data-toggle="tooltip" title="Verrouillé">
                            <i class="fa fa-lock"></i>
                        </span>
                    </li>
                @endif
            </ul>

            @if ($conversation->is_solved)
                <div class="discuss-conversation-header-categories tag-group">
                    <a href="{{ route('discuss.category.show', ['slug' => $conversation->category->slug, 'id' =>$conversation->category->getKey()]) }}" class="tag tag-default text-white" style="background-color: {{ $conversation->category->color }};">
                        {{ $conversation->category->title }}
                    </a>
                    <span class="tag tag-success text-white">
                        Résolue
                    </span>
                </div>
            @else
                <div class="discuss-conversation-header-categories">
                    <a href="{{ route('discuss.category.show', ['slug' => $conversation->category->slug, 'id' =>$conversation->category->getKey()]) }}" class="tag tag-default text-white" style="background-color: {{ $conversation->category->color }};">
                        {{ $conversation->category->title }}
                    </a>
                </div>
            @endif
            <h2 class="text-truncate">
                {{ $conversation->title }}
            </h2>
        </div>
    </div>
</div>
<hr class="mt-0" />
<div class="container pt-0 pb-0">
    {!! $breadcrumbs->render() !!}
</div>
<hr />
<div class="container pt-2">
    <div class="row">
        {{-- Sidebar --}}
        <div class="col-md-3">
            <div class="sidebar-module">
                @auth
                    <div class="discuss-new-discussion-btn text-xs-center text-md-left">
                        <div class="btn-group">
                            @if (!$conversation->is_locked)
                                <a href="#post-reply" class="btn btn-primary">
                                    <i class="fa fa-pencil" aria-hidden="true"></i>
                                    Répondre
                                </a>
                            @else
                                {{ link_to(
                                    route('discuss.conversation.create'),
                                    '<i class="fa fa-pencil"></i> ' . 'Nouvelle Discussion',
                                    ['class' => 'btn btn-primary'],
                                    true,
                                    false
                                ) }}
                            @endif

                            @if (
                                Auth::user()->hasPermission('manage.discuss.conversations') ||
                                Auth::user()->can('update', $conversation) ||
                                Auth::user()->can('delete', $conversation)
                            )
                                <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    @can('update', $conversation)
                                        <a class="dropdown-item" href="#editDiscussionModal" data-toggle="modal" data-target="#editDiscussionModal">
                                            <i class="fa fa-edit" aria-hidden="true"></i>
                                            Editer
                                        </a>
                                    @endcan

                                    @can('delete', $conversation)
                                        @can('update', $conversation)
                                            <div class="dropdown-divider"></div>
                                        @endcan

                                        <a class="dropdown-item" href="#deleteDiscussionModal" data-toggle="modal" data-target="#deleteDiscussionModal">
                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                            Supprimer
                                        </a>
                                    @endcan
                                </div>
                            @endif
                        </div>
                    </div>
                @else
                    <div class="discuss-new-discussion-btn">
                        {{ link_to(
                            route('users.auth.login'),
                            '<i class="fa fa-pencil"></i> ' . 'Nouvelle Discussion',
                            ['class' => 'btn btn-primary'],
                            true,
                            false
                        ) }}
                    </div>
                @endauth

                @include('Discuss::partials._sidebar')
            </div>
        </div>

        {{-- Conversation Posts --}}
        <div class="col-md-9 mb-3">
            @forelse ($postsWithLogs as $post)
                @include(
                    'Discuss::partials._post',
                    [
                        'post' => $post,
                        'conversation' => $conversation,
                        'isFirstPost' => $conversation->first_post_id == $post->id ? true : false,
                        'isSolvedPost' => $conversation->solved_post_id == $post->id ? true : false
                    ]
                )
            @empty
                @if (!$conversation->is_solved && !$conversation->is_locked)
                    <div class="alert alert-primary" role="alert">
                        <i class="fa fa-exclamation" aria-hidden="true"></i>
                        Il n'y a pas encore de commentaires, postez la première réponse!
                    </div>
                @endif
            @endforelse

            <div class="col-md 12 text-xs-center">
                {{ $posts->render() }}
            </div>

            @if ($conversation->is_locked)
                <div class="alert alert-primary" role="alert">
                    <i class="fa fa-exclamation" aria-hidden="true"></i>
                    Cette discussion est fermée, vous ne pouvez pas répondre!
                </div>
            @else
                @if (
                    $conversation->updated_at <= \Carbon\Carbon::now()->subDays(config('xetaravel.discuss.info_message_old_conversation')) &&
                    !$conversation->is_locked
                )
                    <div class="alert alert-info" role="alert">
                        <i class="fa fa-info" aria-hidden="true"></i>
                        Cette discussion n\'est plus active depuis au moins 3 mois!
                    </div>
                @endif

                @auth
                    <div id="post-reply" class="discuss-conversation-comment mb-2">
                        <div class="discuss-conversation-comment-media float-xs-left hidden-sm-down">
                            {{ Html::image(Auth::user()->avatar_small, 'Avatar', ['class' => 'rounded-circle img-thumbnail']) }}
                        </div>
                        <div class="discuss-conversation-comment-content">
                            {!! Form::open(['route' => 'discuss.post.create']) !!}
                                {!! Form::hidden('conversation_id', $conversation->id) !!}

                                {!! Form::bsTextarea('content', false, old('message'), [
                                    'placeholder' => 'Votre message ici...',
                                    'required' => 'required',
                                    'editor' => 'commentEditor',
                                    'style' => 'display:none;'
                                ]) !!}

                                @permission ('manage.discuss.conversations')
                                    <div class="form-group">
                                        <h5 class="text-muted">
                                            Modération
                                        </h5>
                                    </div>

                                    {!! Form::bsCheckbox(
                                        'is_locked',
                                        null,
                                        $conversation->is_locked,
                                        'Cochez pour verrouiller cette discussion',
                                        [
                                            'label' => 'Verouiller ?',
                                            'labelClass' => 'custom-control custom-checkbox d-block'
                                        ]
                                    ) !!}

                                    {!! Form::bsCheckbox(
                                        'is_pinned',
                                        null,
                                        $conversation->is_pinned,
                                        'Cocher pour épingler cette discussion',
                                        [
                                            'label' => 'Epingler ?',
                                            'labelClass' => 'custom-control custom-checkbox d-block'
                                        ]
                                    ) !!}
                                @endpermission

                                {!! Form::button('<i class="fa fa-pencil" aria-hidden="true"></i> ' . 'Répondre', ['type' => 'submit', 'class' => 'btn btn-outline-primary']) !!}
                            {!! Form::close() !!}
                        </div>
                    </div>
                @else
                    <div class="alert alert-primary" role="alert">
                        <i class="fa fa-exclamation" aria-hidden="true"></i>
                        'Vous devez être connecté pour commenter cette discussion!'
                    </div>
                @endauth
            @endif
        </div>
    </div>
</div>

{{-- Edit Conversation Modal --}}
<div class="modal fade" id="editDiscussionModal" tabindex="-1" role="dialog" aria-labelledby="editDiscussionModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editDiscussionModalLabel">
                    <i class="fa fa-pencil" aria-hidden="true"></i>
                    Editer cette discussion
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fermer">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            {!! Form::model($conversation, [
                'route' => ['discuss.conversation.update', 'id' => $conversation->id, 'slug' => $conversation->slug],
                'method' => 'put'
            ]) !!}
                <div class="modal-body">
                    {!! Form::bsText(
                        'title',
                        null,
                        null,
                        [
                            'required' => 'required',
                            'placeholder' => 'Titre de la Discussion...'
                        ]
                    ) !!}

                    {!! Form::bsSelect(
                        'category_id',
                        $categories,
                        'Categorie',
                        null,
                        ['required' => 'required']
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
                            null,
                            'Cochez pour verrouiller cette discussion',
                            [
                                'label' => 'Verrouiller ?',
                                'labelClass' => 'custom-control custom-checkbox d-block'
                            ]
                        ) !!}

                        {!! Form::bsCheckbox(
                            'is_pinned',
                            null,
                            null,
                            'Cocher pour épingler cette discussion',
                            [
                                'label' => 'Epingler ?',
                                'labelClass' => 'custom-control custom-checkbox d-block'
                            ]
                        ) !!}
                    @endpermission
                </div>


                <div class="modal-actions">
                    {!! Form::button('<i class="fa fa-pencil" aria-hidden="true"></i> ' . 'Editer', ['type' => 'submit', 'class' => 'ma ma-btn ma-btn-primary']) !!}
                    <button type="button" class="ma ma-btn ma-btn-success" data-dismiss="modal">
                        <i class="fa fa-times" aria-hidden="true"></i>
                        Fermer
                    </button>
                </div>

            {!! Form::close() !!}
        </div>
    </div>
</div>

{{-- Delete Conversation Modal --}}
<div class="modal fade" id="deleteDiscussionModal" tabindex="-1" role="dialog" aria-labelledby="deleteDiscussionModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteDiscussionModalLabel">
                    <i class="fa fa-trash" aria-hidden="true"></i>
                    Supprimer cette discussion
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fermer">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            {!! Form::model($conversation, [
                'route' => ['discuss.conversation.delete', 'id' => $conversation->id, 'slug' => $conversation->slug],
                'method' => 'delete'
            ]) !!}
                <div class="modal-body">
                    <div class="form-group">
                        <p>
                            Voulez-vous vraiment supprimer cette discussion? <strong>Cette opération n'est pas réversible.</strong>
                        </p>
                    </div>
                </div>


                <div class="modal-actions">
                    {!! Form::button('<i class="fa fa-trash" aria-hidden="true"></i> ' . 'Oui, je confirme !', ['type' => 'submit', 'class' => 'ma ma-btn ma-btn-danger']) !!}
                    <button type="button" class="ma ma-btn ma-btn-success" data-dismiss="modal">
                        <i class="fa fa-times" aria-hidden="true"></i>
                        Fermer
                    </button>
                </div>

            {!! Form::close() !!}
        </div>
    </div>
</div>

{{-- Delete Post Modal --}}
<div class="modal fade" id="deletePostModal" tabindex="-1" role="dialog" aria-labelledby="deletePostModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deletePostModalLabel">
                    <i class="fa fa-trash" aria-hidden="true"></i>
                    Supprimer le message
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fermer">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            {!! Form::open([
                'route' => ['discuss.post.delete', 'id' => $post->id],
                'method' => 'delete',
                'id' => 'deletePostForm'
            ]) !!}

                <div class="modal-body">
                    <div class="form-group">
                        <p>
                            Voulez-vous vraiment supprimer ce message? <strong>Cette opération n'est pas réversible.</strong>
                        </p>
                    </div>
                </div>

                <div class="modal-actions">
                    {!! Form::button('<i class="fa fa-trash" aria-hidden="true"></i> ' . 'Oui, je confirme !', ['type' => 'submit', 'class' => 'ma ma-btn ma-btn-danger']) !!}
                    <button type="button" class="ma ma-btn ma-btn-success" data-dismiss="modal">
                        <i class="fa fa-times" aria-hidden="true"></i>
                        Fermer
                    </button>
                </div>

            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection