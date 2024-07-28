<article class="mb-1" role="related-articles">
    <a href="{{ $post->url() }}" class="text-gray-900 hover:text-blue-900">
        @if ($post->image())
            <img src="{{ $post->image() }}" class="mb-5 h-48 max-h-48 w-full rounded-lg object-cover"
                alt="{{ $post->name }}">
        @endif
        <h2 class="ellipsis mb-2 text-xl font-bold leading-tight text-gray-900 hover:text-blue-900 dark:text-white">
            {{ $post->name }}
        </h2>
        <p aria-label="description" class="ellipsis mb-4 line-clamp-4 text-base text-gray-700 dark:text-gray-400">
            {{ $post->summary }}
        </p>
    </a>
</article>
