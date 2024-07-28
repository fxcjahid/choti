<article role="article" class="flex gap-x-4 border-b-2 p-4 hover:border-slate-100 hover:shadow-md">
    @if ($post->image())
        <img src="{{ $post->image() }}" class="relative z-0 lg:h-60 lg:max-w-xs rounded-md object-cover"
            alt="{{ $post->name }}">
    @endif

    <div class="mt-3 px-2">
        <a href="{{ $post->url() }}">
            <h1 role="title" title="Find the bedbug nest (bedbug hiding places)"
                class="ellipsis text-lg font-semibold text-slate-900 hover:text-blue-900 dark:text-white md:text-2xl">
                {{ $post->name }}
            </h1>
        </a>
        <date class="mt-0.5 text-sm text-gray-500 dark:text-gray-400">
            September 12, 2022
        </date>
        <p role="description" class="ellipsis line-clamp-4 my-1 lg:mt-2 text-slate-700 dark:text-white">
            {{ $post->summary }}
        </p>
        <a href="{{ $post->url() }}"
            class="mt-1 inline-flex items-center gap-x-1 text-blue-600 decoration-2 hover:underline font-medium">
            Read more
            <svg class="flex-shrink-0 w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round">
                <path d="m9 18 6-6-6-6"></path>
            </svg>
        </a>
    </div>
</article>
