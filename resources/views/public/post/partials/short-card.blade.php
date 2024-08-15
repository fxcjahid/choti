<article role="article">
    @php
        $category = !empty($post->category[0]->slug) ? $post->category[0]->slug : 'draft';
        $slug = route('post.show', [$category, $post->slug]);
    @endphp

    <a class="group rounded overflow-hidden dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600"
        href="{{ $slug }}">
        <div class="sm:flex">
            <div class="flex-shrink-0 relative rounded overflow-hidden w-full sm:w-40 h-28">
                @php
                    $thumbnail = !empty(isset($post->thumbnail[0]->medium))
                        ? $post->thumbnail[0]->medium
                        : asset('/assets/public/img/thumbnail-placeholder.png');
                @endphp
                <img class="group-hover:scale-105 transition-transform duration-500 ease-in-out w-full h-full absolute top-0 start-0 object-cover rounded"
                    src="{{ $thumbnail }}" alt="{{ $post->name }}">
            </div>

            <div class="grow mt-4 sm:mt-0 sm:ms-6 px-4 sm:px-0">
                <h3
                    class="text-xl font-semibold text-gray-800 group-hover:text-gray-600 dark:text-gray-300 dark:group-hover:text-white">
                    {{ $post->name }}
                </h3>
                <time class="mt-3 text-gray-600 dark:text-gray-400">
                    September 12, 2022
                </time>
                <summary
                    class="mt-4 inline-flex items-center gap-x-1 text-blue-600 decoration-2 hover:underline font-medium">
                    Read more
                    <svg class="flex-shrink-0 w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="m9 18 6-6-6-6" />
                    </svg>
                </summary>
            </div>
        </div>
    </a>
</article>
