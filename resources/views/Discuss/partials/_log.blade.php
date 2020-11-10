<div class="discuss-conversation discuss-conversation-log discuss-conversation-log-{{ $log->type }}">
    <span class="discuss-conversation-log-icon">
        @if ($log->type == 'category')
            <i class="fa fa-tag"></i>
        @elseif ($log->type == 'title')
            <i class="fa fa-pencil"></i>
        @elseif ($log->type == 'locked')
            <i class="fa fa-lock"></i>
        @elseif ($log->type == 'pinned')
            <i class="fa fa-thumb-tack"></i>
        @elseif ($log->type == 'deleted')
            <i class="fa fa-trash"></i>
        @endif
    </span>
    <img src="{{ $log->user->avatar_small }}" class="rounded-circle" />
    <discuss-user
        :user="{{ json_encode($log->user) }}"
        :created-at="{{ var_export($log->user->created_at->diffForHumans()) }}"
        :last-login="{{ var_export($log->user->last_login->diffForHumans()) }}"
        :background-color="{{ var_export($log->user->avatar_primary_color) }}">
    </discuss-user>

    @php
    $time = "<time datetime=\"{$log->created_at->format('c')}\" data-toggle=\"tooltip\" title=\"{$log->created_at->format('c')}\">{$log->created_at->diffForHumans()}</time>";
    @endphp

    {{-- Category Changed --}}
    @if ($log->type == 'category')
        a ajouté la catégorie
        <a href="{{ route('discuss.category.show', ['slug' => $log->newCategory->slug, 'id' => $log->newCategory->id]) }}" class="tag tag-default text-white" style="background-color: {{ $log->newCategory->color }};">
            {{ $log->newCategory->title }}
        </a>
        et supprimé
        <a href="{{ route('discuss.category.show', ['slug' => $log->oldCategory->slug, 'id' => $log->oldCategory->id]) }}" class="tag tag-default text-white" style="background-color: {{ $log->oldCategory->color }};">
            {{ $log->oldCategory->title }}
        </a>
        {!! $time !!}

    {{-- Title Changed --}}
    @elseif ($log->type == 'title')
        a changé le titre
        <strong>{{ $log->data['old'] }}</strong>
        en
        <strong>{{ $log->data['new'] }}</strong>
        {!! $time !!}

    {{-- Conversation Locked --}}
    @elseif ($log->type == 'locked')
         a verrouillé la discussion
        {!! $time !!}

    {{-- Conversation Pinned --}}
    @elseif ($log->type == 'pinned')
        a épinglé la discussion
        {!! $time !!}

    {{-- Post Deleted --}}
    @elseif ($log->type == 'deleted')
        a supprimé un commentaire de
        <discuss-user
            :user="{{ json_encode($log->postUser) }}"
            :created-at="{{ var_export($log->postUser->created_at->diffForHumans()) }}"
            :last-login="{{ var_export($log->postUser->last_login->diffForHumans()) }}"
            :background-color="{{ var_export($log->postUser->avatar_primary_color) }}">
        </discuss-user>

        {!! $time !!}
    @endif
</div>