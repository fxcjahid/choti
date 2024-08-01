<div class="m-auto">
    <div class="relative mt-8 sm:mx-6 sm:mb-8">
        <form action="{{ route('search.index') }}" method="GET">
            <span class="absolute inset-y-0 left-0 flex cursor-pointer items-center pl-3">
                <svg class="h-5 w-5 text-gray-400" viewBox="0 0 24 24" fill="none">
                    <path
                        d="M21 21L15 15M17 10C17 13.866 13.866 17 10 17C6.13401 17 3 13.866 3 10C3 6.13401 6.13401 3 10 3C13.866 3 17 6.13401 17 10Z"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    </path>
                </svg>
            </span>

            <input type="search"
                class="w-full rounded-md border text-lg bg-white py-2 pl-10 text-gray-700 border-gray-200 outline-none transition-all focus:border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300"
                name="query" placeholder="{{ trans('search.title') }}">
        </form>
    </div>
</div>
