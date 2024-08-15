<article class="mb-5 pb-1 mt-1 group last:border-none border-b border-gray-300" role="related-articles">
    <a href="{{ $post->url() }}" itemprop="related-post" content="{{ $post->url() }}"
        class="text-gray-900 hover:text-blue-900">
        @if ($post->image())
            <img src="{{ $post->image() }}"
                class="mb-5 h-48 max-h-48 w-full md:mr-4 md:float-left md:max-w-[210px] rounded-lg object-cover"
                alt="{{ $post->title }}">
        @endif
        <h3 aria-label="title"
            class="ellipsis mb-2 text-xl font-semibold leading-tight text-gray-900 hover:text-blue-900 dark:text-white">
            {{ $post->title }}
        </h3>
        <summary aria-label="summary"
            class="ellipsis mb-3 line-clamp-4 group-hover:text-blue-900 text-base text-gray-700 dark:text-gray-400">
            {{ $post->summary }}
        </summary>
    </a>
</article>
