<article
    class="post-containter mb-9 justify-between rounded-xl border bg-white shadow-sm transition hover:shadow-md hover:shadow-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:shadow-slate-700/[.7] sm:flex">

    <div class="my-5 mx-4 md:mx-8 h-60 w-auto flex-shrink-0 rounded-t-xl md:h-36 md:w-36 lg:h-40 lg:w-40">
        <a href="{{ route('public.mystory.edit', ['id' => urldecode(base64_encode($post->id))]) }}">
            <img class="h-full w-full rounded-xl object-cover"
                src="{{ $post->image() ?? asset('/assets/public/img/thumbnail-placeholder.png') }}" alt="thumbnail">
        </a>
    </div>

    <div class="flex w-full flex-wrap">
        <div class="flex h-full flex-col md:py-6 px-4 md:px-0">
            <a href="{{ route('public.mystory.edit', ['id' => urldecode(base64_encode($post->id))]) }}"
                class="text-lg font-bold text-gray-800 hover:text-blue-800 dark:text-white">
                {{ $post->title }}
            </a>

            <div class="mt-5 flex items-center sm:mt-auto">
                <div class="text-sm capitalize text-gray-500 dark:text-gray-500">
                    {{ $post->status }}
                </div>
                <div class="hs-tooltip -mt-1 inline-block">
                    <div class="hs-tooltip-toggle inline-flex">
                        <div
                            class="before-point relative ml-4 flex items-center pl-[20px] text-sm text-gray-500 dark:text-gray-500">
                            {{ $post->created_at->format('d M, Y') }}
                        </div>
                        <span
                            class="hs-tooltip-content invisible absolute z-10 inline-block rounded-md bg-gray-900 py-1 px-2 text-xs font-medium text-white opacity-0 shadow-sm transition-opacity hs-tooltip-shown:visible hs-tooltip-shown:opacity-100 dark:bg-slate-700"
                            role="tooltip">
                            {{ $post->created_at->format('h:i A,  d-M-Y') }}
                            |
                            {{ $post->created_at->diffForHumans() }}
                        </span>
                    </div>
                </div>
            </div>
            <div class="mt-1">
                <div class="hs-tooltip inline-block">
                    <div class="hs-tooltip-toggle inline-flex">
                        <div class="text-sm text-gray-500 dark:text-gray-500">
                            লাস্ট আপডেটঃ {{ $post->updated_at->diffForHumans() }}
                        </div>
                        <span
                            class="hs-tooltip-content invisible absolute z-10 rounded-md bg-gray-900 py-1 px-2 text-xs font-medium text-white opacity-0 shadow-sm transition-opacity hs-tooltip-shown:visible hs-tooltip-shown:opacity-100 dark:bg-slate-700 hidden"
                            role="tooltip">
                            {{ $post->created_at->format('h:i A,  d-M-Y') }}
                        </span>
                    </div>
                </div>
            </div>
            <div class="mt-4 md:mt-auto">
                <div class="flex justify-start gap-2 flex-wrap">
                    @foreach ($post->tag as $tag)
                        <span
                            class="inline-flex items-center gap-1.5 rounded-full bg-gray-50 py-1.5 px-3 text-xs font-medium text-gray-500">
                            {{ $tag->name }}
                        </span>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="tools md:flex flex-wrap">
        <div class="flex space-y-3 h-full flex-wrap py-2 mr-4 md:py-4 px-2 transition-all">
            <!-- tools -->
            @if ($post->status == 'publish')
                <div class="post-tools-hover-disable mt-auto w-full transition">
                    <div class="flex justify-center gap-5 w-28 rounded-full -md:mx-3 -md:mt-2 p-2 shadow">
                        <div class="cursor-pointer p-1 text-gray-500">
                            <a href="{{ $post->url() }}" target="_blank">
                                View Post
                            </a>
                        </div>
                    </div>
                </div>
            @endif

            <!-- statics -->
            <div class="flex mt-auto mb-3 w-full whitespace-nowrap justify-end gap-4">
                <div class="flex gap-1 items-center">
                    <div class="text-gray-700" aria-lavel="comment">
                        0
                    </div>

                    <svg xmlns="http://www.w3.org/2000/svg" height="18px" viewBox="0 -960 960 960" width="18px"
                        fill="#374151">
                        <path
                            d="M880-80 720-240H160q-33 0-56.5-23.5T80-320v-480q0-33 23.5-56.5T160-880h640q33 0 56.5 23.5T880-800v720ZM160-320h594l46 45v-525H160v480Zm0 0v-480 480Z" />
                    </svg>
                </div>
                <div class="flex gap-1 items-center">
                    <div class="text-gray-700" aria-lavel="views">0</div>

                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"
                        fill="#374151">
                        <path
                            d="m192-202-3.46-68.69L254-335.77V-202h-62Zm136 0v-207.77l46-46 6 6V-202h-52Zm126 0v-193.77l52 52V-202h-52Zm126 0v-171.77l52-52V-202h-52Zm126 0v-297.77l52-52V-202h-52ZM202-402.23v-73.54l182-182 144 144 230-230v73.54l-230 230-144-144-182 182Z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>
</article>
