@props([
    'article',
    'isSummary' => false,
    'iconLink' => false,
])

<div
    @class([
        'space-y-6',
        'lg:grid lg:grid-cols-3 lg:items-start lg:gap-6 lg:space-y-0' => $isSummary,
    ])
>
    <a href="{{ route('articles.show', $article) }}" class="group">
        <div class="aspect-w-3 aspect-h-2">
            <img class="object-cover rounded-lg shadow-lg group-hover:opacity-75" src="{{ $article->getFirstMediaUrl('media') }}" alt="{{ $article->title }}" onerror="this.onerror=null;this.src='{{ getAvatar($article->title) }}'" />
        </div>
    </a>
    <div
        @class([
            'space-y-4',
            'sm:col-span-2' => $isSummary,
        ])
    >
        <div>
            <time datetime="{{ $article->publishedAt()->format('Y-m-d') }}" class="font-sans text-sm leading-5 capitalize text-skin-base">
                {{ $article->publishedAt()->isoFormat('LL') }}
            </time>
            <a href="{{ route('articles.show', $article) }}" class="flex items-center justify-between mt-2 group">
                <h4 class="font-sans text-lg font-semibold leading-6 text-skin-inverted group-hover:text-skin-primary">
                    {{ $article->title }}
                </h4>
                @if($iconLink)
                    <x-untitledui-link-external-01 class="w-5 h-5 ml-2 text-skin-base" />
                @endif
            </a>
            <p class="mt-1 font-normal leading-6 text-skin-base">
                {!! $article->excerpt(150) !!}
            </p>
        </div>
        <div class="flex items-center space-x-3">
            @if ($article->tags->isNotEmpty())
                <div class="flex items-center space-x-2">
                    @foreach ($article->tags as $tag)
                        <x-tag :tag="$tag" />
                    @endforeach
                </div>
            @endif
            <x-articles.sponsored :isSponsored="$article->isSponsored()" />
        </div>
    </div>
</div>
