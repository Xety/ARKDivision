<ol class="list-unstyled discuss-categories">
    <li>
        <a href="{{ route('discuss.index') }}" class="discuss-categories-link font-xeta">
            <i class="fa fa-newspaper-o text-primary"></i> Toutes les discussions
        </a>
    </li>
    <li>
        <a href="{{ route('discuss.category.index') }}" class="discuss-categories-link font-xeta">
            <i class="far fa-list-alt text-primary"></i> Toutes les catégories
        </a>
    </li>
    <!-- <li>
        <a href="#" class="discuss-categories-link font-xeta">
            <i class="fa fa-comments-o text-primary"></i> Most Commented
        </a>
    </li> -->
</ol>
<ol class="list-unstyled discuss-categories">
    @forelse ($categories as $category)
        @if ($category->slug == "annonces")
                <li class="mt-1">
                    <span class="discuss-categories-link text-muted">
                    <span class="discuss-categories-color" style="background-color: transparent;"></span>
                    Division
                    </span>
                </li>
            @endif
        @if ($category->slug == "aberration")
            <li class="mt-1">
                <span class="discuss-categories-link text-muted">
                <span class="discuss-categories-color" style="background-color: transparent;"></span>
                Maps
                </span>
            </li>
        @endif
        @if ($category->slug == "horssujet")
                <li class="mt-1">
                    <span class="discuss-categories-link text-muted">
                    <span class="discuss-categories-color" style="background-color: transparent;"></span>
                    Autres
                    </span>
                </li>
            @endif
        <li>
            <a href="{{ $category->category_url }}" class="discuss-categories-link font-xeta" data-toggle="tooltip" title="{{ $category->description }}">
                <span class="discuss-categories-color" style="background-color: {{ $category->color }};"></span>
                @if (!is_null($category->icon))
                    <i class="{{ $category->icon }}"></i>
                @endif
                {{ $category->title }}
            </a>
        </li>
    @empty
        <li>
            Il n'y a pas encore de catégories.
        </li>
    @endforelse

    @if ($categories->count() >= config('xetaravel.discuss.categories_sidebar'))
        <li>
            <a href="{{ route('discuss.category.index') }}" class="discuss-categories-link font-xeta">
                <span class="discuss-categories-color" style="background-color: transparent"></span>
                Plus...
            </a>
        </li>
    @endif
</ol>