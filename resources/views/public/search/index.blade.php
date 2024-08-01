@extends('public.app')

@section('title', "Search Results for \"$query\"")
@section('canonical', route('search.index'))

@section('content')

    <!-- breadcrums -->
    {{-- @include('public.post.utility.breadcrumbs', [
        'breadcrumbs' => [
            // [
            //     'title' => 'series',
            //     'url' => route('series'),
            // ],
            [
                'title' => $series->name,
                'url' => route('series', ['series' => $series->slug]),
            ],
        ],
    ]) --}}


    <section role="content">

        {{-- @include('public.post.utility.breadcrumbs', [
            'breadcrumbs' => $breadcrumb,
        ]) --}}

        <div class="padding-responsive bg-gray-200 py-10 dark:bg-gray-800 2xl:m-auto 2xl:max-w-screen-2xl">
            <div class="flex flex-row rounded bg-white dark:bg-slate-900">
                <div class="w-full md:w-[70%]" aria-label="content">

                    <div class="m-auto">
                        <div class="relative mt-8 sm:mx-6 sm:mb-8">
                            <form action="{{ route('search.index') }}" method="GET">
                                <span class="absolute inset-y-0 left-0 flex cursor-pointer items-center pl-3">
                                    <svg class="h-5 w-5 text-gray-400" viewBox="0 0 24 24" fill="none">
                                        <path
                                            d="M21 21L15 15M17 10C17 13.866 13.866 17 10 17C6.13401 17 3 13.866 3 10C3 6.13401 6.13401 3 10 3C13.866 3 17 6.13401 17 10Z"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round">
                                        </path>
                                    </svg>
                                </span>

                                <input type="search"
                                    class="w-full rounded-md border text-xl bg-white py-3 pl-10 pr-[140px] text-gray-700 border-gray-200 outline-none transition-all focus:border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300"
                                    name="query" value="{{ request()->query('query') }}"
                                    placeholder="{{ trans('search.title') }}">

                                <button type="submit"
                                    class="text-white absolute right-0 top-0 h-full bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded text-lg px-7 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                    {{ trans('search.search_submit') }}
                                </button>
                            </form>
                        </div>
                    </div>

                    @if (!$results->isEmpty())
                        <div class="m-auto">
                            <h1 class="text-2xl font-semibold mx-3 sm:mx-6 my-3">
                                সার্চ রেজাল্টস: "{{ $query }}"
                            </h1>
                        </div>
                    @endif

                    <!-- Results -->
                    <div class="space-y-6 my-3 md:my-6 mx-3 sm:mx-6">
                        @forelse ($results as $result)
                            @include('public.search.results')
                        @empty
                            <p class="text-gray-800 text-xl">কোন গল্প পাওয়া যায়নি.</p>
                        @endforelse
                    </div>

                    <div class="my-3 md:my-6 mx-3 sm:mx-6">
                        {{ $results->appends(['query' => $query])->links('pagination::tailwind') }}
                    </div>

                </div>

                <aside class="hidden w-full border-l border-solid border-l-gray-100 md:block md:w-[30%]">
                    <div class="my-7 px-5">
                        <h2
                            class="ellipsis my-2.5 text-lg font-semibold text-slate-900 hover:text-blue-900 dark:text-white md:text-2xl">
                            আরও গল্প দেখুন
                        </h2>
                        <ul class="my-1 ml-3 list-none">
                            @foreach ($category as $category)
                                <li class="mb-1.5">
                                    <a href="{{ $category->url() }}"
                                        class="text-slate-800 hover:text-blue-900 text-lg lg:text-xl">
                                        {{ $category->name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </aside>
            </div>
        </div>
    </section>

@endsection
